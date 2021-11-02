<template>
    <div class="c-app flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol md="8">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardBody>
                                <CForm>
                                    <h1>Login</h1>
                                    <p class="text-muted">Sign In to your account</p>
                                    <v-form>
                                        <v-text-field
                                            v-model="username"
                                            :label="$t('username')"
                                            name="username"
                                            :rules="rules.username"
                                            prepend-inner-icon="mdi-account"
                                            type="username"
                                            :error-messages="error.username"
                                            @keyup="clearError('username')"
                                            solo
                                        ></v-text-field>
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
                                            @keyup.enter="loginUser"
                                            solo
                                        ></v-text-field>
                                    </v-form>
                                    <CRow class="mt-3">
                                        <CCol col="4" class="text-left">
                                            <CButton color="primary" class="px-4" @click="loginUser">
                                                {{ $t('button.login') }}
                                            </CButton>
                                        </CCol>
                                        <CCol col="2" class="text-center">
                                            <v-progress-circular
                                                v-if="loginProgress"
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
                            class="text-center py-5 d-md-down-none"
                            body-wrapper
                        >
                            <CCardBody>
                                <h2>Sign up</h2>
                                <p>To access your account, please identify yourself by providing the information
                                    requested in the fields below, then click "Login". If you are not registered yet,
                                    click "New user" and follow the instructions to create an account.</p>
                                <CButton
                                    color="light"
                                    variant="outline"
                                    size="lg"
                                    :to="'register'"
                                >
                                    Register Now!
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
    data: () => ({
        username: '',
        password: '',
        show1: false,
        loginProgress: false,
        error: {
            username: '',
            password: '',
        },
        rules: {
            password: [
                v => !!v || i18n.t('validation.required'),
                v => (v && v.length >= 8) || i18n.t('validation.morethan'),
                v => /(?=.*[A-Z])/.test(v) || i18n.t('validation.uppercase'),
                v => /(?=.*\d)/.test(v) || i18n.t('validation.numeric'),
                v => /([!@$%:])/.test(v) || i18n.t('validation.special')
            ],
            username: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
        },
    }),
    methods: {
        clearError(name) {
            if (name === 'username') {
                this.error.username = '';

            }
            if (name === 'password') {
                this.error.password = '';
            }
        },
        async loginUser() {
            this.loginProgress = true;
            store.state.auth.username = this.username;
            store.state.auth.password = this.password;
            let res = await store.dispatch('auth/loginUser');
            this.loginProgress = false;
            if (res === true) {
                route.replace('home');
            }
            if (res.success === false) {
                if (res.data.password !== undefined) {
                    this.error.password = res.data.password[0]
                }
                if (res.data.username !== undefined) {
                    this.error.username = res.data.username[0]
                }
            }
        },
    }
}
</script>
<style>
</style>
