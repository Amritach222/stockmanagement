<template>
    <CRow>
        <CCol sm="12">
            <CCard>
                <CCardHeader>
                    <strong>Edit</strong> Budget Request
                    <v-progress-circular
                        v-if="changeProgress"
                        indeterminate
                        color="white"
                        size="30"
                    ></v-progress-circular>
                </CCardHeader>
                <CForm>
                    <CCardBody>
                        <CSelect
                            v-model="department_id"
                            name="department_id"
                            description="Please select a department."
                            autocomplete=""
                            label="Department"
                            placeholder="Select a department..."
                            required
                            @keyup="clearError('department_id')"
                            @keyup.enter="edit"
                            :rules="rules.department_id"
                        />
                        <CInput
                            v-model="amount"
                            type="number"
                            name="amount"
                            description="Please enter the request amount."
                            autocomplete=""
                            label="Amount"
                            placeholder="Enter the amount..."
                            required
                            @keyup="clearError('amount')"
                            @keyup.enter="edit"
                            :rules="rules.amount"
                        />
                    </CCardBody>
                    <CCardFooter>
                        <CButton type="submit" size="sm" color="primary" @click="edit">
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
    name: "BudgetRequestEdit",

    props: {
        source: String,
    },
    data: () => ({
        department_id: '',
        amount: '',
        changeProgress: false,
        error: {
            department_id: '',
            amount: '',
        },
        rules: {
            department_id: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            amount: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
        },
    }),
    methods: {
        clearError(name) {
            if (name === 'department_id') {
                this.error.department_id = '';
            }
            if (name === 'amount') {
                this.error.amount = '';
            }
        },
        async edit() {
            this.changeProgress = true;
            store.state.budgets.department_id = this.department_id;
            store.state.budgets.amount = this.amount;
            store.state.budgets.id = this.$route.params.id;
            let res = await store.dispatch('budgets/budgetRequestEdit');
            this.changeProgress = false;
            if (res === true) {
                route.replace('/index');
            }
        },
    }
}
</script>
