/**
* Created by Samundra.
* Date: 15/09/2021
*/
<template>
    <div class="c-app flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol md="8">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardBody>
                                <CForm>
                                    <h1>{{ $t('reset') }}</h1>
                                    <p class="text-muted">Enter the Username Or Email</p>
                                    <v-form ref="form">
                                        <v-text-field
                                            v-model="username"
                                            :label="$t('username-or-email')"
                                            name="username"
                                            :rules="rules.username"
                                            prepend-inner-icon="mdi-account"
                                            type="username"
                                            :error-messages="error.username"
                                            @keyup="clearError('username')"
                                            solo
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="previousPassword"
                                            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                            :label="$t('password')"
                                            name="password"
                                            :rules="rules.previousPassword"
                                            prepend-inner-icon="mdi-lock"
                                            :type="show1 ? 'text' : 'password'"
                                            :error-messages="error.previousPassword"
                                            @click:append="show1 = !show1"
                                            @keyup="clearError('previousPassword')"
                                            solo
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="newPassword"
                                            :label="$t('newPassword')"
                                            name="password"
                                            :rules="rules.newPassword"
                                            prepend-inner-icon="mdi-lock"
                                            :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                                            :type="show2 ? 'text' : 'password'"
                                            @click:append="show2 = !show2"
                                            :error-messages="error.newPassword"
                                            @keyup="clearError('newPassword')"
                                            solo
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="confirmNewPassword"
                                            :label="$t('confirmNewPassword')"
                                            name="password"
                                            :rules="rules.confirmNewPassword"
                                            prepend-inner-icon="mdi-lock"
                                            :append-icon="show3 ? 'mdi-eye' : 'mdi-eye-off'"
                                            :type="show3 ? 'text' : 'password'"
                                            @click:append="show3 = !show3"
                                            :error-messages="error.confirmNewPassword"
                                            @keyup="clearError('confirmNewPassword')"
                                            @keyup.enter="resetPassword"
                                            solo
                                        ></v-text-field>
                                    </v-form>
                                    <CRow class="mt-3">
                                        <CCol col="4" class="text-left">
                                            <CButton color="primary" class="px-4" @click="resetPassword">
                                                {{ $t('button.reset') }}
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
                                            <router-link :to="'login'">{{
                                                    $t('login')
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
    data: function () {
        return {
            show1: false,
            show2: false,
            show3: false,
            username: '',
            loginProgress: false,
            previousPassword: '',
            newPassword: '',
            error: {
                username: '',
                previousPassword: '',
                newPassword: '',
                confirmNewPassword: ''
            },
            confirmNewPassword: '',
            rules: {
                username: [
                    val => (val || '').length > 0 || i18n.t('validation.required'),
                ],
                newPassword: [
                    v => !!v || i18n.t('validation.required'),
                    v => (v && v.length >= 8) || i18n.t('validation.morethan'),
                    v => /(?=.*[A-Z])/.test(v) || i18n.t('validation.uppercase'),
                    v => /(?=.*\d)/.test(v) || i18n.t('validation.numeric'),
                    v => /([!@$%:])/.test(v) || i18n.t('validation.special')
                ],
                confirmNewPassword: [
                    v => !!v || i18n.t('validation.required'),
                    v => (v && v.length >= 8) || i18n.t('validation.morethan'),
                    v => (v === this.newPassword) || i18n.t('validation.sameNewPassword'),
                    v => /(?=.*[A-Z])/.test(v) || i18n.t('validation.uppercase'),
                    v => /(?=.*\d)/.test(v) || i18n.t('validation.numeric'),
                    v => /([!@$%:])/.test(v) || i18n.t('validation.special')
                ],
                previousPassword: [
                    v => !!v || i18n.t('validation.required'),
                    v => (v && v.length >= 8) || i18n.t('validation.morethan'),
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
            if (name === 'previousPassword') {
                this.error.previousPassword = '';

            }
            if (name === 'newPassword') {
                this.error.newPassword = '';

            }
            if (name === 'confirmNewPassword') {
                this.error.confirmNewPassword = '';

            }
        },
        async resetPassword() {
            this.loginProgress = true;
            const data = new FormData();
            data.append('usernameOrEmail', this.username);
            data.append('previousPassword', this.previousPassword);
            data.append('newPassword', this.newPassword);
            data.append('confirmNewPassword', this.confirmNewPassword);
            let res = await store.dispatch('auth/resetUserPassword', data);
            this.loginProgress = false;
            if (res === true) {
                route.replace('login');
            }
            if (res.data.confirmNewPassword !== undefined) {
                this.error.confirmNewPassword = res.data.confirmNewPassword[0]
            }
            if (res.data.newPassword !== undefined) {
                this.error.newPassword = res.data.newPassword[0]
            }
            if (res.data.previousPassword !== undefined) {
                this.error.previousPassword = res.data.previousPassword[0]
            }
            if (res.data.usernameOrEmail !== undefined) {
                this.error.username = res.data.usernameOrEmail[0]
            }
        },
    }
}
</script>
<style>
</style>
