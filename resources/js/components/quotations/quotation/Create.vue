<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Add</strong> Quotations
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
                                            prepend-icon="mdi-alpha-d-circle"
                                            label="Department"
                                            placeholder="Select department ..."
                                            required
                                            :rules="rules"
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


                                        <v-textarea
                                            v-model="note"
                                            type="text"
                                            label="Note"
                                            placeholder="Enter quotation note..."
                                            solo
                                        />
                                    </v-form>
                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="create">
                                            <CIcon name="cil-check-circle"/>
                                            Submit
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/quotations/'">
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
        name: "QuotationCreate",

        props: {
            source: String,
        },
        data: () => ({
            cdnURL: config.cdnURL,
            createProgress: false,
            department_id: '',
            file: [],
            note: '',
            departments: [],
            error: {
                department_id: '',
                file: [],
                note: '',
            },
            rules: [
                value => !!value || 'Required.',
            ]
        }),
        async created() {
            this.loadDepartments();
        },
        methods: {
            async loadDepartments() {
                let res = await ApiServices.departmentIndex();
                if (res.success === true) {
                    this.departments = res.data;
                }
            },
            async create() {
                this.validate();
                if (this.validated) {
                    this.createProgress = true;
                    const data = new FormData();
                    data.append('note', this.note);
                    data.append('department_id', this.department_id);

                    if (typeof this.file.name == 'string') {
                        data.append('file', this.file);
                    }

                    let res = await ApiServices.quotationCreate(data);
                    this.createProgress = false;
                    if (res.success === true) {
                        route.replace('/quotations/');
                    }
                }
            },

            validate() {
                if (this.department_id === '') {
                    this.validated = false;
                } else {
                    this.validated = true;
                }
            },
        }
    }
</script>
