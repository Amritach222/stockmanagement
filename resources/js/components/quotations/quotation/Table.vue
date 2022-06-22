<template>
  <div>
    <div class="statustitle d-flex align-items-center justify-content-between">
      <h5 class="ml-2">Quotation Status</h5>
        <div
            class="actionbutton d-lg-none d-xl-none d-xxl-none "
        >
            <v-btn
                class="mr-2"
                color="primary"
                dark
                :to="'/quotations/create'"
                v-if="$can('quotations.create')"
            >
                Add New Quotation
            </v-btn>
        </div>
    </div>
    <!-- top status tab -->
    <div class="toptab d-flex position-relative">
      <div
        :class="getCurrentPage() === 'all' ? 'tab_all ml-2' : 'ml-2'"
        @click="updateAction('all')"
      >
        <div class="actualtab" :style="{color:`${getTabColor().all}`}">All | {{ getCurrentData().all?getCurrentData().all:0 }}</div>
      </div>
      <div
        :class="getCurrentPage() === 'approved' ? 'tab_approved ml-2' : 'ml-2'"
        @click="updateAction('approved')"
      >
        <div class="actualtab" :style="{color:`${getTabColor().approved}`}">Approved | {{ getCurrentData().approved?getCurrentData().approved:0 }}</div>
      </div>
      <div
        :class="getCurrentPage() === 'received' ? 'tab_received ml-2' : 'ml-2'"
        @click="updateAction('received')"
      >
        <div class="actualtab" :style="{color:`${getTabColor().received}`}">Received | {{ getCurrentData().received?getCurrentData().received:0 }}</div>
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
          :to="'/quotations/create'"
          v-if="$can('quotations.create')"
        >
          Add New Quotation
        </v-btn>
      </div>
    </div>
    <v-card>

      <v-data-table
        v-model="selected"
        :headers="headers"
        :items="quotations"
        sort-by="id"
        :loading="tableLoad"
        loading-text="Loading... Please wait..."
        :search="search"
      >
        <template v-slot:top="{ pagination, options, updateOptions }" >
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
          ><v-icon>mdi-filter-outline</v-icon>{{dialogFilter?'Hide Filter':'Show Filter'}}</v-btn
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
            <v-dialog v-model="dialogFilterOld" max-width="1000px">
              <v-card>
                <v-card-title class="text-h6">Filters</v-card-title>
                <v-card-text>
                  <v-form>
                    <v-row>
                      <v-col md="4">
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
                      <v-col md="4">
                        <v-autocomplete
                          v-model="vendor_id"
                          :items="vendors"
                          item-text="name"
                          item-value="id"
                          persistent-hint
                          prepend-icon="mdi-alpha-s-circle"
                          :label="$t('suppliers')"
                          placeholder="Select suppliers ..."
                        ></v-autocomplete>
                        <!--                                            <v-select-->
                        <!--                                                v-model="vendor_id"-->
                        <!--                                                :items="vendors"-->
                        <!--                                                item-text="name"-->
                        <!--                                                item-value="id"-->
                        <!--                                                persistent-hint-->
                        <!--                                                prepend-icon="mdi-alpha-s-circle"-->
                        <!--                                                :label="$t('suppliers')"-->
                        <!--                                                placeholder="Select suppliers ..."-->
                        <!--                                            />-->
                      </v-col>
                      <v-col md="4">
                        <v-select
                          v-model="department_ids"
                          :items="departments"
                          item-text="name"
                          item-value="id"
                          persistent-hint
                          prepend-icon="mdi-alpha-d-circle"
                          :label="$t('department')"
                          placeholder="Select department ..."
                          multiple
                        />
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col md="12"> Desired Delivery Date </v-col>
                      <v-col md="4">
                        <v-text-field
                          v-model="delivery_from"
                          type="date"
                          persistent-hint
                          :label="$t('from')"
                        />
                      </v-col>
                      <v-col md="4">
                        <v-text-field
                          v-model="delivery_to"
                          type="date"
                          persistent-hint
                          :label="$t('to')"
                        />
                      </v-col>
                      <v-col md="4">
                        <CButton
                          size="sm"
                          color="danger"
                          v-on:click="resetDate('delivery')"
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
                    >Submit</v-btn
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
                                <v-col md="4"
                                       lg="4"
                                       xl="4"
                                       sm="4"
                                       xs="10">
                                    <b>Suppliers</b>
                                    <v-autocomplete
                                    v-model="vendor_id"
                                    :items="vendors"
                                    item-text="name"
                                    item-value="id"
                                    persistent-hint
                                    solo
                                    :label="$t('suppliers')"
                                    placeholder="Select suppliers ..."
                                ></v-autocomplete></v-col>
                                <v-spacer></v-spacer>
                                <v-col md="4"
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
                                /></v-col>
                            </v-row>
                            <v-row>

                                <v-col md="4"
                                       lg="4"
                                       xl="4"
                                       sm="4"
                                       xs="10"
                                >
                                    <div class="delivery_title">
                                        <b>Desired Delivery Date</b>
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
                                                    v-model="delivery_from"
                                                    placeholder="From"
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    solo
                                                ></v-text-field>
                                            </template>
                                            <v-date-picker
                                                v-model="delivery_from"
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
                                                    v-model="delivery_to"
                                                    placeholder="To"
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    solo
                                                ></v-text-field>
                                            </template>
                                            <v-date-picker
                                                v-model="delivery_to"
                                                no-title
                                            ></v-date-picker>
                                        </v-menu>
                                        <CButton
                                            size="sm"
                                            color="danger"
                                            :style="{float:'right'}"
                                            v-on:click="resetDate('delivery')"
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
        <template v-slot:item.link="{ item }">
          <CButton
            size="sm"
            color="primary"
            class="file-link"
            v-if="item.link"
            v-on:click="openImage(item.link)"
          >
            Open File
          </CButton>
          <p v-else>No files added.</p>
        </template>
        <template v-slot:item.department_id="{ item }">
          {{ item.department.name }}
        </template>
        <template v-slot:item.status="{ item }">
          <CButton size="sm" color="secondary" v-if="item.status === 'Pending'">
            {{ item.status }}
          </CButton>
          <CButton
            size="sm"
            color="warning"
            v-else-if="item.status === 'Reviewed'"
          >
            {{ item.status }}
          </CButton>
          <CButton
            size="sm"
            color="success"
            v-else-if="item.status === 'Approved'"
          >
            {{ item.status }}
          </CButton>
          <CButton
            size="sm"
            color="danger"
            v-else-if="item.status === 'Rejected'"
          >
            {{ item.status }}
          </CButton>
        </template>
        <template v-slot:item.actions="{ item }">
          <router-link
            :to="'/quotations/' + item.id"
            v-if="$can('quotations.show')"
          >
            <v-icon small> mdi-eye </v-icon>
          </router-link>
          <router-link
            :to="'/quotations/edit/' + item.id"
            v-if="$can('quotations.edit')"
          >
            <v-icon small> mdi-pencil </v-icon>
          </router-link>
          <v-icon
            small
            @click="deleteItem(item)"
            v-if="$can('quotations.delete') && item.status === 'Pending'"
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
import ApiServices from "../../../services/ApiServices";
import route from "../../../router";

