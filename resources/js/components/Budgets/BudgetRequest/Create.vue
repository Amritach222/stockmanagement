<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Add</strong> Budget Request
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
                                            :items="departments"
                                            item-value="id"
                                            item-text="name"
                                            label="Department"
                                            placeholder="Select a department..."
                                            prepend-icon="mdi-alpha-d-circle"
                                            required
                                            :rules="rules.department_id"
                                            solo
                                        />
                                        <v-select
                                            v-model="type"
                                            :items="['Annual Request','Extend Request']"
                                            label="Type"
                                            placeholder="Select a request type..."
                                            prepend-icon="mdi-shape"
                                            required
                                            :rules="rules.type"
                                            solo
                                        />
                                        <v-select
                                            v-model="fiscal_year_id"
                                            :items="fiscalYears"
                                            item-value="id"
                                            item-text="name"
                                            label="Fiscal Year"
                                            placeholder="Select a fiscal year..."
                                            prepend-icon="mdi-calendar-month"
                                            required
                                            :rules="rules.fiscal_year_id"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="request_amount"
                                            type="number"
                                            label="Amount"
                                            placeholder="Enter the amount..."
                                            prepend-icon="mdi-cash-check"
                                            required
                                            :rules="rules.request_amount"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="remarks"
                                            type="text"
                                            label="Remarks"
                                            placeholder="Enter remarks..."
                                            prepend-icon="mdi-pen"
                                            solo
                                        />
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
                                        <CButton size="sm" color="danger" :to="'/budgetRequests/'">
                                            <CIcon name="cil-ban"/>
                                            Reset
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
    name: "BudgetRequestCreate",

    props: {
        source: String,
    },
    data: () => ({
        department_id: '',
        fiscal_year_id: '',
        type: '',
        request_amount: '',
        remarks: '',
        file: [],
        departments: [],
        fiscalYears:[],
        createProgress: false,
        error: {
            department_id: '',
            fiscal_year_id: '',
            type: '',
            request_amount: '',
            remarks: '',
            file: [],
        },
        rules: {
            department_id: [
                val => val > 0 || i18n.t('validation.required'),
            ],
            fiscal_year_id: [
                val => val > 0 || i18n.t('validation.required'),
            ],
            type: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            request_amount: [
                val => val >= 0 || i18n.t('validation.required'),
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
            if (name === 'department_id') {
                this.error.department_id = '';
            }
            if (name === 'fiscal_year_id') {
                this.error.fiscal_year_id = '';
            }
            if (name === 'type') {
                this.error.type = '';
            }
            if (name === 'request_amount') {
                this.error.request_amount = '';
            }
            if (name === 'remarks') {
                this.error.remarks = '';
            }
        },
        async create() {
            this.createProgress = true;
            const data = new FormData();
            data.append('department_id', this.department_id);
            data.append('fiscal_year_id', this.fiscal_year_id);
            data.append('type', this.type);
            data.append('request_amount', this.request_amount);
            data.append('remarks', this.remarks);
            if (typeof this.file.name == 'string') {
                data.append('file', this.file);
            }
            let res = await ApiServices.budgetRequestCreate(data);
            this.createProgress = false;
            if (res.success === true) {
                route.replace('/budgetRequests');
            }
        },
    }
}
</script>
