<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Add</strong> Designation
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
                                            v-model="name"
                                            type="text"
                                            name="name"
                                            description="Please enter designation name."
                                            prepend-inner-icon="mdi-alpha-d-circle"
                                            autocomplete=""
                                            label="Name"
                                            placeholder="Enter designation name..."
                                            required
                                            @keyup="clearError('name')"
                                            @keyup.enter="create"
                                            :rules="rules.name"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="level"
                                            type="number"
                                            name="level"
                                            description="Please enter designation level."
                                            prepend-inner-icon="mdi-format-line-weight"
                                            autocomplete=""
                                            label="Level"
                                            placeholder="Enter designation level..."
                                            @keyup="clearError('level')"
                                            @keyup.enter="create"
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
import store from "../../../store";
import route from "../../../router";
import i18n from "../../../i18n";

export default {
    name: "DesignationCreate",

    props: {
        source: String,
    },
    data: () => ({
        name: '',
        level: '',
        createProgress: false,
        error: {
            name: '',
            level: '',
        },
        rules: {
            name: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
        },
    }),
    methods: {
        clearError(name) {
            if (name === 'name') {
                this.error.name = '';
            }
            if (name === 'level') {
                this.error.level = '';
            }
        },
        async create() {
            this.createProgress = true;
            store.state.settings.name = this.name;
            store.state.settings.level = this.level;
            let res = await store.dispatch('settings/designationCreate');
            this.createProgress = false;
            if (res === true) {
                route.replace('/index');
            }
        },
    }
}
</script>
