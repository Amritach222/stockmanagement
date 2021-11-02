<template>
    <CRow>
        <CCol sm="12">
            <CCard>
                <CCardHeader>
                    <strong>Add</strong> Bank Account Transaction
                    <v-progress-circular
                        v-if="createProgress"
                        indeterminate
                        color="white"
                        size="30"
                    ></v-progress-circular>
                </CCardHeader>
                <CForm>
                    <CCardBody>
                        <CSelect
                            v-model="account_id"
                            name="account_id"
                            description="Please select bank account."
                            autocomplete=""
                            label="Bank Account"
                            placeholder="Select bank account..."
                            required
                            @keyup="clearError('account_id')"
                            @keyup.enter="create"
                            :rules="rules.account_id"
                        />
                        <CInput
                            v-model="transaction_amount"
                            type="number"
                            name="transaction_amount"
                            description="Please enter transaction amount."
                            autocomplete=""
                            label="Transaction Amount"
                            placeholder="Enter transaction amount..."
                            required
                            @keyup="clearError('transaction_amount')"
                            @keyup.enter="create"
                            :rules="rules.transaction_amount"
                        />
                        <CInput
                            v-model="transaction_type"
                            type="text"
                            name="transaction_type"
                            description="Please enter transaction type."
                            autocomplete=""
                            label="Transaction Type"
                            placeholder="Enter transaction type..."
                            @keyup="clearError('transaction_type')"
                            @keyup.enter="create"
                        />
                    </CCardBody>
                    <CCardFooter>
                        <CButton type="submit" size="sm" color="primary" @click="create">
                            <CIcon name="cil-check-circle"/>
                            Submit
                        </CButton>
                        <CButton type="reset" size="sm" color="danger">
                            <CIcon name="cil-ban"/>
                            Reset
                        </CButton>
                    </CCardFooter>
                </CForm>
            </CCard>
        </CCol>
    </CRow>
</template>

<script>
import store from "../../../store";
import route from "../../../router";
import i18n from "../../../i18n";

export default {
    name: "BankAccountTransactionCreate",

    props: {
        source: String,
    },
    data: () => ({
        account_id: '',
        transaction_type: '',
        transaction_amount: '',
        createProgress: false,
        error: {
            account_id: '',
            transaction_type: '',
            transaction_amount: '',
        },
        rules: {
            account_id: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            transaction_amount: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
        },
    }),
    methods: {
        clearError(name) {
            if (name === 'account_id') {
                this.error.account_id = '';
            }
            if (name === 'transaction_amount') {
                this.error.transaction_amount = '';
            }
            if (name === 'transaction_type') {
                this.error.transaction_type = '';
            }
        },
        async create() {
            this.createProgress = true;
            store.state.bankAccounts.account_id = this.account_id;
            store.state.bankAccounts.transaction_amount = this.transaction_amount;
            store.state.bankAccounts.transaction_type = this.transaction_type;
            let res = await store.dispatch('bankAccounts/bankAccountTransactionCreate');
            this.createProgress = false;
            if (res === true) {
                route.replace('/index');
            }
        },
    }
}
</script>
