<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Add</strong> Signature Use Department
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
                                            name="department_id"
                                            description="Please select department."
                                            prepend-inner-icon="mdi-alpha-d-circle"
                                            autocomplete=""
                                            label="Department"
                                            placeholder="Select department..."
                                            @keyup="clearError('department_id')"
                                            @keyup.enter="create"
                                            :rules="rules.department_id"
                                            solo
                                        />
                                        <v-select
                                            v-model="signature_id"
                                            name="signature_id"
                                            description="Please select signature."
                                            prepend-inner-icon="mdi-draw"
                                            autocomplete=""
                                            label="Signature"
                                            placeholder="Select signature..."
                                            @keyup="clearError('signature_id')"
                                            @keyup.enter="create"
                                            :rules="rules.signature_id"
                                            solo
                                        />
                                    </v-form>
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
                            </CCardBody>
                        </CCard>
                    </CCardGroup>
                </CCol>
            </CRow>
        </CContainer>
    </div>
</template>

<script>
import store from "../../../../store";
import route from "../../../../router";
import i18n from "../../../../i18n";

export default {
    name: "SignatureUseDepartmentCreate",

    props: {
        source: String,
    },
    data: () => ({
        signature_id: '',
        department_id: '',
        createProgress: false,
        error: {
            signature_id: '',
            department_id: '',
        },
        rules: {
            signature_id: [
                val => val > 0 || i18n.t('validation.required'),
            ],
            department_id: [
                val => val > 0 || i18n.t('validation.required'),
            ],
        },
    }),
    methods: {
        clearError(name) {
            if (name === 'signature_id') {
                this.error.signature_id = '';
            }
            if (name === 'department_id') {
                this.error.department_id = '';
            }
        },
        async create() {
            this.createProgress = true;
            store.state.settings.signature_id = this.signature_id;
            store.state.settings.department_id = this.department_id;
            let res = await store.dispatch('settings/signatureUseDepartmentCreate');
            this.createProgress = false;
            if (res === true) {
                route.replace('/index');
            }
        },
    }
}
</script>
