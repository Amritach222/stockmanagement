<template>
    <v-card>
        <v-card-title>
            Budget Request
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="budgetRequests"
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
                            sm="4"
                            md="6"
                            lg="8"
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
                            >
                                Add New Budget Request
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
                                                <v-select
                                                    v-model="editedItem.department_id"
                                                    :items="departments"
                                                    item-text="name"
                                                    item-value="id"
                                                    label="Department"
                                                    required
                                                    outlined
                                                    :rules="rules"
                                                ></v-select>
                                                <v-text-field
                                                    v-model="editedItem.request_amount"
                                                    type="number"
                                                    label="Amount"
                                                    required
                                                    outlined
                                                    :rules="rules"
                                                ></v-text-field>
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
                </v-toolbar>
            </template>
            <template v-slot:item.department_id="{ item }">
                <p v-if="item.department_id">{{ item.department_name }}</p>
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
            <template v-slot:no-data>
                <div>No Data</div>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import store from "../../../store";
import ApiServices from "../../../services/ApiServices";

export default {
    name: "TableWrapper",
    data: () => ({
        search: '',
        validated: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        headers: [
            {text: 'Id', align: 'start', sortable: true, value: 'id'},
            {text: 'Department', value: 'department_id'},
            {text: 'Amount', value: 'request_amount'},
            {text: 'Status', value: 'status'},
            {text: 'Actions', value: 'actions', sortable: false},
        ],
        budgetRequests: [],
        departments: [],
        editedIndex: -1,
        editedItem: {
            id: null,
            department_id: '',
            request_amount: '',
        },
        defaultItem: {
            id: null,
            department_id: '',
            request_amount: '',
        },
        rules: [
            value => !!value || 'Required.',
        ],
        tableLoad: true
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Add Budget Request' : 'Edit Budget Request'
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
        async loadDepartments() {
            let res = await ApiServices.departmentIndex('department');
            if (res.success === true) {
                this.tableLoad = false;
                this.departments = res.data;
            }
        },

        async loadItems() {
            let res = await ApiServices.budgetRequestIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.budgetRequests = res.data;
            }
        },
        editItem(item) {
            this.editedIndex = this.budgetRequests.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.budgetRequests.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.budgetRequestDelete(this.editedItem.id);
            if (res.success === true) {
                this.budgetRequests.splice(this.editedIndex, 1)
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

        async save() {
            this.validateData();
            if (this.validated) {
                if (this.editedIndex > -1) {
                    //edit goes her
                    this.progressL = true;
                    const data = new FormData();
                    data.append('department_id', this.editedItem.department_id);
                    data.append('request_amount', this.editedItem.request_amount);
                    let res = await ApiServices.budgetRequestEdit(this.editedItem.id, data);
                    if (res.success === true) {
                        Object.assign(this.budgetRequests[this.editedIndex], this.editedItem)
                        this.$refs.form.reset();
                        this.close();
                    }
                } else {
                    this.progressL = true;
                    const data = new FormData();
                    data.append('department_id', this.editedItem.department_id);
                    data.append('request_amount', this.editedItem.request_amount);
                    let res = await ApiServices.budgetRequestCreate(data);
                    if (res.success === true) {
                        this.budgetRequests.push(this.editedItem);
                        this.$refs.form.reset();
                        this.close()
                    }
                }
            }
        },
        validateData() {
            this.$refs.form.validate();
            if (this.editedItem.department_id === '') {
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
