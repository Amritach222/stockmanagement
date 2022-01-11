<template>
    <v-card>
        <v-card-title>
            Expenses
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="expenses"
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
                                :to="'/expenses/create/'"
                                v-if="$can('expenses.create')"
                            >
                                Add New Expense
                            </v-btn>
                        </template>
                        <v-card>

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
                <p v-if="item.department_id">{{ item.department.name }}</p>
            </template>
            <template v-slot:item.user_id="{ item }">
                <p v-if="item.user_id">{{ item.user.name }}</p>
            </template>
            <template v-slot:item.expense_category_id="{ item }">
                <p v-if="item.expense_category_id">{{ item.expense_category.name }}</p>
            </template>
            <template v-slot:item.actions="{ item }">
                <router-link
<<<<<<< HEAD
                    :to="'/expenses/'+item.id"
                    v-if="$can('expenses.show')"
                >
                    <v-icon
                        small
                    >
                        mdi-eye
                    </v-icon>
                </router-link>
                <router-link
=======
>>>>>>> origin/dev-sam
                    :to="'/expenses/edit/'+item.id"
                    v-if="$can('expenses.edit')"
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
                    v-if="$can('expenses.delete')"
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
            {text: 'Department', value: 'department_id'},
            {text: 'User', value: 'user_id'},
            {text: 'Expense Category', value: 'expense_category_id'},
            {text: 'Amount', value: 'amount'},
            {text: 'Type', value: 'transaction_type'},
            {text: 'Actions', value: 'actions', sortable: false},
        ],
        expenses: [],
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
            let res = await ApiServices.expenseIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.expenses = res.data;
            }
        },

        deleteItem(item) {
            this.editedIndex = this.expenses.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.expenseDelete(this.editedItem.id);
            if (res.success === true) {
                this.expenses.splice(this.editedIndex, 1)
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
    },
}
</script>


<style scoped>

</style>
