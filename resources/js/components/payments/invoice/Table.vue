
<template>
        <div>
        <div class="statustitle">
      <h5 class="ml-2">{{ status }}</h5>
    </div>
    <!-- top status tab -->
    <div class="toptab d-flex position-relative">
      <div
        :class="getCurrentPage() === 'all' ? 'tab_all ml-2' : 'ml-2'"
        @click="updateAction('all')"
      >
        <div class="actualtab" :style="{color:`${getTabColor().all}`}" >All | {{ getCurrentData().all?getCurrentData().all:0 }}</div>
      </div>
      <div
        :class="getCurrentPage() === 'approved' ? 'tab_approved ml-2' : 'ml-2'"
        @click="updateAction('approved')"
      >
        <div class="actualtab" :style="{color:`${getTabColor().approved}`}">Paid | {{ getCurrentData().paid?getCurrentData().paid:0 }}</div>
      </div>
      <div
        :class="getCurrentPage() === 'received' ? 'tab_pending ml-2' : 'ml-2'"
        @click="updateAction('received')"
      >
        <div class="actualtab" :style="{color:`${getTabColor().pending}`}">Partially Paid | {{ getCurrentData().partially_paid?getCurrentData().partially_paid:0 }}</div>
      </div>
      <div
        :class="getCurrentPage() === 'rejected' ? 'tab_rejected ml-2' : 'ml-2'"
        @click="updateAction('rejected')"
      >
        <div class="actualtab" :style="{color:`${getTabColor().rejected}`}">Unpaid | {{ getCurrentData().unpaid?getCurrentData().unpaid:0 }}</div>
      </div>
    </div>

    <v-card>
        <v-data-table
            v-model="selected"
            :headers="headers"
            :items="invoices"
            sort-by="id"
            :loading=tableLoad
            loading-text="Loading... Please wait..."
            :search="search"
        >

            <template v-slot:top="{ pagination, options, updateOptions }">
                <v-toolbar
                    flat
                >
                    <v-row :style="{width:'100%', overflow:'none'}" class="mt-2">
                           <div
          class="input-group md-form form-sm form-2 pl-0 ml-3"
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
            solo
            hide-details
            max-width="100px"
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
        <v-btn class="px-2 ml-2 cursor-pointer" v-if="selected.length!=0"
          ><v-icon>mdi-dots-vertical</v-icon></v-btn
        >
         <v-spacer></v-spacer>
          <v-data-footer
          :pagination="pagination"
          :options="options"
          @update:options="updateOptions"
          items-per-page-text="$vuetify.dataTable.itemsPerPageText"/>
                    </v-row>

                    <v-dialog v-model="dialogDelete" max-width="500px">
                        <v-card>
                            <v-card-title class="text-h6">{{ $t('message.delete') }}</v-card-title>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="closeDelete">{{ $t('button.cancel') }}</v-btn>
                                <v-btn color="blue darken-1" text @click="deleteItemConfirm">{{
                                        $t('button.confirm')
                                    }}
                                </v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>
            <template v-slot:item.payment_id="{ item }">
                <p v-if="item.payment_id" class="mt-3">{{ item.payment_reference }}</p>
                <p v-else class="mt-3">----</p>
            </template>
            <template v-slot:item.issued_by="{ item }">
                <p v-if="item.issued_by" class="mt-3">{{ item.issuer.name }}</p>
                <p v-else class="mt-3">----</p>
            </template>
            <template v-slot:item.paid_to="{ item }">
                <p v-if="item.paid_to" class="mt-3">{{ item.vendor.name }}</p>
                <p v-else class="mt-3">----</p>
            </template>
            <template v-slot:item.actions="{ item }">
                <router-link
                    :to="'/products/'+item.id"
                    v-if="$can('products.show')"
                >
                    <v-icon
                        small
                    >
                        mdi-eye
                    </v-icon>
                </router-link>
                <v-icon
                    small
                    @click="deleteItem(item)"
                    v-if="$can('products.delete')"
                >
                    mdi-delete
                </v-icon>
            </template>
            <template v-slot:no-data>
                <div>No Data</div>
            </template>
        </v-data-table>
    </v-card>
    </div>
</template>

<script>
import config from "../../../config";
import store from "../../../store";
import i18n from "../../../i18n";
import ApiServices from "../../../services/ApiServices";

