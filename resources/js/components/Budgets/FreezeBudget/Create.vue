<template>
    <CRow>
        <CCol sm="12">
            <CCard>
                <CCardHeader>
                    <strong>Add</strong> Freeze Budget
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
                            v-model="department_id"
                            name="department_id"
                            description="Please select a department."
                            autocomplete=""
                            label="Department"
                            placeholder="Select a department..."
                            required
                            @keyup="clearError('department_id')"
                            @keyup.enter="create"
                            :rules="rules.department_id"
                        />
                        <CSelect
                            v-model="fiscal_year_id"
                            name="fiscal_year_id"
                            description="Please select a fiscal year."
                            autocomplete=""
                            label="Fiscal Year"
                            placeholder="Select a fiscal year..."
                            required
                            @keyup="clearError('fiscal_year_id')"
                            @keyup.enter="create"
                            :rules="rules.fiscal_year_id"
                        />
                        <CInput
                            v-model="amount"
                            type="number"
                            name="amount"
                            description="Please enter freeze budget amount."
                            autocomplete=""
                            label="Amount"
                            placeholder="Enter the freeze budget amount..."
                            required
                            @keyup="clearError('amount')"
                            @keyup.enter="create"
                            :rules="rules.amount"
                        />
                        <CInput
                            v-model="remarks"
                            type="text"
                            name="remarks"
                            description="Please enter remarks."
                            autocomplete=""
                            label="Remarks"
                            placeholder="Enter remarks..."
                            @keyup="clearError('remarks')"
                            @keyup.enter="create"
                            :rules="rules.remarks"
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
    name: "FreezeBudgetCreate",

    props: {
        source: String,
    },
    data: () => ({
        department_id: '',
        fiscal_year_id: '',
        amount: '',
        remarks: '',
        createProgress: false,
        error: {
            department_id: '',
            fiscal_year_id: '',
            amount: '',
            remarks: '',
        },
        rules: {
            department_id: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            fiscal_year_id: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            amount: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            remarks: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
        },
    }),
    methods: {
        clearError(name) {
            if (name === 'department_id') {
                this.error.department_id = '';
            }
            if (name === 'fiscal_year_id') {
                this.error.fiscal_year_id = '';
            }
            if (name === 'amount') {
                this.error.amount = '';
            }
            if (name === 'remarks') {
                this.error.remarks = '';
            }
        },
        async create() {
            this.createProgress = true;
            store.state.budgets.department_id = this.department_id;
            store.state.budgets.fiscal_year_id = this.fiscal_year_id;
            store.state.budgets.amount = this.amount;
            store.state.budgets.remarks = this.remarks;
            let res = await store.dispatch('budgets/freezeBudgetCreate');
            this.createProgress = false;
            if (res === true) {
                route.replace('/index');
            }
        },
    }
}
</script>
