<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Edit</strong> Quotation
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
                                            prepend-icon="mdi-alpha-b-circle"
                                            label="Department"
                                            placeholder="Select department ..."
                                            required
                                            :rules="rules"
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
                                        <v-textarea
                                            v-model="editedItem.note"
                                            label="Note"
                                            placeholder="Enter quotation notes..."
                                            solo
                                        />
                                    </v-form>
                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="edit">
                                            <CIcon name="cil-check-circle"/>
                                            Submit
                                        </CButton>
                                        <CButton :to="'/quotations'" size="sm" color="danger">
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
        name: "QuotationEdit",

        props: {
            source: String,
        },
        data: () => ({
            cdnURL: config.cdnURL,
            changeProgress: false,
            validated: false,
            departments: [],
            editedItem: {
                id: null,
                department_id: '',
                file: [],
                note: '',
            },
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
            this.loadData();
            this.loadDepartments();
        },
        methods: {
            openImage(data) {
                window.open(config.cdnURL + data, `_blank`);
            },
            async loadDepartments() {
                let res = await ApiServices.departmentList();
                if (res.success === true) {
                    this.departments = res.data;
                }
            },
            async loadData() {
                let res = await ApiServices.quotationShow(this.$route.params.id);
                if (res.success === true) {
                    this.editedItem = res.data;
                }
            },
            async edit() {
                this.validate();
                if (this.validated) {
                    this.changeProgress = true;
                    const data = new FormData();
                    data.append('department_id', this.editedItem.department_id);
                    data.append('note', this.editedItem.note);

                    if ('file' in this.editedItem) {
                        if (typeof this.editedItem.file.name == 'string') {
                            data.append('file', this.editedItem.file);
                        }
                    }

                    let res = await ApiServices.quotationEdit(this.editedItem.id, data);
                    this.changeProgress = false;
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

<style scoped>
.file-link{
    cursor: pointer;
    text-decoration: underline;
}
</style>
