<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Edit</strong> Expense
                                <v-progress-circular
                                    v-if="changeProgress"
                                    indeterminate
                                    color="white"
                                    size="30"
                                ></v-progress-circular>
                            </CCardHeader>
                            <CCardBody>
                                <CForm>
                                    <v-form>
                                        <v-select
                                            v-model="editedItem.department_id"
                                            label="Department"
                                            :items="departments"
                                            item-value="id"
                                            item-text="name"
                                            prepend-icon="mdi-alpha-d-circle"
                                            required
                                            solo
                                            :rules="rules"
                                        ></v-select>
                                        <v-select
                                            v-model="editedItem.user_id"
                                            label="User"
                                            :items="users"
                                            item-value="id"
                                            item-text="name"
                                            prepend-icon="mdi-account"
                                            required
                                            solo
                                            :rules="rules"
                                        ></v-select>
                                        <v-select
                                            v-model="editedItem.expense_category_id"
                                            label="Expense Category"
                                            :items="expenseCategories"
                                            item-value="id"
                                            item-text="name"
                                            prepend-icon="mdi-shape"
                                            required
                                            solo
                                            :rules="rules"
                                        ></v-select>
                                        <v-text-field
                                            v-model="editedItem.amount"
                                            label="Amount"
                                            type="number"
                                            prepend-icon="mdi-currency-usd"
                                            required
                                            solo
                                            :rules="rules"
                                        ></v-text-field>
                                        <v-select
                                            v-model="editedItem.transaction_type"
                                            label="Transaction Type"
                                            id="transaction_type"
                                            :items="['Cash', 'Cheque', 'OnlineTransaction']"
                                            prepend-icon="mdi-swap-horizontal"
                                            v-on:change="transaction"
                                            solo
                                        ></v-select>
                                        <div v-if="this.bank_account">
                                            <v-select
                                                v-model="editedItem.bank_account_id"
                                                label="Bank Account"
                                                :items="bankAccounts"
                                                :item-text="bankAccount => bankAccount.bank_name + ' - ' + bankAccount.account_name"
                                                item-value="id"
                                                prepend-icon="mdi-bank"
                                                solo
                                            ></v-select>
                                        </div>
                                        <div v-if="this.cheque">
                                            <v-text-field
                                                v-model="editedItem.cheque_no"
                                                label="Cheque No."
                                                type="number"
                                                prepend-icon="mdi-checkbook"
                                                solo
                                            ></v-text-field>
                                        </div>
                                        <v-text-field
                                            v-model="editedItem.note"
                                            label="Note"
                                            prepend-icon="mdi-pen"
                                            solo
                                        ></v-text-field>
                                        <v-row>
                                            <v-col v-if="typeof(editedItem.link) === 'string'">
                                                <v-file-input
                                                    v-model="editedItem.file"
                                                    label="File"
                                                    filled
                                                    outlined
                                                    prepend-icon="mdi-camera"
                                                    accept="*/application"
                                                ></v-file-input>
                                                <v-col width="200" class="ml-3 file-link"
                                                       v-on:click="openImage(editedItem.link)">
                                                    <h5> Open File </h5>
                                                </v-col>
                                            </v-col>
                                            <v-col v-else>
                                                <v-file-input
                                                    v-model="editedItem.file"
                                                    label="File"
                                                    filled
                                                    outlined
                                                    prepend-icon="mdi-camera"
                                                    accept="*/application"
                                                ></v-file-input>
                                            </v-col>
                                        </v-row>
                                    </v-form>
                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="edit">
                                            <CIcon name="cil-check-circle"/>
                                            Submit
                                        </CButton>
                                        <CButton type="reset" size="sm" color="danger" :to="'/expenses/'">
                                            <CIcon name="cil-ban"/>
                                            Cancel
                                        </CButton>
                                    </CCardFooter>
                                </CForm>
                            </CCardBody>
                        </CCard>
                    </CCardGroup>
                </CCol>
            </CRow>
        </CContainer>
    </div>
</template>

<script>
import store from "../../../store";
import route from "../../../router";
import i18n from "../../../i18n";
import ApiServices from "../../../services/ApiServices";
import config from "../../../config";

export default {
    name: "ExpenseEdit",

    props: {
        source: String,
    },
    data: () => ({
        editedItem: {
            user_id: '',
            department_id: '',
            amount: '',
            transaction_type: '',
            bank_account_id: '',
            cheque_no: '',
            expense_category_id: '',
            note: '',
            file: [],
        },
        cdnURL: config.cdnURL,
        departments: [],
        users: [],
        bankAccounts: [],
        expenseCategories: [],
        validated: false,
        changeProgress: false,
        bank_account: false,
        cheque: false,
        error: {
            user_id: '',
            department_id: '',
            amount: '',
            transaction_type: '',
            bank_account_id: '',
            cheque_no: '',
            expense_category_id: '',
            note: '',
            file: [],
        },
        rules: [
            value => !!value || 'Required.',
        ],
    }),
    async created() {
        this.loadData();
        this.loadBankAccounts();
        this.loadExpenseCategories();
        this.loadDepartments();
        this.loadUsers();
    },
    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },

        async loadData() {
            let res = await ApiServices.expenseShow(this.$route.params.id);
            if (res.success === true) {
                this.editedItem = res.data;
            }
        },

        async loadDepartments() {
            let res = await ApiServices.departmentIndex();
            if (res.success === true) {
                this.departments = res.data;
            }
        },

        async loadUsers() {
            let res = await ApiServices.userIndex();
            if (res.success === true) {
                this.users = res.data;
            }
        },

        async loadBankAccounts() {
            let res = await ApiServices.bankAccountIndex();
            if (res.success === true) {
                this.bankAccounts = res.data;
            }
        },

        async loadExpenseCategories() {
            let res = await ApiServices.expenseCategoryIndex();
            if (res.success === true) {
                this.expenseCategories = res.data;
            }
        },

        async transaction() {
            this.bank_account = false;
            this.cheque = false;
            if (this.editedItem.transaction_type === 'OnlineTransaction') {
                this.bank_account = true;
            } else if (this.editedItem.transaction_type === 'Cheque') {
                this.bank_account = true;
                this.cheque = true;
            }
        },

        async edit() {
            this.changeProgress = true;
            const data = new FormData();
            data.append('department_id', this.editedItem.department_id);
            data.append('user_id', this.editedItem.user_id);
            data.append('expense_category_id', this.editedItem.expense_category_id);
            data.append('amount', parseInt(this.editedItem.amount));
            data.append('transaction_type', this.editedItem.transaction_type);
            if (this.editedItem.cheque_no !== '') {
                data.append('cheque_no', this.editedItem.cheque_no);
            }
            if (this.bank_account_id !== '') {
                data.append('bank_account_id', this.editedItem.bank_account_id);
            }
            data.append('note', this.editedItem.note);
            if ('file' in this.editedItem) {
                if (typeof this.file.name == 'string') {
                    data.append('file', this.file);
                }
            }
            let res = await ApiServices.expenseEdit(this.editedItem.id, data);
            this.changeProgress = false;
            if (res.success === true) {
                route.replace('/expenses/');
            }
        },
    }
}
</script>
<style scoped>
.hide {
    display: none;
}

.show {
    display: block;
}
</style>
