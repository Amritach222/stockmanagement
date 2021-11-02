<template>
    <CRow>
        <CCol sm="12">
            <CCard>
                <CCardHeader>
                    <strong>Add</strong> Category
                    <v-progress-circular
                        v-if="createProgress"
                        indeterminate
                        color="white"
                        size="30"
                    ></v-progress-circular>
                </CCardHeader>
                <CForm>
                    <CCardBody>
                        <CInput
                            v-model="name"
                            type="text"
                            name="name"
                            description="Please enter category name."
                            autocomplete=""
                            label="Name"
                            placeholder="Enter category name..."
                            required
                            @keyup="clearError('name')"
                            @keyup.enter="create"
                            :rules="rules.name"
                        />
                        <!--                                            <CInput-->
                        <!--                                                type="password"-->
                        <!--                                                description="Please enter your password."-->
                        <!--                                                autocomplete="current-password"-->
                        <!--                                                label="Password"-->
                        <!--                                                placeholder="Enter Password..."-->
                        <!--                                                required-->
                        <!--                                                was-validated-->
                        <!--                                            />-->
                    </CCardBody>
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
            </CCard>
        </CCol>
    </CRow>
</template>

<script>
import store from "../../../store";
import route from "../../../router";
import i18n from "../../../i18n";


export default {
    name: "CategoryCreate",

    props: {
        source: String,
    },
    data: () => ({
        name: '',
        createProgress: false,
        error: {
            name: '',
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
        },
        async create() {
            this.createProgress = true;
            store.state.products.name = this.name;
            let res = await store.dispatch('products/categoryCreate');
            this.createProgress = false;
            if (res === true) {
                route.replace('/index');
            }
        },
    }
}
</script>