export default {
    name: "TableWrapper",
    data: () => ({
        cdnURL: config.cdnURL,
        baseURL: config.baseURL,
        search: '',
        status: "",
        singleSelect: false,
        selected: [],
        validated: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        headers: [
            {text: i18n.t('Id'), align: 'start', sortable: true, value: 'id'},
            {text: i18n.t('Reference') + ' ' + i18n.t('no.'), value: 'reference_no'},
            {text: i18n.t('Payment') + ' ' + i18n.t('reference'), value: 'payment_id'},
            {text: i18n.t('Amount'), value: 'amount'},
            {text: i18n.t('Issued By'), value: 'issued_by', sortable: false},
            {text: i18n.t('Paid To'), value: 'paid_to', sortable: false},
            {text: i18n.t('Payment Type'), value: 'payment_type'},
            {text: i18n.t('Actions'), value: 'actions', sortable: false},
        ],
        invoices: [],
        editedIndex: -1,
        editedItem: {
            id: null,
            name: '',
            brand_id: '',
            category_id: '',
            details: '',
            is_active: '',
            image: [],
        },
        tableLoad: true
    }),
    computed:{
         mystate() {
      return store.state.home.current_action;
    },
    },

    watch: {
        mystate: function (newValue, oldValue) {
      this.getTableStructure();
    },
        dialogDelete(val) {
            val || this.closeDelete()
        },
    },

    async created() {
        this.getTableStructure();
        // this.loadItems();
    },

    methods: {
        getTabColor(){
            const color= store.getters['home/getColor']
            return color;
        },
         getCurrentData() {
      const data = store.getters["home/getTabContent"];
      const all = data.paid + data.partially_paid + data.unpaid;
      return {
        paid: data.paid,
        partially_paid: data.partially_paid,
        unpaid: data.unpaid,
        all: all,
      };
    },
     async getTableStructure() {
      this.status = i18n.t("Invoice Status");
      // Perform API call here
      let res = await ApiServices.invoiceIndex();
      //Retreving all data
      if (store.state.home.current_action == "all") {
        if (res.success == true) {
          this.tableLoad = false;
          this.invoices = res.data;
        }
      }
      // Retrieving only approved data
      if (store.state.home.current_action == "approved") {
        if (res.success == true) {
          const data = res.data.filter((item) => item.status == "Approved");
          this.tableLoad = false;
                this.invoices = data;
        }
      }
      // Retrieving only pending data
      if (store.state.home.current_action == "pending") {
        if (res.success == true) {
          const data = res.data.filter((item) => item.status == "Pending");
          this.tableLoad = false;
                this.invoices = data;
        }
      }
      // Retrieving only rejected data
      if (store.state.home.current_action == "rejected") {
        if (res.success == true) {
          const data = res.data.filter((item) => item.status == "Rejected");
          this.tableLoad = false;
                this.invoices = data;
        }
      }
      // Retrieving only received data
      if (store.state.home.current_action == "received") {
        if (res.success == true) {
          const data = res.data.filter((item) => item.status == "Received");
          this.tableLoad = false;
                this.invoices = data;
        }
      }
    },
    getCurrentPage() {
      return store.state.home.current_action;
    },
    async updateAction(action) {
      store.state.home.current_action = action;
    },
        async loadItems() {
            let res = await ApiServices.invoiceIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.invoices = res.data;
            }
        },

        deleteItem(item) {
            this.editedIndex = this.products.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.productDelete(this.editedItem.id);
            if (res.success === true) {
                this.products.splice(this.editedIndex, 1)
            }
            this.closeDelete()
        },

        closeDelete() {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },
    },
}
</script>


<style scoped>
.theme--light.v-data-table .v-data-footer {
    border-top: none;
}
.v-data-footer{
  width: 290px;
}
.tab_approved {
    overflow: hidden;
    display: inline;
    color: rgb(25, 135, 84);
    border: 1px solid rgb(25, 135, 84);
}
.tab_received{
    color: rgb(144, 238, 144);
    border: 1px solid rgb(144, 238, 144);
}
.tab_pending{
    color: rgb(249,177,21);
    border: 1px solid rgb(249,177,21);
}
.tab_rejected{
    color: rgb(255, 0, 0);
    border: 1px solid rgb(255, 0, 0);
}
.tab_all{
    color: rgb(60 75 100);
    border: 1px solid rgb(60 75 100);
}
</style>