export default {
  name: "TableWrapper",
  data: () => ({
    cdnURL: config.cdnURL,
    baseURL: config.baseURL,
    search: "",
    actionbtn: [],
    singleSelect: false,
    selected: [],
    vendor_id: "",
    vendors: [],
    department_ids: [],
    departments: [],
    delivery_from: "",
    delivery_to: "",
    created_from: "",
    created_to: "",
    validated: false,
    progressL: false,
    dialog: false,
    dialogDelete: false,
    dialogFilter: false,
      dialogFilterOld:false,
    headers: [
      { text: "Id", align: "start", sortable: true, value: "id" },
      { text: "Reference No.", value: "reference_no" },
      { text: "Department", value: "department_id" },
      // {text: 'File', value: 'link', sortable: false},
      {
        text: "Desired Delivery Date",
        value: "desired_delivery_date_format",
        sortable: true,
      },
      { text: "Due Date", value: "due_date_format", sortable: true },
      { text: "Status", value: "status", sortable: true },
      { text: "Actions", value: "actions", sortable: false },
    ],
    quotations: [],
    filter_quotations: [],
    status: [],
    tableLoad: true,
  }),

  computed: {
    mystate() {
      return store.state.home.current_action;
    },
    formTitle() {
      return this.editedIndex === -1 ? "Add Quotation" : "Edit Quotation";
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
    this.getTableStructure();
    // this.loadItems();
    this.loadDepartments();
    this.loadVendors();
  },

  methods: {
      getTabColor(){
          const color= store.getters['home/getColor']
          return color;
      },
    openImage(data) {
      window.open(config.cdnURL + data, `_blank`);
    },
    async loadItems() {
      let res = await ApiServices.quotationIndex();
      if (res.success === true) {
        this.tableLoad = false;
        this.quotations = res.data;
      }
    },
    async loadDepartments() {
      let res = await ApiServices.departmentList();
      if (res.success === true) {
        this.departments = res.data;
      }
    },
    async loadVendors() {
      let res = await ApiServices.vendorList();
      if (res.success === true) {
        this.vendors = res.data;
      }
    },
    async resetDate(type) {
      if (type === "delivery") {
        this.delivery_from = "";
        this.delivery_to = "";
      } else {
        this.created_from = "";
        this.created_to = "";
      }
    },
    editItem(item) {
      this.editedIndex = this.quotations.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    openFilter() {
        this.dialogFilter = !this.dialogFilter;
    },

    deleteItem(item) {
      this.editedIndex = this.quotations.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    async deleteItemConfirm() {
      let res = await ApiServices.quotationDelete(this.editedItem.id);
      if (res.success === true) {
        this.quotations.splice(this.editedIndex, 1);
      }
        this.closeDelete();
    },

    async filterItemConfirm() {
      const data = new FormData();
      if (this.status !== null && this.status !== []) {
        data.append("status", JSON.stringify(this.status));
      }
      if (this.department_ids !== null && this.department_ids !== []) {
        data.append("department_ids", JSON.stringify(this.department_ids));
      }
      if (this.vendor_ids !== null && this.vendor_id !== "") {
        data.append("vendor_id", this.vendor_id);
      }
      if (this.delivery_from !== null && this.delivery_from !== "") {
        data.append("delivery_from", this.delivery_from);
      }
      if (this.delivery_to !== null && this.delivery_to !== "") {
        data.append("delivery_to", this.delivery_to);
      }
      if (this.created_from !== null && this.created_from !== "") {
        data.append("created_from", this.created_from);
      }
      if (this.created_to !== null && this.created_to !== "") {
        data.append("created_to", this.created_to);
      }

      let res = await ApiServices.quotationFilter(data);
      if (res.success === true) {
        this.quotations = res.data;
      } else {
        store.state.home.snackbar = true;
        store.state.home.snackbarText = res.message;
        store.state.home.snackbarColor = "red";
      }
      this.closeFilter();
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

    closeFilter() {
      this.dialogFilter = false;
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
      this.actionbtn = ["Add New Quotation"];
      // Perform API call here
      let res = await ApiServices.quotationIndex();
      //Retreving all data
      if (store.state.home.current_action == "all") {
        if (res.success == true) {
          this.tableLoad = false;
          this.quotations = res.data;
        }
      }
      // Retrieving only approved data
      if (store.state.home.current_action == "approved") {
        if (res.success == true) {
          const data = res.data.filter((item) => item.status == "Approved");
          this.tableLoad = false;
          this.quotations = data;
        }
      }
      // Retrieving only pending data
      if (store.state.home.current_action == "pending") {
        if (res.success == true) {
          const data = res.data.filter((item) => item.status == "Pending");
          this.tableLoad = false;
          this.quotations = data;
        }
      }
      // Retrieving only rejected data
      if (store.state.home.current_action == "rejected") {
        if (res.success == true) {
          const data = res.data.filter((item) => item.status == "Cancelled");
          this.tableLoad = false;
          this.quotations = data;
        }
      }
      // Retrieving only received data
      if (store.state.home.current_action == "received") {
        if (res.success == true) {
          const data = res.data.filter((item) => item.status == "Reviewed");
          this.tableLoad = false;
          this.quotations = data;
        }
      }
    },
    getCurrentPage() {
      return store.state.home.current_action;
    },
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
  },
};
</script>

<style scoped>
.file-link {
  cursor: pointer;
  text-decoration: underline;
  margin-top: 6px;
  font-size: 14px;
  font-weight: 400;
}

.card-text-filter {
  padding: 12px !important;
}
.theme--light.v-data-table .v-data-footer {
    border-top: none;
}
.v-data-footer{
  width: 290px;
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
