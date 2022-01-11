<template>
    <v-card>
        <v-card-title>
            Expense Categories
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="expenseCategories"
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
                                v-if="$can('expenseCategories.create')"
                            >
                                Add New Expense Category
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
                                                    label="Category Name"
                                                    required
                                                    outlined
                                                    :rules="rules"
                                                ></v-text-field>
                                                <v-checkbox
                                                    v-model="editedItem.is_active"
                                                    id="is_active"
                                                    label="Active"
                                                    outlined
                                                ></v-checkbox>
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
            <template v-slot:item.is_active="{ item }">
                <CButton size="sm" v-if="item.is_active == 1" color="primary">
                    Active
                </CButton>
                <CButton size="sm" v-else color="danger">
                    Inactive
                </CButton>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon
                    small
                    class="mr-2"
                    @click="editItem(item)"
                    v-if="$can('expenseCategories.edit')"
                >
                    mdi-pencil
                </v-icon>
                <v-icon
                    small
                    @click="deleteItem(item)"
                    v-if="$can('expenseCategories.delete')"
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
            {text: 'Id', align: 'start', sortable: false, value: 'id'},
            {text: 'Name', value: 'name'},
            {text: 'Active', value: 'is_active'},
            {text: 'Actions', value: 'actions', sortable: false},
        ],
        expenseCategories: [],
        editedIndex: -1,
        editedItem: {
            id: null,
            name: '',
            is_active: '',
        },
        defaultItem: {
            id: null,
            name: '',
            is_active: '',
        },
        rules: [
            value => !!value || 'Required.',
        ],
        tableLoad: true
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Add Expense Category' : 'Edit Expense Category'
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
    },

    methods: {
        async loadItems() {
            let res = await ApiServices.expenseCategoryIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.expenseCategories = res.data;
            }
        },
        editItem(item) {
            this.editedIndex = this.expenseCategories.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.expenseCategories.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.expenseCategoryDelete(this.editedItem.id);
            if (res.success === true) {
                this.expenseCategories.splice(this.editedIndex, 1)
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
                var checkbox = document.getElementById('is_active');
                if (this.editedIndex > -1) {
                    this.progressL = true;
                    const data = new FormData();
                    data.append('name', this.editedItem.name);
                    if (checkbox.checked) {
                        data.append('is_active', 1);
                    } else {
                        data.append('is_active', 0);
                    }

                    let res = await ApiServices.expenseCategoryEdit(this.editedItem.id, data);
                    if (res.success === true) {
                        Object.assign(this.expenseCategories[this.editedIndex], this.editedItem)
                        this.$refs.form.reset();
                        this.close();
                    }
                } else {
                    this.progressL = true;
                    const data = new FormData();
                    data.append('name', this.editedItem.name);
                    if (checkbox.checked) {
                        data.append('is_active', 1);
                    } else {
                        data.append('is_active', 0);
                    }

                    let res = await ApiServices.expenseCategoryCreate(data);
                    if (res.success === true) {
                        this.expenseCategories.push(this.editedItem);
                        this.$refs.form.reset();
                        this.close()
                    }
                }
            }
        },
        validateData() {
            this.$refs.form.validate();
            if (this.editedItem.name === '') {
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
