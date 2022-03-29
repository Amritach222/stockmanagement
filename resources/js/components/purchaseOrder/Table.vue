<template>
    <v-card>
        <v-card-title>
            Purchase Orders
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="purchaseOrders"
            sort-by="id"
            :loading=tableLoad
            loading-text="Loading... Please wait..."
            :search="search"
        >

            <template v-slot:top>
                <v-toolbar
                    flat
                >
                    <v-row>
                        <v-col
                            cols="12"
                            sm="3"
                            md="4"
                            lg="6"
                        >
                            <v-text-field
                                v-model="search"
                                append-icon="mdi-magnify"
                                label="Search"
                                solo
                                hide-details
                                max-width="100px"
                            ></v-text-field>
                        </v-col>
                        <v-col
                            cols="12"
                            sm="3"
                            md="3"
                            lg="2"
                        >
                            <v-card>
                                <v-card-actions>
                                    <v-btn color="blue darken-1" text @click="openFilter">Filter</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-col>
                    </v-row>
                    <v-dialog
                        v-model="dialog"
                        max-width="600px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                color="green"
                                dark
                                class="mb-2 ml-2"
                                v-bind="attrs"
                                v-on="on"
                                :to="'/quotations/list/approved'"
                                v-if="$can('quotations.create')"
                            >
                                Add From Approved Quotation
                            </v-btn>
                            <v-btn
                                color="green"
                                dark
                                class="mb-2"
                                v-bind="attrs"
                                v-on="on"
                                :to="'/purchaseOrders/create'"
                                v-if="$can('quotations.create')"
                            >
                                Add New Purchase Order
                            </v-btn>
                        </template>
                    </v-dialog>
                    <v-dialog v-model="dialogDelete" max-width="500px">
                        <v-card>
                            <v-card-title class="text-h6">Are you sure you want to delete this item?</v-card-title>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                                <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-dialog v-model="dialogFilter" max-width="1000px">
                        <v-card>
                            <v-card-title class="text-h6">Filters</v-card-title>
                            <v-card-text>
                                <v-form>
                                    <v-row>
                                        <v-col md="4">
                                            <v-select
                                                v-model="status"
                                                :items="['Pending','Reviewed','Approved','Cancelled']"
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
                                        <v-col md="12">
                                            Desired Delivery Date
                                        </v-col>
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
                                            <CButton size="sm" color="danger"
                                                     v-on:click="resetDate('delivery')"> Reset
                                            </CButton>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col md="12">
                                            Created Date
                                        </v-col>
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
                                            <CButton size="sm" color="danger"
                                                     v-on:click="resetDate('created')"> Reset
                                            </CButton>
                                        </v-col>
                                    </v-row>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="closeFilter">Cancel</v-btn>
                                <v-btn color="blue darken-1" text @click="filterItemConfirm">Submit</v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>
            <template v-slot:item.link="{ item }">
                <CButton size="sm" color="primary" class="file-link" v-if="item.link"
                         v-on:click="openImage(item.link)"> Open
                    File
                </CButton>
                <p v-else>
                    No files added.
                </p>
            </template>
            <template v-slot:item.dept_id="{ item }">
                {{ item.department.name }}
            </template>
            <template v-slot:item.status="{ item }">
                <CButton size="sm" color="secondary" v-if="item.status === 'Draft'">
                    {{ item.status }}
                </CButton>
                <CButton size="sm" color="secondary" v-else-if="item.status === 'Pending'">
                    {{ item.status }}
                </CButton>
                <CButton size="sm" color="warning" v-else-if="item.status === 'Reviewed'">
                    {{ item.status }}
                </CButton>
                <CButton size="sm" color="success" v-else-if="item.status === 'Approved'">
                    {{ item.status }}
                </CButton>
                <CButton size="sm" color="danger" v-else-if="item.status === 'Rejected'">
                    {{ item.status }}
                </CButton>
                <CButton size="sm" color="warning" v-else>
                    {{ item.status }}
                </CButton>
            </template>
            <template v-slot:item.actions="{ item }">
                <router-link
                    :to="'/purchaseOrders/edit/'+item.id"
                    v-if="$can('quotations.edit')"
                >
                    <v-icon
                        small
                    >
                        mdi-pencil
                    </v-icon>
                </router-link>
                <v-icon
                    small
                    @click="deleteItem(item)"
                >
                    mdi-delete
                </v-icon>
            </template>
            <template v-slot:no-data>
                <div>No Data</div>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import config from "../../config";
