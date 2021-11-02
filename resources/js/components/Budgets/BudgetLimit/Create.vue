<template>
    <CRow>
        <CCol sm="12">
            <CCard>
                <CCardHeader>
                    <strong>Add</strong> Budget Limit
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
                            v-model="category_id"
                            name="category_id"
                            description="Please select a category."
                            autocomplete=""
                            label="Category"
                            placeholder="Select a category..."
                            required
                            @keyup="clearError('category_id')"
                            @keyup.enter="create"
                            :rules="rules.category_id"
                        />
                        <CInput
                            v-model="amount"
                            type="number"
                            name="amount"
                            description="Please enter limited amount."
                            autocomplete=""
                            label="Amount"
                            placeholder="Enter amount..."
                            required
                            @keyup="clearError('amount')"
                            @keyup.enter="create"
                            :rules="rules.amount"
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
    name: "BudgetLimitCreate",

    props: {
        source: String,
    },
    data: () => ({
        category_id: '',
        amount: '',
        createProgress: false,
        error: {
            category_id: '',
            amount: '',
        },
        rules: {
            category_id: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            amount: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
        },
    }),
    methods: {
        clearError(name) {
            if (name === 'category_id') {
                this.error.department_id = '';
            }
            if (name === 'amount') {
                this.error.amount = '';
            }
        },
        async create() {
            this.createProgress = true;
            store.state.budgets.department_id = this.department_id;
            store.state.budgets.amount = this.amount;
            let res = await store.dispatch('budgets/budgetLimitCreate');
            this.createProgress = false;
            if (res === true) {
                route.replace('/index');
            }
        },
    }
}
</script>
