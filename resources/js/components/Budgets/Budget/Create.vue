<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>{{ $t('card_title.add_budget') }}</strong>
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
                                            v-model="title"
                                            :label="$t('title')"
                                            placeholder="Enter title..."
                                            prepend-icon="mdi-alpha-t-circle"
                                            required
                                            :rules="rules.title"
                                            solo
                                        />
                                        <v-select
                                            v-model="department_id"
                                            :items="departments"
                                            item-text="name"
                                            item-value="id"
                                            :label="$t('department')"
                                            placeholder="Select a department..."
                                            prepend-icon="mdi-alpha-d-circle"
                                            required
                                            :rules="rules.department_id"
                                            solo
                                        />
                                        <v-select
                                            v-model="fiscal_year_id"
                                            :items="fiscalYears"
                                            item-text="name"
                                            item-value="id"
                                            :label="$t('fiscal_year')"
                                            placeholder="Select a fiscal year..."
                                            prepend-icon="mdi-calendar-clock"
                                            required
                                            :rules="rules.fiscal_year_id"
                                            solo
                                        />
                                        <v-select
                                            v-model="type"
                                            :items="['Annual','Extra']"
                                            :label="$t('type')"
                                            placeholder="Select a budget type..."
                                            prepend-icon="mdi-shape"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="allocated_budget_amount"
                                            type="number"
                                            :label="$t('allocated_budget') +' '+ $t('amount')"
                                            placeholder="Enter the allocate budget amount..."
                                            prepend-icon="mdi-cash-check"
                                            required
                                            :rules="rules.allocated_budget_amount"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="initial_dispatched_amount"
                                            type="number"
                                            :label="$t('initial_dispatched') +' '+ $t('amount')"
                                            placeholder="Enter the initial dispatched amount..."
                                            prepend-icon="mdi-cash-marker"
                                            required
                                            :rules="rules.initial_dispatched_amount"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="date_first_received"
                                            type="date"
                                            :label="$t('date_first_received')"
                                            placeholder="Enter the first amount received date..."
                                            prepend-icon="mdi-calendar-month"
                                            :rules="rules.date_first_received"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="remarks"
                                            type="text"
                                            :label="$t('remarks')"
                                            placeholder="Enter remarks..."
                                            prepend-icon="mdi-pen"
                                            solo
                                        />
                                        <v-file-input
                                            v-model="file"
                                            :label="$t('file')"
                                            filled
                                            outlined
                                            prepend-icon="mdi-camera"
                                            accept="*/application"
                                        ></v-file-input>
                                    </v-form>
                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="create">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.submit') }}
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/budgets/'">
                                            <CIcon name="cil-ban"/>
                                            {{ $t('button.cancel') }}
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
    name: "BudgetCreate",

    props: {
        source: String,
    },
    data: () => ({
        department_id: '',
        fiscal_year_id: '',
        allocated_budget_amount: '',
        initial_dispatched_amount: '',
        date_first_received: '',
        remarks: '',
        file: [],
        title: '',
        type: '',
        departments: [],
        fiscalYears: [],
        createProgress: false,
        error: {
            title: '',
            department_id: '',
            fiscal_year_id: '',
            allocated_budget_amount: '',
            initial_dispatched_amount: '',
            date_first_received: '',
            remarks: '',
            file: [],
        },
        rules: {
            title: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            department_id: [
                val => val > 0 || i18n.t('validation.required'),
            ],
            fiscal_year_id: [
                val => val > 0 || i18n.t('validation.required'),
            ],
            allocated_budget_amount: [
                val => val >= 0 || i18n.t('validation.required'),
            ],
            initial_dispatched_amount: [
                val => val >= 0 || i18n.t('validation.required'),
            ],
            date_first_received: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
        },
    }),
    async created() {
        this.loadDepartments();
        this.loadFiscalYears();
    },
    methods: {
        async loadDepartments() {
            let res = await ApiServices.departmentIndex();
            if (res.success === true) {
                this.departments = res.data;
            }
        },

        async loadFiscalYears() {
            let res = await ApiServices.fiscalYearIndex();
            if (res.success === true) {
                this.fiscalYears = res.data;
            }
        },
        clearError(name) {
            if (name === 'title') {
                this.error.title = '';
            }
            if (name === 'department_id') {
                this.error.department_id = '';
            }
            if (name === 'fiscal_year_id') {
                this.error.fiscal_year_id = '';
            }
            if (name === 'allocated_budget_amount') {
                this.error.allocated_budget_amount = '';
            }
            if (name === 'initial_dispatched_amount') {
                this.error.initial_dispatched_amount = '';
            }
            if (name === 'date_first_received') {
                this.error.date_first_received = '';
            }
            if (name === 'remarks') {
                this.error.remarks = '';
            }
        },
        async create() {
            this.createProgress = true;
            const data = new FormData();
            data.append('title', this.title);
            data.append('department_id', this.department_id);
            data.append('fiscal_year_id', this.fiscal_year_id);
            data.append('type', this.type);
            data.append('allocated_budget_amount', this.allocated_budget_amount);
            data.append('initial_dispatched_amount', this.initial_dispatched_amount);
            data.append('date_first_received', this.date_first_received);
            data.append('remarks', this.remarks);
            if (typeof this.file.name == 'string') {
                data.append('file', this.file);
            }
            let res = await ApiServices.budgetCreate(data);
            this.createProgress = false;
            if (res.success === true) {
                route.replace('/budgets');
            }
        },
    }
}
</script>
