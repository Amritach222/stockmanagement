<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Edit</strong> Tax
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
                                        <v-text-field
                                            v-model="name"
                                            type="text"
                                            name="name"
                                            description="Please enter unit name."
                                            prepend-inner-icon="mdi-tape-measure"
                                            autocomplete=""
                                            label="Name"
                                            placeholder="Enter unit name..."
                                            required
                                            @keyup="clearError('name')"
                                            @keyup.enter="edit"
                                            :rules="rules.name"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="short_code"
                                            type="text"
                                            name="short_code"
                                            description="Please enter unit short code."
                                            prepend-inner-icon="mdi-alpha-s-circle"
                                            autocomplete=""
                                            label="Short Code"
                                            placeholder="Enter unit short code..."
                                            required
                                            @keyup="clearError('short_code')"
                                            @keyup.enter="edit"
                                            :rules="rules.short_code"
                                            solo
                                        />
                                    </v-form>
                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="edit">
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
import store from "../../../store";
import route from "../../../router";
import i18n from "../../../i18n";

export default {
    name: "UnitEdit",

    props: {
        source: String,
    },
    data: () => ({
        name: '',
        short_code: '',
        changeProgress: false,
        error: {
            name: '',
            short_code: '',
        },
        rules: {
            name: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            short_code: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
        },
    }),
    methods: {
        clearError(name) {
            if (name === 'name') {
                this.error.name = '';

            }
        },
        async edit() {
            this.changeProgress = true;
            store.state.settings.name = this.name;
            store.state.settings.short_code = this.short_code;
            store.state.settings.id = this.$route.params.id;
            let res = await store.dispatch('settings/unitEdit');
            this.changeProgress = false;
            if (res === true) {
                route.replace('/index');
            }
        },
    }
}
</script>