import store from "../../store";
import ApiServices from "../../services/ApiServices";
import route from "../../router";

export default {
    name: "TableWrapper",
    data: () => ({
        cdnURL: config.cdnURL,
        baseURL: config.baseURL,
        search: '',
        vendor_id: '',
        vendors: [],
        department_ids: [],
        departments: [],
        delivery_from: '',
        delivery_to: '',
        created_from: '',
        created_to: '',
        validated: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        dialogFilter: false,
        headers: [
            {text: 'Reference No.', value: 'reference'},
            {text: 'Department', value: 'dept_id'},
            // {text: 'File', value: 'link', sortable: false},
            {text: 'Date Of Order', value: 'date_of_order', sortable: true},
            {text: 'Requester', value: 'requester', sortable: true},
            {text: 'Supplier', value: 'supplier', sortable: true},
            {text: 'Status', value: 'status', sortable: true},
            {text: 'Actions', value: 'actions', sortable: false},
        ],
        purchaseOrders: [],
        filter_quotations: [],
        status: [],
        tableLoad: true
    }),

    // computed: {
    //     formTitle() {
    //         return this.editedIndex === -1 ? 'Add Quotation' : 'Edit Quotation'
    //     },
    // },

    watch: {
        dialog(val) {
            val || this.close()
        },
        dialogDelete(val) {
            val || this.closeDelete()
        },
    },

    async created() {
        this.loadItems();
        this.loadDepartments();
        this.loadVendors();
    },

    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadItems() {
            let res = await ApiServices.purchaseOrderIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.purchaseOrders = res.data;
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
            if (type === 'delivery') {
                this.delivery_from = '';
                this.delivery_to = '';
            } else {
                this.created_from = '';
                this.created_to = '';
            }
        },
        editItem(item) {
            this.editedIndex = this.purchaseOrders.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        openFilter() {
            this.dialogFilter = true
        },

        deleteItem(item) {
            this.editedIndex = this.purchaseOrders.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.purchaseOrderDelete(this.editedItem.id);
            if (res.success === true) {
                this.purchaseOrders.splice(this.editedIndex, 1)
            }
            this.closeDelete()
        },

        async filterItemConfirm() {
            const data = new FormData();
            if (this.status !== null && this.status !== []) {
                data.append('status', JSON.stringify(this.status));
            }
            if (this.department_ids !== null && this.department_ids !== []) {
                data.append('department_ids', JSON.stringify(this.department_ids));
            }
            if (this.vendor_ids !== null && this.vendor_id !== '') {
                data.append('vendor_id', this.vendor_id);
            }
            if (this.delivery_from !== null && this.delivery_from !== '') {
                data.append('delivery_from', this.delivery_from);
            }
            if (this.delivery_to !== null && this.delivery_to !== '') {
                data.append('delivery_to', this.delivery_to);
            }
            if (this.created_from !== null && this.created_from !== '') {
                data.append('created_from', this.created_from);
            }
            if (this.created_to !== null && this.created_to !== '') {
                data.append('created_to', this.created_to);
            }

            let res = await ApiServices.quotationFilter(data);
            if (res.success === true) {
                this.purchaseOrders = res.data;
            } else {
                store.state.home.snackbar = true;
                store.state.home.snackbarText = res.message;
                store.state.home.snackbarColor = 'red';
            }
            this.closeFilter();
        },

        close() {
            this.progressL = false;
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            });
            this.loadItems();
        },

        closeDelete() {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        closeFilter() {
            this.dialogFilter = false
        },
    },
}
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
</style>
