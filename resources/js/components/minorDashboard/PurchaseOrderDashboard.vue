<template>
  <div class="minordas">
    <div class="statustitle">
      <h5 class="ml-2">{{ status }}</h5>
    </div>
    <!-- top status tab -->
    <div class="toptab d-flex position-relative">
      <div
        :class="getCurrentPage() === 'all' ? 'tabwithvalue ml-2' : 'ml-2'"
        @click="updateAction('all')"
      >
        <div class="actualtab">All | {{ getCurrentData().all }}</div>
      </div>
      <div
        :class="getCurrentPage() === 'approved' ? 'tabwithvalue ml-2' : 'ml-2'"
        @click="updateAction('approved')"
      >
        <div class="actualtab">Approved | {{ getCurrentData().approved }}</div>
      </div>
      <div
        :class="getCurrentPage() === 'received' ? 'tabwithvalue ml-2' : 'ml-2'"
        @click="updateAction('received')"
      >
        <div class="actualtab">Received | {{ getCurrentData().received }}</div>
      </div>
      <div
        :class="getCurrentPage() === 'rejected' ? 'tabwithvalue ml-2' : 'ml-2'"
        @click="updateAction('rejected')"
      >
        <div class="actualtab">Rejected | {{ getCurrentData().rejected }}</div>
      </div>
      <div
        :class="getCurrentPage() === 'pending' ? 'tabwithvalue ml-2' : 'ml-2'"
        @click="updateAction('pending')"
      >
        <div class="actualtab">Pending | {{ getCurrentData().pending }}</div>
      </div>
      <!-- Action Buttons Here like add purchase request -->
      <div
        class="actionbutton ml-auto position-absolute"
        :style="{ bottom: '-15px', right: '16px', zIndex: '1' }"
        v-if="actionbtn"
      >
        <v-btn
          class="mr-2"
          color="primary"
          dark
          v-for="btn in actionbtn"
          :key="btn"
        >
          <v-icon>mdi-plus</v-icon>
          {{ btn }}
        </v-btn>
      </div>
    </div>

    <!-- DataTable Container -->
    <div class="datatable-container">
      <v-card>
        <v-card-title>
          <div
            class="input-group md-form form-sm form-2 pl-0"
            :style="{ width: '300px' }"
          >
            <div
              class="input-group-appendr"
              ripple
              :style="{ cursor: 'pointer' }"
            >
              <span
                class="input-group-text red lighten-3"
                id="basic-text1"
                :style="{ height: '35px' }"
                >{{
                  getCurrentPage().charAt(0).toUpperCase() +
                  getCurrentPage().slice(1)
                }}</span
              >
            </div>
            <input
              class="form-control my-0 py-1"
              type="text"
              placeholder="Search"
              aria-label="Search"
              v-model="search"
              single-line
            />
            <div
              class="input-group-appendr"
              ripple
              :style="{ cursor: 'pointer' }"
            >
              <span
                class="input-group-text red lighten-3"
                id="basic-text1"
                :style="{ height: '35px' }"
                ><v-icon>mdi-magnify</v-icon></span
              >
            </div>
          </div>
          <v-btn class="px-2 ml-2 cursor-pointer"
            ><v-icon>mdi-filter-outline</v-icon> filter</v-btn
          >
          <v-spacer></v-spacer>
          <div class="text-center">
            <v-pagination :length="1"></v-pagination>
          </div>
        </v-card-title>
        <v-data-table
          v-model="selected"
          :headers="headers"
          :items="datavalue"
          item-key="id"
          :search="search"
          show-select
          :single-select="singleSelect"
        >
          <template v-slot:item.actions="{ item }">
            <router-link
              :to="'/purchaseOrders/edit/' + item.id"
              v-if="$can('quotations.edit')"
            >
              <v-icon small> mdi-pencil </v-icon>
            </router-link>
            <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
          </template>
          <template v-slot:no-data>
            <div>No Data</div>
          </template>
        </v-data-table>
        <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="text-h6"
                >Are you sure you want to delete this item?</v-card-title
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete"
                  >Cancel</v-btn
                >
                <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                  >OK</v-btn
                >
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
      </v-card>
    </div>
  </div>
</template>
<script>
import ApiServices from "../../services/ApiServices";
import store from "../../store";
export default {
  name: "MinorDashboard",
  data() {
    return {
      status: "",
      actionbtn: [],
      search: "",
      singleSelect: false,
      selected: [],
      headers: [],
      datavalue: [],
      dialogDelete: false,
      dialog: false,
    };
  },
  async created() {
    this.getTableStructure();
  },
  computed: {
    mystate() {
      return store.state.home.current_action;
    },
  },
  methods: {
    getCurrentData() {
      const data = store.getters["home/getTabContent"];
      const all = data.approved + data.pending + data.rejected;
      return {
        approved: data.approved,
        received: data.received,
        rejected: data.rejected,
        pending: data.pending,
        all: all,
      };
    },
    getCurrentTab() {
      return store.getters["home/getTabContent"];
    },
     editItem(item) {
            this.editedIndex = this.datavalue.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
    // Show delete popup
    deleteItem(item) {
      this.editedIndex = this.datavalue.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    //confirm delete
    async deleteItemConfirm() {
      let res = await ApiServices.purchaseOrderDelete(this.editedItem.id);
      if (res.success === true) {
        this.datavalue.splice(this.editedIndex, 1);
      }
      this.closeDelete();
    },
    //close delete popup
    closeDelete() {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },
    async getTableStructure() {
      this.status = "Purchase Order Status";
      this.actionbtn = ["Add New PO", "Add from AQ"];
      this.headers[0] = {
        text: "Reference No.",
        align: "start",
        value: "reference",
      };
      this.headers[1] = {
        text: "Department",
        align: "start",
        value: "dept_id",
      };
      this.headers[2] = {
        text: "Date of Order",
        align: "start",
        value: "date_of_order",
      };
      this.headers[3] = {
        text: "Requester",
        align: "start",
        value: "requester",
      };
      this.headers[4] = {
        text: "Supplier",
        align: "start",
        value: "supplier",
      };
      this.headers[5] = {
        text: "Status",
        align: "start",
        value: "status",
      };
      this.headers[6] = {
        text: "Actions",
        align: "start",
        value: "actions",
      };
      let res = await ApiServices.purchaseOrderIndex();
      //Retreving all data
      if (store.state.home.current_action == "all") {
        if (res.success == true) {
          this.datavalue = res.data;
        }
      }
      // Retrieving only approved data
      if (store.state.home.current_action == "approved") {
        if (res.success == true) {
          const data = res.data.filter((item) => item.status == "Approved");
          this.datavalue = data;
        }
      }
      // Retrieving only pending data
      if (store.state.home.current_action == "pending") {
        if (res.success == true) {
          const data = res.data.filter((item) => item.status == "Pending");
          this.datavalue = data;
        }
      }
      // Retrieving only rejected data
      if (store.state.home.current_action == "rejected") {
        if (res.success == true) {
          const data = res.data.filter((item) => item.status == "Rejected");
          this.datavalue = data;
        }
      }
      // Retrieving only received data
      if (store.state.home.current_action == "received") {
        if (res.success == true) {
          const data = res.data.filter((item) => item.status == "Received");
          this.datavalue = data;
        }
      }
    },
    getCurrentPage() {
      return store.state.home.current_action;
    },
    async updateAction(action) {
      store.state.home.current_action = action;
    },
  },
  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
    mystate: function (newValue, oldValue) {
      this.getTableStructure();
    },
  },
};
</script>
