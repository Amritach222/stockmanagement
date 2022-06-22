<template>
  <div>
    <div class="statustitle d-flex justify-content-between align-items-center">
      <h5 class="ml-2 text-capitalize">Purchase Status</h5>
        <v-btn
            class="mr-2 d-lg-none d-xl-none d-xxl-none"
            color="primary"
            dark
            :to="'/purchase/new-purchase-request'"
        >
            Add New Purchase Request
        </v-btn>
    </div>
    <!-- top status tab -->
    <div class="toptab d-flex position-relative">
      <div
        :class="getCurrentPage() === 'all' ? 'tab_all ml-2' : 'ml-2'"
        @click="updateAction('all')"
      >
        <div class="actualtab" :style="{color:`${getTabColor().all}`}"  >All | {{ getCurrentData().all?getCurrentData().all:0 }}</div>
      </div>
      <div
        :class="getCurrentPage() === 'approved' ? 'tab_approved ml-2' : 'ml-2'"
        @click="updateAction('approved')"
      >
        <div class="actualtab" :style="{color:`${getTabColor().approved}`}">Approved | {{ getCurrentData().approved?getCurrentData().approved:0 }}</div>
      </div>
      <div
        :class="getCurrentPage() === 'rejected' ? 'tab_rejected ml-2' : 'ml-2'"
        @click="updateAction('rejected')"
      >
        <div class="actualtab" :style="{color:`${getTabColor().rejected}`}">Rejected | {{ getCurrentData().rejected?getCurrentData().rejected:0 }}</div>
      </div>
      <div
        :class="getCurrentPage() === 'pending' ? 'tab_pending ml-2' : 'ml-2'"
        @click="updateAction('pending')"
      >
        <div class="actualtab" :style="{color:`${getTabColor().pending}`}">Pending | {{ getCurrentData().pending?getCurrentData().pending:0 }}</div>
      </div>
      <!-- Action Buttons Here like add purchase request -->
      <div
        class="actionbutton ml-auto position-absolute d-none d-lg-inline-block d-xl-inline-block d-xxl-inline-block"
        :style="{ bottom: '-15px', right: '16px', zIndex: '1' }"
      >
        <v-btn
          class="mr-2"
          color="primary"
          dark
          :to="'/purchase/new-purchase-request'"

        >
          Add New Purchase Request
        </v-btn>
      </div>
    </div>

    <v-card>
            <v-data-table
        :headers="headers"
        :items="purchaseHistory"
        sort-by="id"
        show-expand
        :loading="tableLoad"
        loading-text="Loading... Please wait..."
        :search="search"
      >

        <template  v-slot:top="{ pagination, options, updateOptions }">
          <v-toolbar flat>
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
        <v-btn class="px-2 ml-2 cursor-pointer" @click="openFilter"
          ><v-icon>mdi-filter-outline</v-icon> {{dialogFilter?'Hide Filter ':'Show Filter'}}</v-btn
        >
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


            <v-dialog v-model="dialog" max-width="600px">
              <v-card>
                <v-form ref="form">
                  <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                  </v-card-title>

                  <v-card-text>
                    <v-container>
                      <v-row>
                        <v-col>
                          <v-text-field
                            v-model="editedItem.name"
                            label="Brand Name"
                            required
                            outlined
                            :rules="rules"
                          ></v-text-field>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col v-if="typeof editedItem.link === 'string'">
                          <v-card
                            width="200"
                            v-on:click="openImage(editedItem.link)"
                          >
                            <v-img
                              :src="cdnURL + editedItem.link"
                              height="125"
                              class="grey darken-4"
                            ></v-img>
                            <v-card-title class="title"> Logo </v-card-title>
                          </v-card>
                          <v-file-input
                            v-model="editedItem.image"
                            label="Logo"
                            filled
                            outlined
                            prepend-icon="mdi-camera"
                            accept="image/png,image/jpeg,image/jpg"
                          ></v-file-input>
                        </v-col>
                        <v-col v-else>
                          <v-file-input
                            v-model="editedItem.image"
                            label="Logo"
                            filled
                            outlined
                            prepend-icon="mdi-camera"
                            accept="image/png,image/jpeg,image/jpg"
                          ></v-file-input>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-card-text>

                  <v-card-actions>
                    <v-progress-linear
                      v-if="progressL"
                      indeterminate
                      color="green"
                    ></v-progress-linear>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="close">
                      Cancel
                    </v-btn>
                    <v-btn color="blue darken-1" text @click="save">
                      Save
                    </v-btn>
                  </v-card-actions>
                </v-form>
              </v-card>
            </v-dialog>
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
            <v-dialog v-model="dialogFilterClose" max-width="1000px">
              <v-card>
                <v-card-title class="text-h6">Filters</v-card-title>
                <v-card-text>
                  <v-form>
                      <v-row>
                          <v-col md="6">
                              <v-select
                                  v-model="status"
                                  :items="getSelectorItem()"
                                  persistent-hint
                                  prepend-icon="mdi-alpha-s-circle"
                                  :label="$t('status')"
                                  placeholder="Select status ..."
                                  multiple
                              />
                          </v-col>
                      </v-row>
                    <v-row>
                      <v-col md="12"> Due Date </v-col>
                      <v-col md="4">
                        <v-text-field
                          v-model="due_from"
                          type="date"
                          persistent-hint
                          :label="$t('from')"
                        />
                      </v-col>
                      <v-col md="4">
                        <v-text-field
                          v-model="due_to"
                          type="date"
                          persistent-hint
                          :label="$t('to')"
                        />
                      </v-col>
                      <v-col md="4">
                        <CButton
                          size="sm"
                          color="danger"
                          v-on:click="resetDate('due')"
                        >
                          Reset
                        </CButton>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col md="12"> Created Date </v-col>
                      <v-col md="4">
                        <v-text-field
                          v-model="created_from"
                          type="date"
                          persistent-hint
                          :label="$t('from')"
                        />
                      </v-col>
                      <v-col md="4">
                        <v-text-field
                          v-model="created_to"
                          type="date"
                          persistent-hint
                          :label="$t('to')"
                        />
                      </v-col>
                      <v-col md="4">
                        <CButton
                          size="sm"
                          color="danger"
                          v-on:click="resetDate('created')"
                        >
                          Reset
                        </CButton>
                      </v-col>
                    </v-row>

                  </v-form>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="closeFilter"
                    >Cancel</v-btn
                  >
                  <v-btn color="blue darken-1" text @click="filterItemConfirm"
                    >Apply</v-btn
                  >
                  <v-spacer></v-spacer>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-toolbar>
            <v-expand-transition>
            <div v-if="dialogFilter==true"
                 :style="{background:'#ebedef', width:'100%'}"
                 transition="scroll-y-transition">
                <v-card-title class="text-h6">Filters</v-card-title>
                <v-card-text>
                    <v-form>
                        <v-row>
                            <v-col
                                lg="2"
                                xl="2"
                                md="2"
                                sm="2"
                               xs="10"
                            >
                        <b>Choose Status</b>
                        <v-row>
                            <p>{{status}}</p>
                            <v-col v-if="getCurrentPage()=='all'">
                                <v-checkbox
                                    v-model="status"
                                    :label="$t('Approved')"
                                    color="red"
                                    value="Approved"
                                    hide-details
                                    :style="{width: 'fit-content'}"
                                >Approved</v-checkbox>
                                <v-checkbox
                                    v-model="status"
                                    :label="$t('Received')"
                                    color="red"
                                    value="Reviewed"
                                    hide-details
                                    :style="{width: 'fit-content'}"
                                >Reviewed</v-checkbox>
                                <v-checkbox
                                    v-model="status"

                                    :label="$t('Pending')"
                                    color="red"
                                    value="Pending"
                                    hide-details
                                    :style="{width: 'fit-content'}"
                                >Pending</v-checkbox>
                                <v-checkbox
                                    v-model="status"
                                    :label="$t('Rejected')"
                                    color="red"
                                    value="Cancelled"
                                    hide-details
                                    :style="{width: 'fit-content'}"
                                >Rejected</v-checkbox>
                            </v-col>
                            <v-col v-if="getCurrentPage()=='approved'">
                                <v-checkbox
                                    v-model="status"
                                    :label="$t('Approved')"
                                    color="red"
                                    value="Approved"
                                    hide-details
                                    :style="{width: 'fit-content'}"
                                >Approved</v-checkbox>

                            </v-col>
                            <v-col v-if="getCurrentPage()=='received'">
                                <v-checkbox
                                    v-model="status"
                                    :label="$t('Received')"
                                    color="red"
                                    value="Reviewed"
                                    hide-details
                                    :style="{width: 'fit-content'}"
                                >Reviewed</v-checkbox>

                            </v-col>
                            <v-col v-if="getCurrentPage()=='pending'">
                                <v-checkbox
                                    v-model="status"
                                    :label="$t('Pending')"
                                    color="red"
                                    value="Pending"
                                    hide-details
                                    :style="{width: 'fit-content'}"
                                >Pending</v-checkbox>
                            </v-col>
                            <v-col v-if="getCurrentPage()=='rejected'">
                                <v-checkbox
                                    v-model="status"
                                    :label="$t('Rejected')"
                                    color="red"
                                    value="Cancelled"
                                    hide-details
                                    :style="{width: 'fit-content'}"
                                >Rejected</v-checkbox>
                            </v-col>
                        </v-row>
                            </v-col>
                            <v-spacer></v-spacer>
                            <v-col
                                md="4"
                                lg="4"
                                xl="4"
                                sm="4"
                                xs="10">
                                <b>Departments</b>
                                <v-select
                                    v-model="department_ids"
                                    :items="departments"
                                    item-text="name"
                                    item-value="id"
                                    persistent-hint
                                    solo
                                    :label="$t('department')"
                                    placeholder="Select department ..."
                                    multiple
                                />
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col md="4"
                                   lg="4"
                                   xl="4"
                                   sm="4"
                                   xs="10"
                            >
                                <div class="due_title">
                                    <b>Due Date</b>
                                </div>
                                <div class="due_content">
                                    <v-menu class="date_container"
                                            :close-on-content-click="true"
                                            transition="scale-transition"
                                            offset-y
                                            max-width="290px"
                                            min-width="auto"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field
                                                v-model="due_from"
                                                placeholder="From"
                                                v-bind="attrs"
                                                v-on="on"
                                                solo
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker
                                            v-model="due_from"
                                            no-title
                                        ></v-date-picker>
                                    </v-menu>
                                    <v-menu
                                        :close-on-content-click="true"
                                        transition="scale-transition"
                                        offset-y
                                        max-width="290px"
                                        min-width="auto"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field
                                                v-model="due_to"
                                                placeholder="To"
                                                v-bind="attrs"
                                                v-on="on"
                                                solo
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker
                                            v-model="due_to"
                                            no-title
                                        ></v-date-picker>
                                    </v-menu>
                                    <CButton
                                        size="sm"
                                        color="danger"
                                        :style="{float:'right'}"
                                        v-on:click="resetDate('due')"
                                    >
                                        Reset
                                    </CButton>
                                </div>

                            </v-col>
                            <v-spacer></v-spacer>
                            <v-col md="4"
                                   lg="4"
                                   xl="4"
                                   sm="4"
                                   xs="10">
                                <div class="create_title">
                                    <b>Created Date</b>
                                </div>
                                <div class="create_content">
                                    <v-menu
                                        :close-on-content-click="true"
                                        transition="scale-transition"
                                        offset-y
                                        max-width="290px"
                                        min-width="auto"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field
                                                v-model="created_from"
                                                placeholder="From"
                                                v-bind="attrs"
                                                v-on="on"
                                                solo
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker
                                            v-model="created_from"
                                            no-title
                                        ></v-date-picker>
                                    </v-menu>

                                    <v-menu
                                        :close-on-content-click="true"
                                        transition="scale-transition"
                                        offset-y
                                        max-width="290px"
                                        min-width="auto"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field
                                                v-model="created_to"
                                                placeholder="From"
                                                v-bind="attrs"
                                                v-on="on"
                                                solo
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker
                                            v-model="created_to"
                                            no-title
                                        ></v-date-picker>
                                    </v-menu>
                                    <CButton
                                        size="sm"
                                        color="danger"
                                        :style="{float:'right'}"
                                        v-on:click="resetDate('created')"
                                    >
                                        Reset
                                    </CButton>
                                </div>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <button type="button" class="btn btn-outline-danger " @click="closeFilter">Cancel</button>
                    <button type="button" class="btn btn-outline-success ml-2 " @click="filterItemConfirm">Apply</button>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </div>
                </v-expand-transition>
        </template>

        <template v-slot:item.status="{ item }">
          <CButton size="sm" :color="getColor(item.status)">
            {{ item.status }}
          </CButton>
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon small class="mr-2" @click="editItem(item)">
            mdi-pencil
          </v-icon>
          <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
        </template>
        <template v-slot:expanded-item="{ headers, item }">
          <td :colspan="headers.length">
            <PurchaseTableDetail :item="item"></PurchaseTableDetail>
          </td>
        </template>
        <template v-slot:no-data>
          <div>No Data</div>
        </template>
      </v-data-table>
    </v-card>
  </div>
