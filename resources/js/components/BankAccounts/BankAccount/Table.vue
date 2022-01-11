<template>
    <v-card>
        <v-card-title>
            Bank Account
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="bankAccounts"
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
                                v-if="$can('bankAccounts.create')"
                            >
                                Add New Bank Account
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
                                                    v-model="editedItem.bank_name"
                                                    label="Bank Name"
                                                    required
                                                    outlined
                                                    :rules="rules.bank_name"
                                                    class="shrink"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col>
                                                <v-text-field
                                                    v-model="editedItem.branch"
                                                    label="Bank Branch"
                                                    outlined
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <v-text-field
                                                    v-model="editedItem.account_no"
                                                    label="Account No."
                                                    required
                                                    outlined
                                                    :rules="rules.account_no"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col>
                                                <v-text-field
                                                    v-model="editedItem.account_name"
                                                    label="Account Name."
                                                    required
                                                    outlined
                                                    :rules="rules.account_name"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <v-text-field
                                                    v-model="editedItem.total_balance"
                                                    label="Total Balance"
                                                    required
                                                    outlined
                                                    type="number"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col>
                                                <v-text-field
                                                    v-model="editedItem.current_balance"
                                                    label="Current Balance"
                                                    outlined
                                                    required
                                                    :rules="rules.current_balance"
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
            <template v-slot:item.actions="{ item }">
                <router-link
                    :to="'/bankAccounts/'+item.id"
                    v-if="$can('bankAccounts.show')"
                >
                    <v-icon
                        small
                    >
                        mdi-eye
                    </v-icon>
                </router-link>
                <v-icon
                    small
                    class="mr-2"
                    @click="editItem(item)"
                    v-if="$can('bankAccounts.edit')"
                >
                    mdi-pencil
                </v-icon>
                <v-icon
                    small
                    @click="deleteItem(item)"
                    v-if="$can('bankAccounts.delete')"
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
            {text: 'Bank Name', value: 'bank_name'},
            {text: 'Branch', value: 'branch'},
            {text: 'Account No', value: 'account_no'},
            {text: 'Name', value: 'account_name'},
            {text: 'Total', value: 'total_balance'},
            {text: 'Current', value: 'current_balance'},
            {text: 'Actions', value: 'actions', sortable: false},
        ],
        bankAccounts: [],
        editedIndex: -1,
        editedItem: {
            id: null,
            bank_name: '',
            branch: '',
            account_no: '',
            account_name: '',
            total_balance: '',
            current_balance: '',
        },
        defaultItem: {
            id: null,
            bank_name: '',
            branch: '',
            account_no: '',
            account_name: '',
            total_balance: '',
            current_balance: '',
        },
        rules: {
            bank_name: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ], account_name: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            account_no: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            total_balance: [
                val => val >= 0 || i18n.t('validation.required'),
            ],
            current_balance: [
                val => val >= 0 || i18n.t('validation.required'),
            ],
        },
        tableLoad: true,
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Add Bank Account' : 'Edit Bank Account'
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
            let res = await ApiServices.bankAccountIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.bankAccounts = res.data;
            }
        },
        editItem(item) {
            this.editedIndex = this.bankAccounts.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.bankAccounts.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.bankAccountDelete(this.editedItem.id);
            if (res.success === true) {
                this.bankAccounts.splice(this.editedIndex, 1)
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
                    data.append('bank_name', this.editedItem.bank_name);
                    data.append('branch', this.editedItem.branch);
                    data.append('account_no', this.editedItem.account_no);
                    data.append('account_name', this.editedItem.account_name);
                    data.append('total_balance', this.editedItem.total_balance);
                    data.append('current_balance', this.editedItem.current_balance);
                    let res = await ApiServices.bankAccountEdit(this.editedItem.id, data);
                    if (res.success === true) {
                        Object.assign(this.bankAccounts[this.editedIndex], this.editedItem)
                        this.$refs.form.reset();
                        this.close();
                    }
                } else {
                    this.progressL = true;
                    const data = new FormData();
                    data.append('bank_name', this.editedItem.bank_name);
                    data.append('branch', this.editedItem.branch);
                    data.append('account_no', this.editedItem.account_no);
                    data.append('account_name', this.editedItem.account_name);
                    data.append('total_balance', this.editedItem.total_balance);
                    data.append('current_balance', this.editedItem.current_balance);
                    let res = await ApiServices.bankAccountCreate(data);
                    if (res.success === true) {
                        this.bankAccounts.push(this.editedItem);
                        this.$refs.form.reset();
                        this.close()
                    }
                }
            }
        },
        validateData() {
            this.$refs.form.validate();
            if (this.editedItem.bank_name === '') {
                this.validated = false
            }
            if (this.editedItem.account_name === '') {
                this.validated = false
            }
            if (this.editedItem.account_no === '') {
                this.validated = false
            }
            if (this.editedItem.total_balance === '') {
                this.validated = false
            }
            if (this.editedItem.current_balance === '') {
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
