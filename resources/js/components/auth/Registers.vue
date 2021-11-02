<template>
    <div class="c-app flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol md="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardBody>
                                <CForm>
                                    <h1>Register</h1>
                                    <p class="text-muted">Create Your Account</p>
                                    <v-form>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-12">
                                                <v-text-field
                                                    v-model="first_name"
                                                    :label="$t('first_name')"
                                                    name="first_name"
                                                    prepend-inner-icon="mdi-account"
                                                    type="text"
                                                    :error-messages="error.first_name"
                                                    solo
                                                    :rules="rules.first_name"
                                                ></v-text-field>
                                            </div>

                                            <div class="col-lg-4 col-md-12">
                                                <v-text-field
                                                    v-model="middle_name"
                                                    :label="$t('middle_name')"
                                                    name="middle_name"
                                                    prepend-inner-icon="mdi-account"
                                                    :error-messages="error.middle_name"
                                                    type="text"
                                                    solo
                                                ></v-text-field>
                                            </div>

                                            <div class="col-lg-4 col-md-12">
                                                <v-text-field
                                                    v-model="last_name"
                                                    :label="$t('last_name')"
                                                    name="last_name"
                                                    prepend-inner-icon="mdi-account"
                                                    type="text"
                                                    :error-messages="error.last_name"
                                                    solo
                                                    :rules="rules.last_name"
                                                ></v-text-field>
                                            </div>

                                            <div class="col-lg-6 col-md-12">
                                                <v-text-field
                                                    v-model="username"
                                                    :label="$t('username')"
                                                    name="username"
                                                    prepend-inner-icon="mdi-account"
                                                    type="text"
                                                    :error-messages="error.username"
                                                    solo
                                                    :rules="rules.username"
                                                ></v-text-field>
                                            </div>

                                            <div class="col-lg-6 col-md-12">
                                                <v-text-field
                                                    v-model="email"
                                                    :label="$t('email')"
                                                    name="email"
                                                    prepend-inner-icon="mdi-mail"
                                                    type="email"
                                                    :rules="rules.email"
                                                    solo
                                                    :error-messages="error.email"
                                                ></v-text-field>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <v-text-field
                                                    v-model="password"
                                                    :label="$t('password')"
                                                    name="password"
                                                    :rules="rules.password"
                                                    prepend-inner-icon="mdi-lock"
                                                    :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                                    :type="show1 ? 'text' : 'password'"
                                                    @click:append="show1 = !show1"
                                                    :error-messages="error.password"
                                                    @keyup="clearError('password')"
                                                    @keyup.enter="registerUser"
                                                    solo
                                                ></v-text-field>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <v-text-field
                                                    v-model="confirm_password"
                                                    :label="$t('confirmPassword')"
                                                    name="password"
                                                    :rules="rules.confirm_password"
                                                    prepend-inner-icon="mdi-lock"
                                                    :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                                                    :type="show2 ? 'text' : 'password'"
                                                    @click:append="show2 = !show2"
                                                    :error-messages="error.confirm_password"
                                                    @keyup="clearError('confirm_password')"
                                                    @keyup.enter="registerUser"
                                                    solo
                                                ></v-text-field>
                                            </div>

                                            <div class="col-lg-6 col-md-12">
                                                <v-text-field
                                                    v-model="mobile_no"
                                                    :label="$t('mobile')"
                                                    name="mobile_no"
                                                    prepend-inner-icon="mdi-phone"
                                                    type="number"
                                                    solo
                                                    :error-messages="error.mobile_no"
                                                    :rules="rules.mobile_no"
                                                ></v-text-field>
                                            </div>

                                            <div class="col-lg-6 col-md-12">
                                                <v-text-field
                                                    v-model="address"
                                                    :label="$t('address')"
                                                    name="address"
                                                    prepend-inner-icon="mdi-card"
                                                    type="text"
                                                    solo
                                                    :error-messages="error.address"
                                                    :rules="rules.address"
                                                ></v-text-field>
                                            </div>
                                        </div>
                                    </v-form>

                                    <CRow class="mt-3">
                                        <CCol col="4" class="text-left">
                                            <CButton color="primary" class="px-4" @click="registerUser">
                                                {{ $t('button.createAccount') }}
                                            </CButton>
                                        </CCol>
                                        <CCol col="2" class="text-center">
                                            <v-progress-circular
                                                v-if="registerProgress"
                                                indeterminate
                                                color="white"
                                                size="20"
                                            ></v-progress-circular>
                                        </CCol>
                                        <CCol col="6" class="text-right">
                                            <router-link :to="'forgot-password'">{{
                                                    $t('forgotPassword')
                                                }}
                                            </router-link>
                                            <v-spacer></v-spacer>
                                            <router-link :to="'reset-password'">{{ $t('resetPassword') }}</router-link>
                                            <v-spacer></v-spacer>
                                            <router-link :to="'register'" class="d-lg-none">{{
                                                    $t('createAccount')
                                                }}
                                            </router-link>
                                        </CCol>
                                    </CRow>
                                </CForm>
                            </CCardBody>
                        </CCard>
                        <CCard
                            color="primary"
                            text-color="white"
                            class="text-center py-2 d-md-down-none"
                            body-wrapper
                        >
                            <CCardBody>
                                <h2>Sign In</h2>
                                <p>To access your account, please identify yourself by providing the information
                                    requested in the fields below, then click "Login". If you are not registered yet,
                                    click "New user" and follow the instructions to create an account.</p>
                                <CButton
                                    color="light"
                                    variant="outline"
                                    size="lg"
                                    :to="'login'"
                                >
                                    Login
                                </CButton>
                            </CCardBody>
                        </CCard>
                    </CCardGroup>
                </CCol>
            </CRow>
        </CContainer>
    </div>
