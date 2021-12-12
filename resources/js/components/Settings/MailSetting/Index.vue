<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Edit</strong> Mail Setting
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
                                            v-model="edited.mail_mailer"
                                            type="text"
                                            name="mail_mailer"
                                            description="Please enter mail mailer."
                                            prepend-inner-icon="mdi-email-multiple"
                                            autocomplete=""
                                            label="Mail Mailer"
                                            placeholder="Enter mail mailer..."
                                            required
                                            @keyup="clearError('mail_mailer')"
                                            @keyup.enter="edit"
                                            :rules="rules.mail_mailer"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="edited.mail_host"
                                            type="text"
                                            name="mail_host"
                                            description="Please enter mail host."
                                            prepend-inner-icon="mdi-email-multiple"
                                            autocomplete=""
                                            label="Mail Host"
                                            placeholder="Enter mail host..."
                                            required
                                            @keyup="clearError('mail_host')"
                                            @keyup.enter="edit"
                                            :rules="rules.mail_host"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="edited.mail_port"
                                            type="text"
                                            name="mail_port"
                                            description="Please enter mail port."
                                            prepend-inner-icon="mdi-swap-vertical"
                                            autocomplete=""
                                            label="Mail Port"
                                            placeholder="Enter mail port..."
                                            required
                                            @keyup="clearError('mail_port')"
                                            @keyup.enter="edit"
                                            :rules="rules.mail_port"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="edited.mail_address"
                                            type="text"
                                            name="mail_address"
                                            description="Please enter mail address."
                                            prepend-inner-icon="mdi-email-edit"
                                            autocomplete=""
                                            label="Mail Address"
                                            placeholder="Enter mail address..."
                                            required
                                            @keyup="clearError('mail_address')"
                                            @keyup.enter="edit"
                                            :rules="rules.mail_address"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="edited.username"
                                            type="text"
                                            name="username"
                                            description="Please enter username."
                                            prepend-inner-icon="mdi-account"
                                            autocomplete=""
                                            label="Username"
                                            placeholder="Enter username..."
                                            required
                                            @keyup="clearError('username')"
                                            @keyup.enter="edit"
                                            :rules="rules.username"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="edited.password"
                                            type="password"
                                            name="password"
                                            description="Please enter password."
                                            prepend-inner-icon="mdi-key"
                                            autocomplete=""
                                            label="Password"
                                            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                            :type="show1 ? 'text' : 'password'"
                                            @click:append="show1 = !show1"
                                            placeholder="Enter password..."
                                            required
                                            @keyup="clearError('password')"
                                            @keyup.enter="edit"
                                            :rules="rules.password"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="edited.mail_from_name"
                                            type="text"
                                            name="mail_from_name"
                                            description="Please enter mail from name."
                                            prepend-inner-icon="mdi-email-send"
                                            autocomplete=""
                                            label="From Name"
                                            placeholder="Enter mail from name..."
                                            required
                                            @keyup="clearError('mail_from_name')"
                                            @keyup.enter="edit"
                                            :rules="rules.mail_from_name"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="edited.encryption"
                                            type="text"
                                            name="encryption"
                                            description="Please enter encryption."
                                            prepend-inner-icon="mdi-lock-clock"
                                            autocomplete=""
                                            label="Encryption"
                                            placeholder="Enter encryption..."
                                            required
                                            @keyup="clearError('encryption')"
                                            @keyup.enter="edit"
                                            :rules="rules.encryption"
                                            solo
                                        />
                                    </v-form>
                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="edit">
                                            <CIcon name="cil-check-circle"/>
                                            Submit
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
import ApiServices from "../../../services/ApiServices";

export default {
    name: "MailSettingIndex",

    props: {
        source: String,
    },
    data: () => ({
        edited: {
            id: null,
            mail_mailer: '',
            mail_host: '',
            mail_port: '',
            mail_address: '',
            username: '',
            password: '',
            mail_from_name: '',
            encryption: '',
        },
        show1: false,
        changeProgress: false,
        error: {
            mail_mailer: '',
            mail_host: '',
            mail_port: '',
            mail_address: '',
            username: '',
            password: '',
            mail_from_name: '',
            encryption: '',
        },
        rules: {
            mail_mailer: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            mail_host: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            mail_port: [
                val => val > 0 || i18n.t('validation.required'),
            ],
            mail_address: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            username: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            password: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            mail_from_name: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            encryption: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
        },
    }),
    async created() {
        this.loadData();
    },
    methods: {
        async loadData() {
            let res = await ApiServices.mailSettingShow(1);
            if (res.success === true) {
                this.edited = res.data;
            }
        },
        clearError(name) {
            if (name === 'mail_mailer') {
                this.error.mail_mailer = '';
            }
            if (name === 'mail_host') {
                this.error.mail_host = '';
            }
            if (name === 'mail_port') {
                this.error.mail_port = '';
            }
            if (name === 'mail_address') {
                this.error.mail_address = '';
            }
            if (name === 'username') {
                this.error.username = '';
            }
            if (name === 'password') {
                this.error.password = '';
            }
            if (name === 'mail_from_name') {
                this.error.mail_from_name = '';
            }
            if (name === 'encryption') {
                this.error.encryption = '';
            }
        },
        async edit() {
            this.changeProgress = true;
            store.state.settings.mail_mailer = this.edited.mail_mailer;
            store.state.settings.mail_host = this.edited.mail_host;
            store.state.settings.mail_port = this.edited.mail_port;
            store.state.settings.mail_address = this.edited.mail_address;
            store.state.settings.mail_from_name = this.edited.mail_from_name;
            store.state.settings.username = this.edited.username;
            store.state.settings.password = this.edited.password;
            store.state.settings.encryption = this.edited.encryption;
            store.state.settings.id = this.edited.id;
            let res = await store.dispatch('settings/mailSettingEdit');
            this.changeProgress = false;
            // if (res === true) {
            //     route.replace('/');
            // }
        },
    }
}
</script>
