<template>
    <v-card>
        <v-card-title>
            Bank Account Transaction
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="bankAccountTransactions"
            sort-by="id"
            loading
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
                                Add New Bank Account Transaction
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
                                                    v-model="editedItem.account_id"
                                                    label="Bank Account"
                                                    :items="bankAccounts"
                                                    :item-text="bankAccount => bankAccount.bank_name +' - '+ bankAccount.account_name"
                                                    item-value="id"
                                                    required
                                                    outlined
                                                    :rules="rules.account_id"
                                                    class="shrink"
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <v-text-field
                                                    v-model="editedItem.transaction_amount"
                                                    label="Transaction Amount"
                                                    required
                                                    outlined
                                                    type="number"
                                                    :rules="rules.transaction_amount"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <v-select
                                                    v-model="editedItem.transaction_type"
                                                    label="Transaction Type"
                                                    :items="['CR','DR']"
                                                    outlined
                                                ></v-select>
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
            <template v-slot:item.account_id="{ item }">
                <p v-if="item.account_id" class="mt-3">{{ item.bank_name }}</p>
                <p v-else>----</p>
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
import countryList from "../../../services/lib/country.json";
import stateList from "../../../services/lib/state.json";
import cityList from "../../../services/lib/city.json";
import i18n from "../../../i18n";


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
            {text: 'Account', value: 'account_id'},
            {text: 'Amount', value: 'transaction_amount'},
            {text: 'Type', value: 'transaction_type'},
            // {text: 'Actions', value: 'actions', sortable: false},
        ],
        bankAccountTransactions: [],
        bankAccounts: [],
        editedIndex: -1,
        editedItem: {
            id: null,
            account_id: '',
            transaction_amount: '',
            transaction_type: '',
        },
        defaultItem: {
            id: null,
            account_id: '',
            transaction_amount: '',
            transaction_type: '',
        },
        rules: {
            account_id: [
                val => val > 0 || i18n.t('validation.required'),
            ],
            transaction_amount: [
                val => val >= 0 || i18n.t('validation.required'),
            ],
        },
        tableLoad: false,
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Add Bank Account Transaction' : 'Edit Bank Account Transaction'
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
        this.loadBankAccounts();
    },

    methods: {
        async loadItems() {
            let res = await ApiServices.bankAccountTransactionIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.bankAccountTransactions = res.data;
            }
        },
        async loadBankAccounts() {
            let res = await ApiServices.bankAccountIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.bankAccounts = res.data;
            }
        },
        editItem(item) {
            this.editedIndex = this.bankAccountTransactions.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.bankAccountTransactions.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.bankAccountTransactionDelete(this.editedItem.id);
            if (res.success === true) {
                this.bankAccountTransactions.splice(this.editedIndex, 1)
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
                    this.progressL = true;
                    const data = new FormData();
                    data.append('account_id', this.editedItem.account_id);
                    data.append('transaction_amount', this.editedItem.transaction_amount);
                    data.append('transaction_type', this.editedItem.transaction_type);
                    let res = await ApiServices.bankAccountTransactionEdit(this.editedItem.id, data);
                    if (res.success === true) {
                        Object.assign(this.bankAccountTransactions[this.editedIndex], this.editedItem)
                        this.$refs.form.reset();
                        this.close();
                    }
                } else {
                    this.progressL = true;
                    const data = new FormData();
                    data.append('account_id', this.editedItem.account_id);
                    data.append('transaction_amount', this.editedItem.transaction_amount);
                    data.append('transaction_type', this.editedItem.transaction_type);
                    let res = await ApiServices.bankAccountTransactionCreate(data);
                    if (res.success === true) {
                        this.bankAccountTransactions.push(this.editedItem);
                        this.$refs.form.reset();
                        this.close()
                    }
                }
            }
        },
        validateData() {
            this.$refs.form.validate();
            if (this.editedItem.account_id === '') {
                this.validated = false
            }
            if (this.editedItem.transaction_amount === '') {
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
