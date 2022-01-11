<template>
    <v-card>
        <v-card-title>
            Budget Limit
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="budgetLimits"
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
                                v-if="$can('budgetLimits.create')"
                            >
                                Add New Budget Limit
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
                                                    v-model="editedItem.category_id"
                                                    :items="categories"
                                                    item-value="id"
                                                    item-text="name"
                                                    label="Category"
                                                    required
                                                    outlined
                                                    :rules="rules"
                                                ></v-select>
                                                <v-text-field
                                                    v-model="editedItem.amount"
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
            <template v-slot:item.category_id="{ item }">
                <p v-if="item.category_id">{{ item.category_name }}</p>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon
                    small
                    class="mr-2"
                    @click="editItem(item)"
                    v-if="$can('budgetLimits.edit')"
                >
                    mdi-pencil
                </v-icon>
                <v-icon
                    small
                    @click="deleteItem(item)"
                    v-if="$can('budgetLimits.delete')"
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
        validated1: false,
        validated2: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        headers: [
            {text: 'Id', align: 'start', sortable: true, value: 'id'},
            {text: 'Category', value: 'category_id'},
            {text: 'Amount', value: 'amount'},
            {text: 'Actions', value: 'actions', sortable: false},
        ],
        budgetLimits: [],
        categories: [],
        editedIndex: -1,
        editedItem: {
            id: null,
            category_id: '',
            amount: '',
        },
        defaultItem: {
            id: null,
            category_id: '',
            amount: '',
        },
        rules: [
            value => !!value || 'Required.',
        ],
        tableLoad: true
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Add Budget Limit' : 'Edit Budget Limit'
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
        this.loadCategories();
    },

    methods: {
        async loadCategories() {
            let res = await ApiServices.categoryIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.categories = res.data;
            }
        },

        async loadItems() {
            let res = await ApiServices.budgetLimitIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.budgetLimits = res.data;
            }
        },
        editItem(item) {
            this.editedIndex = this.budgetLimits.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.budgetLimits.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.budgetLimitDelete(this.editedItem.id);
            if (res.success === true) {
                this.budgetLimits.splice(this.editedIndex, 1)
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
            if (this.validated1 && this.validated2) {
                if (this.editedIndex > -1) {
                    //edit goes her
                    this.progressL = true;
                    const data = new FormData();
                    data.append('category_id', this.editedItem.category_id);
                    data.append('amount', this.editedItem.amount);
                    let res = await ApiServices.budgetLimitEdit(this.editedItem.id, data);
                    if (res.success === true) {
                        Object.assign(this.budgetLimits[this.editedIndex], this.editedItem)
                        this.$refs.form.reset();
                        this.close();
                    }
                } else {
                    this.progressL = true;
                    const data = new FormData();
                    data.append('category_id', this.editedItem.category_id);
                    data.append('amount', this.editedItem.amount);
                    let res = await ApiServices.budgetLimitCreate(data);
                    if (res.success === true) {
                        this.budgetLimits.push(this.editedItem);
                        this.$refs.form.reset();
                        this.close()
                    }
                }
            }
        },
        validateData() {
            this.$refs.form.validate();
            if (this.editedItem.category_id === '') {
                this.validated1 = false
            } else {
                this.validated1 = true
            }
            if (this.editedItem.amount === '') {
                this.validated2 = false
            } else {
                this.validated2 = true
            }
        }
    },
}
</script>


<style scoped>

</style>
