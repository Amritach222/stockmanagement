<template>
    <CRow>
        <CCol sm="12">
            <CCard>
                <CCardHeader>
                    <strong>Edit</strong> Category
                    <v-progress-circular
                        v-if="changeProgress"
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
                            @keyup.enter="edit"
                            @change="getData()"
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
            </CCard>
        </CCol>
    </CRow>
</template>

<script>
import store from "../../../store";
import route from "../../../router";
import i18n from "../../../i18n";
import ApiServices from "../../../services/ApiServices";

export default {
    name: "CategoryEdit",

    props: {
        source: String,
    },
    data: () => ({
        name: '',
        changeProgress: false,
        error: {
            name: '',
        },
        rules: {
            name: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
        },
        return: {
            form: {
                name: "",
            }
        }
    }),
    methods: {
        clearError(name) {
            if (name === 'name') {
                this.error.name = '';
            }
        },
        getData(){
            var id = this.$route.params.id;
            const res = ApiServices.categoryShow(id);
            const response = () => {
                res.then((a) => {
                    console.log(a)
                    this.form.name = res.data[0].name;
                });
            };
            return response();

        },
        async edit() {
            this.changeProgress = true;
            store.state.products.name = this.name;
            store.state.products.id = this.$route.params.id;
            let res = await store.dispatch('products/categoryEdit');
            this.changeProgress = false;
            if (res === true) {
                route.replace('/index');
            }
        },
    }
}
</script>
