<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Add</strong> Signature
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
                                        <v-file-input
                                            v-model="image"
                                            type="file"
                                            name="image"
                                            description="Please upload signature."
                                            prepend-inner-icon="mdi-draw"
                                            autocomplete=""
                                            label="Signature"
                                            placeholder="Upload signature..."
                                            required
                                            @keyup="clearError('image')"
                                            @keyup.enter="create"
                                            :rules="rules.image"
                                            solo
                                        />
                                        <v-select
                                            v-model="user_id"
                                            name="user_id"
                                            description="Please select user."
                                            prepend-inner-icon="mdi-account"
                                            autocomplete=""
                                            label="User"
                                            placeholder="Select user..."
                                            @keyup="clearError('user_id')"
                                            @keyup.enter="create"
                                            :rules="rules.user_id"
                                            solo
                                        />
                                        <v-select
                                            v-model="designation_id"
                                            name="designation_id"
                                            description="Please select designation."
                                            prepend-inner-icon="mdi-alpha-d-circle"
                                            autocomplete=""
                                            label="Designation"
                                            placeholder="Select designation..."
                                            @keyup="clearError('designation_id')"
                                            @keyup.enter="create"
                                            :rules="rules.designation_id"
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
    name: "SignatureCreate",

    props: {
        source: String,
    },
    data: () => ({
        image: '',
        user_id: '',
        designation_id: '',
        createProgress: false,
        error: {
            image: '',
            user_id: '',
            designation_id: '',
        },
        rules: {
            image: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            user_id: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            designation_id: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
        },
    }),
    methods: {
        clearError(name) {
            if (name === 'image') {
                this.error.image = '';
            }
            if (name === 'user_id') {
                this.error.user_id = '';
            }
            if (name === 'designation_id') {
                this.error.designation_id = '';
            }
        },
        async create() {
            this.createProgress = true;
            store.state.settings.image = this.image;
            store.state.settings.user_id = this.user_id;
            store.state.settings.designation_id = this.designation_id;
            let res = await store.dispatch('settings/signatureCreate');
            this.createProgress = false;
            if (res === true) {
                route.replace('/index');
            }
        },
    }
}
</script>
