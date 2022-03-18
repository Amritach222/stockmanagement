<template>
    <v-card>
        <v-data-table
            :headers="headers"
            :items="purchaseHistory"
            sort-by="id"
            show-expand
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
                                class="mb-2"
                                v-bind="attrs"
                                v-on="on"
                                :to="'/purchase/new-purchase-request'"
                            >
                                Add New Purchase Request
                            </v-btn>
                        </template>
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
                                            <v-col v-if="typeof(editedItem.link) === 'string'">
                                                <v-card width="200"
                                                        v-on:click="openImage(editedItem.link)">
                                                    <v-img
                                                        :src="cdnURL+editedItem.link"
                                                        height="125"
                                                        class="grey darken-4"
                                                    ></v-img>
                                                    <v-card-title class="title">
                                                        Logo
                                                    </v-card-title>
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
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="close"
                                    >
                                        Cancel
                                    </v-btn>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="save"
                                    >
                                        Save
                                    </v-btn>
                                </v-card-actions>
                            </v-form>
                        </v-card>
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
                                        <v-col md="6">
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
                                        <v-col md="6">
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
                                            Due Date
                                        </v-col>
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
                                            <CButton size="sm" color="danger"
                                                     v-on:click="resetDate('due')"> Reset
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
                                <v-btn color="blue darken-1" text @click="filterItemConfirm">Apply</v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>
            <template v-slot:item.status="{ item }">
                <CButton size="sm" :color="getColor(item.status)">
                    {{ item.status }}
                </CButton>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon
                    small
                    class="mr-2"
                    @click="editItem(item)"
                >
                    mdi-pencil
                </v-icon>
                <v-icon
                    small
                    @click="deleteItem(item)"
                >
                    mdi-delete
                </v-icon>
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
</template>

<script>
import config from "../../config";
import ApiServices from "../../services/ApiServices";
import PurchaseTableDetail from "./PurchaseTableDetail";
import store from "../../store";
import route from "../../router";

export default {
    name: "PurchaseRequestHistory",
    components: {PurchaseTableDetail},
    data: () => ({
        cdnURL: config.cdnURL,
        search: '',
        status: [],
        department_ids: [],
        departments: [],
        due_from: '',
        due_to: '',
        created_from: '',
        created_to: '',
        validated: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        dialogFilter: false,
        headers: [
            {text: 'Reference No', align: 'start', sortable: false, value: 'reference_no'},
            {text: 'Items', value: 'purchase_products_shortcode'},
            {text: 'Item Count', value: 'total_item'},
            {text: 'Department', value: 'department_name'},
            {text: 'Status', value: 'status'},
            {text: 'Due Date', value: 'due_date'},
            {text: 'Actions', value: 'actions', sortable: false},
        ],
        purchaseHistory: [],
        filterPurchaseHistory: [],
        editedIndex: -1,
        editedItem: {
            id: null,
            name: '',
            image: [],
        },
        defaultItem: {
            id: null,
            name: '',
            image: [],
        },
        rules: [
            value => !!value || 'Required.',
        ],
        tableLoad: true
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Add Brand' : 'Edit Brand'
        },
    },

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
    },

    methods: {
        getColor(status) {
            if (status === 'Pending') return 'warning'
            else if (status === 'Rejected') return 'danger'
            else return 'success'
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
            if(item.status === "Pending"){
                this.editedIndex = this.purchaseHistory.indexOf(item)
                this.editedItem = Object.assign({}, item)
                store.state.purchase.editItem = item;
                route.replace('/purchase/edit-purchase-request');
            } else {
                store.state.home.snackbar = true;
                store.state.home.snackbarText = 'Cannot perform this action, Status Changed !!';
                store.state.home.snackbarColor = 'red';
            }
        },

        deleteItem(item) {
            if(item.status === "Pending") {
                this.editedIndex = this.purchaseHistory.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialogDelete = true
            } else {
                store.state.home.snackbar = true;
                store.state.home.snackbarText = 'Cannot perform this action, Status Changed !!';
                store.state.home.snackbarColor = 'red';
            }
        },

        async deleteItemConfirm() {
            let res = await ApiServices.deleteUserPurchaseRequest(this.editedItem.id);
            if (res.success === true) {
                this.purchaseHistory.splice(this.editedIndex, 1)
            }
            this.closeDelete()
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

        async resetDate(type) {
            if (type === 'due') {
                this.due_from = '';
                this.due_to = '';
            } else {
                this.created_from = '';
                this.created_to = '';
            }
        },

        openFilter() {
            this.dialogFilter = true
        },

        async filterItemConfirm() {
            const data = new FormData();
            if (this.status !== null && this.status !== []) {
                data.append('status', JSON.stringify(this.status));
            }
            if (this.department_ids !== null && this.department_ids !== []) {
                data.append('department_ids', JSON.stringify(this.department_ids));
            }
            if (this.due_from !== null && this.due_from !== '') {
                data.append('due_from', this.due_from);
            }
            if (this.due_to !== null && this.due_to !== '') {
                data.append('due_to', this.due_to);
            }
            if (this.created_from !== null && this.created_from !== '') {
                data.append('created_from', this.created_from);
            }
            if (this.created_to !== null && this.created_to !== '') {
                data.append('created_to', this.created_to);
            }
            var ids = [];
            for (var i = 0; i < this.filterPurchaseHistory.length; i++) {
                ids.push(this.filterPurchaseHistory[i].id);
            }


            if (this.ids !== null && this.ids !== []) {
                data.append('ids', JSON.stringify(ids));
            }

            let res = await ApiServices.purchaseFilter(data);
            if (res.success === true) {
                this.purchaseHistory = res.data;
            } else {
                store.state.home.snackbar = true;
                store.state.home.snackbarText = res.message;
                store.state.home.snackbarColor = 'red';
            }
            this.closeFilter();
        },

        closeFilter() {
            this.dialogFilter = false
        },

        async save() {
            if (this.editedIndex > -1) {
                //edit goes here
                this.progressL = true;
                const data = new FormData();
                data.append('name', this.editedItem.name);
                console.log('edit', this.editedItem.image, this.editedItem)
                if ('image' in this.editedItem) {
                    if (typeof this.editedItem.image.name == 'string') {
                        data.append('image', this.editedItem.image);
                    }
                }
                let res = await ApiServices.brandEdit(this.editedItem.id, data);
                if (res.success === true) {
                    Object.assign(this.purchaseHistory[this.editedIndex], this.editedItem)
                    this.$refs.form.reset();
                    this.close();
                }
            } else {
                //add new
                this.validateData();
                if (this.validated) {
                    this.progressL = true;
                    const data = new FormData();
                    data.append('name', this.editedItem.name);
                    if (typeof this.editedItem.image.name == 'string') {
                        data.append('image', this.editedItem.image);
                    }
                    let res = await ApiServices.brandCreate(data);
                    if (res.success === true) {
                        this.purchaseHistory.push(this.editedItem);
                        this.$refs.form.reset();
                        this.close()
                    }
                }
            }
        },
        validateData() {
            this.$refs.form.validate();
            if (this.editedItem.name === null) {
                this.validated = false
            } else {
                this.validated = true
            }
        }
    },
}
</script>

<style scoped>

</style>
