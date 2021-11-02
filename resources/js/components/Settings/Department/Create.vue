<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Add</strong> Department
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
                                            description="Please enter department name."
                                            prepend-inner-icon="mdi-alpha-d-circle"
                                            autocomplete=""
                                            label="Name"
                                            placeholder="Enter department name..."
                                            required
                                            @keyup="clearError('name')"
                                            @keyup.enter="create"
                                            :rules="rules.name"
                                            solo
                                        />
                                        <v-select
                                            v-model="head_of_department"
                                            name="head_of_department"
                                            description="Please select department head."
                                            prepend-inner-icon="mdi-account-network"
                                            autocomplete=""
                                            label="Head Of Department"
                                            placeholder="Select department head..."
                                            @keyup="clearError('head_of_department')"
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
    name: "DepartmentCreate",

    props: {
        source: String,
    },
    data: () => ({
        name: '',
        head_of_department: '',
        createProgress: false,
        error: {
            name: '',
            head_of_department: '',
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
            if (name === 'head_of_department') {
                this.error.head_of_department = '';
            }
        },
        async create() {
            this.createProgress = true;
            store.state.settings.name = this.name;
            let res = await store.dispatch('settings/departmentCreate');
            this.createProgress = false;
            if (res === true) {
                route.replace('/index');
            }
        },
    }
}
</script>
