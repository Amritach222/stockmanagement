<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Edit</strong> Budget Request
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
                                            v-model="editedItem.type"
                                            :items="['Annual Request','Extend Request']"
                                            label="Type"
                                            placeholder="Select a request type..."
                                            prepend-icon="mdi-shape"
                                            required
                                            :rules="rules.type"
                                            solo
                                        />
                                        <v-select
                                            v-model="editedItem.fiscal_year_id"
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
                                            v-model="editedItem.request_amount"
                                            type="number"
                                            label="Amount"
                                            placeholder="Enter the amount..."
                                            prepend-icon="mdi-cash-check"
                                            required
                                            :rules="rules.request_amount"
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
import config from "../../../config";

export default {
    name: "BudgetRequestEdit",

    props: {
        source: String,
    },
    data: () => ({
        cdnURL: config.cdnURL,
        editedItem: {
            department_id: '',
            fiscal_year_id: '',
            type: '',
            request_amount: '',
            remarks: '',
            file: [],
        },
        departments: [],
        fiscalYears: [],
        changeProgress: false,
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
        this.loadItem();
    },
    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
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
        async loadItem() {
            let res = await ApiServices.budgetRequestShow(this.$route.params.id);
            if (res.success === true) {
                this.editedItem = res.data;
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
        async edit() {
            this.changeProgress = true;
            const data = new FormData();
            data.append('department_id', this.editedItem.department_id);
            data.append('fiscal_year_id', this.editedItem.fiscal_year_id);
            data.append('type', this.editedItem.type);
            data.append('request_amount', this.editedItem.request_amount);
            data.append('remarks', this.editedItem.remarks);
            if ('file' in this.editedItem) {
                if (typeof this.editedItem.file.name == 'string') {
                    data.append('file', this.editedItem.file);
                }
            }
            let res = await ApiServices.budgetRequestEdit(this.editedItem.id, data);
            this.changeProgress = false;
            if (res.success === true) {
                route.replace('/budgetRequests');
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
