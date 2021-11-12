<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Edit</strong> Budget
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
                                            v-model="editedItem.title"
                                            label="Title"
                                            placeholder="Enter title..."
                                            prepend-icon="mdi-alpha-d-circle"
                                            required
                                            :rules="rules.title"
                                            solo
                                        />
                                        <v-select
                                            v-model="editedItem.department_id"
                                            :items="departments"
                                            item-text="name"
                                            item-value="id"
                                            label="Department"
                                            placeholder="Select a department..."
                                            prepend-icon="mdi-alpha-d-circle"
                                            required
                                            :rules="rules.department_id"
                                            solo
                                        />
                                        <v-select
                                            v-model="editedItem.fiscal_year_id"
                                            :items="fiscalYears"
                                            item-text="name"
                                            item-value="id"
                                            label="Fiscal Year"
                                            placeholder="Select a fiscal year..."
                                            prepend-icon="mdi-calendar-clock"
                                            required
                                            :rules="rules.fiscal_year_id"
                                            solo
                                        />
                                        <v-select
                                            v-model="editedItem.type"
                                            :items="['Annual','Extra']"
                                            label="Type"
                                            placeholder="Select a budget type..."
                                            prepend-icon="mdi-calendar-clock"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.allocated_budget_amount"
                                            type="number"
                                            label="Allocated Budget Amount"
                                            placeholder="Enter the allocate budget amount..."
                                            prepend-icon="mdi-cash-check"
                                            required
                                            :rules="rules.allocated_budget_amount"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.initial_dispatched_amount"
                                            type="number"
                                            label="Initial Dispatched Amount"
                                            placeholder="Enter the initial dispatched amount..."
                                            prepend-icon="mdi-cash-marker"
                                            required
                                            :rules="rules.initial_dispatched_amount"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.date_first_received"
                                            type="date"
                                            label="Initial Dispatched Amount"
                                            placeholder="Enter the first amount received date..."
                                            prepend-icon="mdi-calendar-month"
                                            :rules="rules.date_first_received"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.remarks"
                                            type="text"
                                            label="Remarks"
                                            placeholder="Enter remarks..."
                                            prepend-icon="mdi-pen"
                                            solo
                                        />
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
                                        <CButton size="sm" color="danger" :to="'/budgets/'">
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
    name: "BudgetEdit",

    props: {
        source: String,
    },
    data: () => ({
        editedItem: {
            id: null,
            title: '',
            department_id: '',
            fiscal_year_id: '',
            type: '',
            allocated_budget_amount: '',
            initial_dispatched_amount: '',
            date_first_received: '',
            remarks: '',
            file: [],
        },
        cdnURL: config.cdnURL,
        departments: [],
        fiscalYears: [],
        changeProgress: false,
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
        this.loadData();
        this.loadDepartments();
        this.loadFiscalYears();
    },
    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadData() {
            let res = await ApiServices.budgetShow(this.$route.params.id);
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
        async edit() {
            this.changeProgress = true;
            const data = new FormData();
            data.append('title', this.editedItem.title);
            data.append('department_id', this.editedItem.department_id);
            data.append('fiscal_year_id', this.editedItem.fiscal_year_id);
            data.append('type', this.editedItem.type);
            data.append('allocated_budget_amount', this.editedItem.allocated_budget_amount);
            data.append('initial_dispatched_amount', this.editedItem.initial_dispatched_amount);
            data.append('date_first_received', this.editedItem.date_first_received);
            data.append('remarks', this.editedItem.remarks);
            if ('file' in this.editedItem) {
                if (typeof this.editedItem.file.name == 'string') {
                    data.append('file', this.editedItem.file);
                }
            }
            let res = await ApiServices.budgetEdit(this.editedItem.id, data);
            this.changeProgress = false;
            if (res.success === true) {
                route.replace('/budgets');
            }
        },
    }
}
</script>
<style scoped>
.file-link {
    cursor: pointer;
    text-decoration: underline;
}
</style>
