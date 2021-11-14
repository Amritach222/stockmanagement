<template>
    <div class="c-app flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Add</strong> Bank Account
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
                                        <v-text-field
                                            v-model="bank_name"
                                            type="text"
                                            name="bank_name"
                                            description="Please enter bank name."
                                            prepend-inner-icon="mdi-bank"
                                            autocomplete=""
                                            label="Bank Name"
                                            placeholder="Enter bank name..."
                                            required
                                            @keyup="clearError('bank_name')"
                                            @keyup.enter="create"
                                            :rules="rules.bank_name"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="account_no"
                                            type="text"
                                            name="account_no"
                                            description="Please enter account number."
                                            prepend-inner-icon="mdi-account"
                                            autocomplete=""
                                            label="Account Number"
                                            placeholder="Enter account number..."
                                            required
                                            @keyup="clearError('account_no')"
                                            @keyup.enter="create"
                                            :rules="rules.account_no"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="account_name"
                                            type="text"
                                            name="account_name"
                                            description="Please enter account name."
                                            prepend-inner-icon="mdi-account-details"
                                            autocomplete=""
                                            label="Account Name"
                                            placeholder="Enter account name..."
                                            required
                                            @keyup="clearError('account_name')"
                                            @keyup.enter="create"
                                            :rules="rules.account_name"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="total_balance"
                                            type="number"
                                            name="total_balance"
                                            description="Please enter the total balance."
                                            prepend-inner-icon="mdi-wallet"
                                            autocomplete=""
                                            label="Total Balance"
                                            placeholder="Enter the total balance..."
                                            @keyup="clearError('total_balance')"
                                            @keyup.enter="create"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="branch"
                                            type="text"
                                            name="branch"
                                            description="Please enter bank branch."
                                            prepend-inner-icon="mdi-source-branch"
                                            autocomplete=""
                                            label="Branch"
                                            placeholder="Enter bank branch..."
                                            @keyup="clearError('branch')"
                                            @keyup.enter="create"
                                            solo
                                        />
                                    </v-form>
                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="create">
                                            <CIcon name="cil-check-circle"/>
                                            Submit
                                        </CButton>
                                        <CButton type="reset" size="sm" color="danger" :to="'/bankAccounts'">
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

export default {
    name: "BankAccountCreate",

    props: {
        source: String,
    },
    data: () => ({
        bank_name: '',
        account_no: '',
        account_name: '',
        total_balance: '',
        branch: '',
        createProgress: false,
        error: {
            bank_name: '',
            account_no: '',
            account_name: '',
            total_balance: '',
            branch: '',
        },
        rules: {
            bank_name: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            account_name: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            account_no: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
        },
    }),
    methods: {
        clearError(name) {
            if (name === 'bank_name') {
                this.error.bank_name = '';
            }
            if (name === 'account_no') {
                this.error.account_no = '';
            }
            if (name === 'account_name') {
                this.error.account_name = '';
            }
            if (name === 'total_balance') {
                this.error.total_balance = '';
            }
            if (name === 'branch') {
                this.error.branch = '';
            }
        },
        async create() {
            this.createProgress = true;
            store.state.bankAccounts.bank_name = this.bank_name;
            store.state.bankAccounts.account_name = this.account_name;
            store.state.bankAccounts.account_no = this.account_no;
            store.state.bankAccounts.total_balance = this.total_balance;
            store.state.bankAccounts.branch = this.branch;
            let res = await store.dispatch('bankAccounts/bankAccountCreate');
            this.createProgress = false;
            if (res === true) {
                route.replace('/index');
            }
        },
    }
}
</script>