</template>

<script>
import config from "../../config";
import ApiServices from "../../services/ApiServices";
import PurchaseTableDetail from "./PurchaseTableDetail";
import store from "../../store";
import route from "../../router";

export default {
  name: "PurchaseRequestHistory",
  components: { PurchaseTableDetail },
  data: () => ({
    cdnURL: config.cdnURL,
    search: "",
    status: [],
    selected:[],
    actionbtn: [],
    department_ids: [],
    departments: [],
    due_from: "",
    due_to: "",
    created_from: "",
    created_to: "",
    validated: false,
    progressL: false,
    dialog: false,
    dialogDelete: false,
    dialogFilter: false,
      dialogFilterClose:false,
      menu1: false,
      menu2: false,
    headers: [
      {
        text: "Reference No",
        align: "start",
        sortable: false,
        value: "reference_no",
      },
      { text: "Items", value: "purchase_products_shortcode" },
      { text: "Item Count", value: "total_item" },
      { text: "Department", value: "department_name" },
      { text: "Status", value: "status" },
      { text: "Due Date", value: "due_date" },
      { text: "Actions", value: "actions", sortable: false },
    ],
    purchaseHistory: [],
    filterPurchaseHistory: [],
    editedIndex: -1,
    editedItem: {
      id: null,
      name: "",
      image: [],
    },
    defaultItem: {
      id: null,
      name: "",
      image: [],
    },
    rules: [(value) => !!value || "Required."],
    tableLoad: true,
  }),

  computed: {
    mystate() {
      return store.state.home.current_action;
    },
    formTitle() {
      return this.editedIndex === -1 ? "Add Brand" : "Edit Brand";
    },
  },

  watch: {
    mystate: function (newValue, oldValue) {
      this.getTableStructure();
    },
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  async created() {
       // this.loadItems()
    this.getTableStructure();
    this.loadDepartments();
  },

  methods: {
      getTabColor(){
          const color= store.getters['home/getColor']
          return color;
      },
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
    async getTableStructure() {
      // For Purchase Request
      this.actionbtn = ["Add New Purchase Request"];
      // Perform API call here
      let res = await ApiServices.getUserPurchaseProductRequest();
      //Retreving all data
      if (store.state.home.current_action == "all") {
        if (res.success == true) {
          this.tableLoad = false;
        this.purchaseHistory = res.data;
        this.filterPurchaseHistory = res.data;
        }
      }
      // Retrieving only approved data
      if (store.state.home.current_action == "approved") {
        if (res.success == true) {
          const data = res.data.filter((item) => item.status == "Approved");
          this.tableLoad = false;
        this.purchaseHistory = data;
        this.filterPurchaseHistory = data;
        }
      }
      // Retrieving only pending data
      if (store.state.home.current_action == "pending") {
        if (res.success == true) {
          const data = res.data.filter((item) => item.status == "Pending");
          this.tableLoad = false;
        this.purchaseHistory = data;
        this.filterPurchaseHistory = data;
        }
      }
      // Retrieving only rejected data
      if (store.state.home.current_action == "rejected") {
        if (res.success == true) {
          const data = res.data.filter((item) => item.status == "Cancelled");
          this.tableLoad = false;
        this.purchaseHistory = data;
        this.filterPurchaseHistory = data;
        }
      }
      // Retrieving only received data
      if (store.state.home.current_action == "received") {
        if (res.success == true) {
          const data = res.data.filter((item) => item.status == "Reviewed");
          this.tableLoad = false;
        this.purchaseHistory = data;
        this.filterPurchaseHistory = data;
        }
      }
    },
      // get current Action
    getCurrentPage() {
      return store.state.home.current_action;
    },
      // Item according to states
      getSelectorItem(){
          if(this.getCurrentPage()=='all'){
              return [
                  'Pending',
                  'Reviewed',
                  'Approved',
                  'Cancelled',
              ]
          }
          if(this.getCurrentPage()=='approved'){
              return [
                  'Approved'
              ]
          }
          if(this.getCurrentPage()=='pending'){
              return [
                  'Pending'

              ]
          }
          if(this.getCurrentPage()=='received'){
              return [
                  'Reviewed'
              ]
          }
          if(this.getCurrentPage()=='rejected'){
              return [
                  'Cancelled'
              ]
          }

      },
    async updateAction(action) {
        this.status=[];
      store.state.home.current_action = action;
    },
    getColor(status) {
      if (status === "Pending") return "warning";
      else if (status === "Rejected") return "danger";
      else return "success";
    },

    openImage(data) {
      window.open(config.cdnURL + data, `_blank`);
    },
    async loadItems() {
      let res = await ApiServices.getUserPurchaseProductRequestHistory();
      if (res.success === true) {
        this.tableLoad = false;
        this.purchaseHistory = res.data;
        this.filterPurchaseHistory = res.data;
      }
    },
    async loadDepartments() {
      let res = await ApiServices.departmentList();
      if (res.success === true) {
        this.departments = res.data;
      }
    },
    editItem(item) {
      if (item.status === "Pending") {
        this.editedIndex = this.purchaseHistory.indexOf(item);
        this.editedItem = Object.assign({}, item);
        store.state.purchase.editItem = item;
        route.replace("/purchase/edit-purchase-request");
      } else {
        store.state.home.snackbar = true;
        store.state.home.snackbarText =
          "Cannot perform this action, Status Changed !!";
        store.state.home.snackbarColor = "red";
      }
    },

    deleteItem(item) {
      if (item.status === "Pending") {
        this.editedIndex = this.purchaseHistory.indexOf(item);
        this.editedItem = Object.assign({}, item);
        this.dialogDelete = true;
      } else {
        store.state.home.snackbar = true;
        store.state.home.snackbarText =
          "Cannot perform this action, Status Changed !!";
        store.state.home.snackbarColor = "red";
      }
    },

    async deleteItemConfirm() {
      let res = await ApiServices.deleteUserPurchaseRequest(this.editedItem.id);
      if (res.success === true) {
        this.purchaseHistory.splice(this.editedIndex, 1);
      }
      this.closeDelete();
    },

    close() {
      this.progressL = false;
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
      this.loadItems();
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    async resetDate(type) {
      if (type === "due") {
        this.due_from = "";
        this.due_to = "";
      } else {
        this.created_from = "";
        this.created_to = "";
      }
    },

    openFilter() {
      this.dialogFilter = !this.dialogFilter;
    },

    async filterItemConfirm() {
      const data = new FormData();
      if (this.status !== null && this.status !== []) {
        data.append("status", JSON.stringify(this.status));
      }
      let userData = localStorage.getItem("userData");
      if (userData !== "") {
        userData = JSON.parse(userData);
        this.department_ids.push(userData.department_id);
      }
      if (this.department_ids !== null && this.department_ids !== []) {
        data.append("department_ids", JSON.stringify(this.department_ids));
      }
      if (this.due_from !== null && this.due_from !== "") {
        data.append("due_from", this.due_from);
      }
      if (this.due_to !== null && this.due_to !== "") {
        data.append("due_to", this.due_to);
      }
      if (this.created_from !== null && this.created_from !== "") {
        data.append("created_from", this.created_from);
      }
      if (this.created_to !== null && this.created_to !== "") {
        data.append("created_to", this.created_to);
      }
      var ids = [];
      for (var i = 0; i < this.filterPurchaseHistory.length; i++) {
        ids.push(this.filterPurchaseHistory[i].id);
      }
      if (this.ids !== null && this.ids !== []) {
        data.append("ids", JSON.stringify(ids));
      }

      let res = await ApiServices.purchaseFilter(data);
      if (res.success === true) {
        this.purchaseHistory = res.data;
      } else {
        store.state.home.snackbar = true;
        store.state.home.snackbarText = res.message;
        store.state.home.snackbarColor = "red";
      }
      this.closeFilter();
    },

    closeFilter() {
      this.dialogFilter = false;
    },

    async save() {
      if (this.editedIndex > -1) {
        //edit goes here
        this.progressL = true;
        const data = new FormData();
        data.append("name", this.editedItem.name);
        console.log("edit", this.editedItem.image, this.editedItem);
        if ("image" in this.editedItem) {
          if (typeof this.editedItem.image.name == "string") {
            data.append("image", this.editedItem.image);
          }
        }
        let res = await ApiServices.brandEdit(this.editedItem.id, data);
        if (res.success === true) {
          Object.assign(
            this.purchaseHistory[this.editedIndex],
            this.editedItem
          );
          this.$refs.form.reset();
          this.close();
        }
      } else {
        //add new
        this.validateData();
        if (this.validated) {
          this.progressL = true;
          const data = new FormData();
          data.append("name", this.editedItem.name);
          if (typeof this.editedItem.image.name == "string") {
            data.append("image", this.editedItem.image);
          }
          let res = await ApiServices.brandCreate(data);
          if (res.success === true) {
            this.purchaseHistory.push(this.editedItem);
            this.$refs.form.reset();
            this.close();
          }
        }
      }
    },
    validateData() {
      this.$refs.form.validate();
      if (this.editedItem.name === null) {
        this.validated = false;
      } else {
        this.validated = true;
      }
    },
  },
};
</script>0
<style>
.theme--light.v-data-table .v-data-footer {
    border-top: none;
}
.v-data-footer{
  width: 290px;
}
.v-input--selection-controls {
     margin-top: 0px !important;
     padding-top: 0px !important;
}
.v-text-field.v-text-field--enclosed .v-text-field__details {

    display: none !important;
}
.v-text-field.v-text-field--enclosed .v-text-field__details, .v-text-field.v-text-field--enclosed:not(.v-text-field--rounded)>.v-input__control>.v-input__slot {
    padding: 0 12px;
    border: 1px solid gray;
    box-shadow: none !important;
}

</style>
