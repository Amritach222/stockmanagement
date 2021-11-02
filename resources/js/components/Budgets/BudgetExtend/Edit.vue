<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Edit</strong> Budget Extend
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
                                            item-text="name"
                                            item-value="id"
                                            label="Department"
                                            placeholder="Select a department..."
                                            prepend-icon="mdi-alpha-d-circle"
                                            required
                                            :rules="rules.department_id"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.amount"
                                            type="number"
                                            label="Amount"
                                            placeholder="Enter the amount..."
                                            prepend-icon="mdi-cash-check"
                                            required
                                            :rules="rules.amount"
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
                                        <CButton size="sm" color="danger" :to="'/budgetExtends/'">
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
    name: "BudgetExtendEdit",

    props: {
        source: String,
    },
    data: () => ({
        editedItem: {
            id: null,
            department_id: '',
            amount: '',
            remarks: '',
            file: [],
        },
        cdnURL: config.cdnURL,
        departments: [],
        changeProgress: false,
        error: {
            department_id: '',
            amount: '',
            remarks: '',
            file: [],
        },
        rules: {
            department_id: [
                val => val > 0 || i18n.t('validation.required'),
            ],
            amount: [
                val => val >= 0 || i18n.t('validation.required'),
            ],
        },
    }),
    async created() {
        this.loadData();
        this.loadDepartments();
    },
    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadData() {
            let res = await ApiServices.budgetExtendShow(this.$route.params.id);
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

        clearError(name) {
            if (name === 'department_id') {
                this.error.department_id = '';
            }
            if (name === 'amount') {
                this.error.amount = '';
            }
            if (name === 'remarks') {
                this.error.remarks = '';
            }
        },
        async edit() {
            this.changeProgress = true;
            const data = new FormData();
            data.append('department_id', this.editedItem.department_id);
            data.append('amount', this.editedItem.amount);
            data.append('remarks', this.editedItem.remarks);
            if ('file' in this.editedItem) {
                if (typeof this.editedItem.file.name == 'string') {
                    data.append('file', this.editedItem.file);
                }
            }
            let res = await ApiServices.budgetExtendEdit(this.editedItem.id, data);
            this.changeProgress = false;
            if (res.success === true) {
                route.replace('/budgetExtends');
            }
        },
    }
}
</script>
<style scoped>
.file-link{
    cursor: pointer;
    text-decoration: underline;
}
</style>