</template>

<script>
import store from "../../store";
import route from "../../router";
import i18n from "../../i18n";

export default {
    props: {
        source: String,
    },
    data: function () {
        return {
            show1: false,
            show2: false,
            username: '',
            first_name: '',
            last_name: '',
            middle_name: '',
            email: '',
            address: '',
            mobile_no: '',
            registerProgress: false,
            password: '',
            confirm_password: '',
            error: {
                first_name: '',
                middle_name: '',
                last_name: '',
                username: '',
                password: '',
                confirm_password: '',
                email: '',
                mobile_no: '',
                address: '',
            },
            rules: {
                username: [
                    val => (val || '').length > 0 || i18n.t('validation.required'),
                ],
                first_name: [
                    val => (val || '').length > 0 || i18n.t('validation.required'),
                ],
                last_name: [
                    val => (val || '').length > 0 || i18n.t('validation.required'),
                ],
                email: [
                    val => (val || '').length > 0 || i18n.t('validation.required'),
                    val => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(val) || i18n.t('validation.email'),
                ],
                mobile_no: [
                    val => (val || '').length > 0 || i18n.t('validation.required'),
                ],
                address: [
                    val => (val || '').length > 0 || i18n.t('validation.required'),
                ],
                password: [
                    v => !!v || i18n.t('validation.required'),
                    v => (v && v.length >= 8) || i18n.t('validation.morethan'),
                    v => /(?=.*[A-Z])/.test(v) || i18n.t('validation.uppercase'),
                    v => /(?=.*\d)/.test(v) || i18n.t('validation.numeric'),
                    v => /([!@$%:])/.test(v) || i18n.t('validation.special')
                ],
                confirm_password: [
                    v => !!v || i18n.t('validation.required'),
                    v => (v && v.length >= 8) || i18n.t('validation.morethan'),
                    v => (v === this.password) || i18n.t('validation.samePassword'),
                    v => /(?=.*[A-Z])/.test(v) || i18n.t('validation.uppercase'),
                    v => /(?=.*\d)/.test(v) || i18n.t('validation.numeric'),
                    v => /([!@$%:])/.test(v) || i18n.t('validation.special')
                ],
            },
        }
    },
    methods: {
        clearError(name) {
            if (name === 'username') {
                this.error.username = '';
            }
            if (name === 'first_name') {
                this.error.name = '';
            }
            if (name === 'last_name') {
                this.error.name = '';
            }
            if (name === 'email') {
                this.error.email = '';
            }
            if (name === 'mobile_no') {
                this.error.mobile_no = '';
            }
            if (name === 'address') {
                this.error.address = '';
            }
            if (name === 'password') {
                this.error.password = '';
            }
            if (name === 'confirm_password') {
                this.error.confirm_password = '';
            }
        },
        async registerUser() {
            this.registerProgress = true;
            store.state.auth.first_name = this.first_name;
            store.state.auth.last_name = this.last_name;
            store.state.auth.middle_name = this.middle_name;
            store.state.auth.username = this.username;
            store.state.auth.email = this.email;
            store.state.auth.password = this.password;
            store.state.auth.confirm_password = this.confirm_password;
            store.state.auth.mobile_no = this.mobile_no;
            store.state.auth.address = this.address;
            let res = await store.dispatch('auth/registerUser');
            this.registerProgress = false;
            console.log('after register', res);
            if (res === true) {
                route.replace('home');
            }
            if (res.data.first_name !== undefined) {
                this.error.first_name = res.data.first_name[0]
            }
            if (res.data.last_name !== undefined) {
                this.error.last_name = res.data.last_name[0]
            }
            if (res.data.middle_name !== undefined) {
                this.error.middle_name = res.data.middle_name[0]
            }
            if (res.data.username !== undefined) {
                this.error.username = res.data.username[0]
            }
            if (res.data.email !== undefined) {
                this.error.email = res.data.email[0]
            }
            if (res.data.password !== undefined) {
                this.error.password = res.data.password[0]
            }
            if (res.data.confirm_password !== undefined) {
                this.error.confirm_password = res.data.confirm_password[0]
            }
            if (res.data.mobile_no !== undefined) {
                this.error.mobile_no = res.data.mobile_no[0]
            }
            if (res.data.address !== undefined) {
                this.error.address = res.data.address[0]
            }
        },
    }
}
</script>

<style>

</style>
