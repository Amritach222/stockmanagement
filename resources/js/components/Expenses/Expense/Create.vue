<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Add</strong> Expense
                                <v-progress-circular
                                    v-if="createProgress"
                                    indeterminate
                                    color="white"
                                    size="30"
                                ></v-progress-circular>
                            </CCardHeader>
                            <CCardBody>
                                <CForm>
                                    <v-form>
                                        <v-select
                                            v-model="department_id"
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
                                            v-model="user_id"
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
                                            v-model="expense_category_id"
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
                                            v-model="amount"
                                            label="Amount"
                                            type="number"
                                            prepend-icon="mdi-currency-usd"
                                            required
                                            solo
                                            :rules="rules"
                                        ></v-text-field>
                                        <v-select
                                            v-model="transaction_type"
                                            label="Transaction Type"
                                            id="transaction_type"
                                            :items="['Cash', 'Cheque', 'OnlineTransaction']"
                                            prepend-icon="mdi-swap-horizontal"
                                            solo
                                        ></v-select>
                                        <v-select
                                            v-model="bank_account_id"
                                            label="Bank Account"
                                            :items="bankAccounts"
                                            :item-text="bankAccount => bankAccount.bank_name + ' - ' + bankAccount.account_name"
                                            item-value="id"
                                            class="hide"
                                            prepend-icon="mdi-bank"
                                            solo
                                        ></v-select>
                                        <v-text-field
                                            v-model="cheque_no"
                                            label="Cheque No."
                                            type="number"
                                            class="hide"
                                            prepend-icon="mdi-checkbook"
                                            solo
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="note"
                                            label="Note"
                                            prepend-icon="mdi-pen"
                                            solo
                                        ></v-text-field>
                                        <v-file-input
                                            v-model="file"
                                            label="File"
                                            filled
                                            outlined
                                            prepend-icon="mdi-camera"
                                            accept="*/application"
                                        ></v-file-input>
                                    </v-form>
                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="create">
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


export default {
    name: "ExpenseCreate",

    props: {
        source: String,
    },
    data: () => ({
        user_id: '',
        department_id: '',
        amount: '',
        transaction_type: '',
        bank_account_id: '',
        cheque_no: '',
        expense_category_id: '',
        note: '',
        file: [],
        validated: false,
        departments: [],
        users: [],
        bankAccounts: [],
        expenseCategories: [],
        createProgress: false,
        error: {
            user_id: '',
            department_id: '',
            amount: '',
            transaction_type: '',
            bank_account_id: '',
            cheque_no: '',
            expense_category_id: '',
            note: '',
            file_id: [],
        },
        rules: [
            value => !!value || 'Required.',
        ]
    }),
    async created() {
        this.loadBankAccounts();
        this.loadExpenseCategories();
        this.loadDepartments();
        this.loadUsers();
    },
    methods: {
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

        async create() {
            this.validate();
            if (this.validated) {
                this.createProgress = true;
                const data = new FormData();
                data.append('department_id', this.department_id);
                data.append('user_id', this.user_id);
                data.append('expense_category_id', this.expense_category_id);
                data.append('amount', this.amount);
                data.append('transaction_type', this.transaction_type);
                if (this.cheque_no !== '') {
                    data.append('cheque_no', this.cheque_no);
                }
                if (this.bank_account_id !== '') {
                    data.append('bank_account_id', this.bank_account_id);
                }
                data.append('note', this.note);
                if (typeof this.file.name == 'string') {
                    data.append('file', this.file);
                }
                let res = await ApiServices.expenseCreate(data);
                this.createProgress = false;
                if (res.success === true) {
                    route.replace('/expenses/');
                }
            }
        },
        validate() {
            if (this.department_id === '') {
                this.validated = false;
            }
            if (this.user_id === '') {
                this.validated = false;
            }
            if (this.expense_category_id === '') {
                this.validated = false;
            }
            if (this.bank_account_id === '') {
                this.validated = false;
            }
            if (this.amount === '') {
                this.validated = false;
            } else {
                this.validated = true;
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
