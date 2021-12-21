<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>{{ $t('card_title.add_user') }}</strong>
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
                                        <CRow>
                                            <CCol>
                                                <CRow>
                                                    <CCol md="6">
                                                        <v-text-field
                                                            v-model="name"
                                                            description="Please enter name."
                                                            prepend-icon="mdi-account"
                                                            :label="$t('name')"
                                                            placeholder="Enter name..."
                                                            required
                                                            @keyup="clearError('name')"
                                                            :rules="rules.name"
                                                            solo
                                                        />
                                                    </CCol>
                                                    <CCol md="6">
                                                        <v-text-field
                                                            v-model="username"
                                                            description="Please enter username."
                                                            prepend-icon="mdi-account-circle"
                                                            :label="$t('username')"
                                                            placeholder="Enter username..."
                                                            required
                                                            @keyup="clearError('username')"
                                                            :rules="rules.username"
                                                            v-on:keyup="checkValidation('username')"
                                                            solo
                                                        />
                                                        <p v-if="usernameValidation" class="notify-validation">
                                                            {{ $t('validation.username') }}</p>
                                                    </CCol>
                                                    <CCol md="6">
                                                        <v-text-field
                                                            v-model="email"
                                                            description="Please enter email."
                                                            prepend-icon="mdi-at"
                                                            :label="$t('email')"
                                                            placeholder="Enter email..."
                                                            required
                                                            @keyup="clearError('email')"
                                                            :rules="rules.email"
                                                            v-on:keyup="checkValidation('email')"
                                                            solo
                                                        />
                                                        <p v-if="emailValidation" class="notify-validation">
                                                            {{ $t('validation.uniqueEmail') }}</p>
                                                    </CCol>

                                                    <CCol md="6">
                                                        <v-text-field
                                                            v-model="mobile_no"
                                                            description="Please enter mobile number."
                                                            prepend-icon="mdi-cellphone"
                                                            :label="$t('mobile')"
                                                            placeholder="Enter mobile number..."
                                                            required
                                                            @keyup="clearError('moble_no')"
                                                            :rules="rules.mobile_no"
                                                            solo
                                                        />
                                                    </CCol>
                                                    <CCol md="6">
                                                        <v-text-field
                                                            v-model="password"
                                                            type="password"
                                                            description="Please enter password."
                                                            :label="$t('password')"
                                                            placeholder="**********"
                                                            prepend-icon="mdi-lock"
                                                            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                                            :type="show1 ? 'text' : 'password'"
                                                            @click:append="show1 = !show1"
                                                            :error-messages="error.password"
                                                            required
                                                            @keyup="clearError('password')"
                                                            :rules="rules.password"
                                                            solo
                                                        />
                                                    </CCol>
                                                    <CCol md="6">
                                                        <v-text-field
                                                            v-model="confirm_password"
                                                            description="Please enter confirm password."
                                                            prepend-icon="mdi-lock"
                                                            :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                                                            :type="show2 ? 'text' : 'password'"
                                                            @click:append="show2 = !show2"
                                                            :error-messages="error.confirm_password"
                                                            :label="$t('confirmPassword')"
                                                            placeholder="**********"
                                                            required
                                                            @keyup="clearError('confirm_password')"
                                                            :rules="rules.confirm_password"
                                                            solo
                                                        />
                                                    </CCol>
                                                </CRow>
                                            </CCol>
                                            <CCol md="4">
                                                <v-row>
                                                    <v-col>
                                                        <v-card width="200" style="margin-left:8%"
                                                        >
                                                            <img :src="baseURL+'images/account-placeholder.png'"
                                                                 style=" width:100%;   height: 120px; object-fit: cover"
                                                            />
                                                            <v-card-title class="title">
                                                                {{ $t('image') }}
                                                            </v-card-title>
                                                        </v-card>
                                                        <v-file-input
                                                            v-model="image"
                                                            :label="$t('image')"
                                                            filled
                                                            class="mt-3"
                                                            outlined
                                                            prepend-icon="mdi-camera"
                                                            accept="image/png,image/jpeg,image/jpg"
                                                        ></v-file-input>
                                                    </v-col>
                                                </v-row>
                                            </CCol>
                                        </CRow>
                                        <CRow>
                                            <CCol md="4">
                                                <v-select
                                                    v-model="department_id"
                                                    :items="departments"
                                                    item-value="id"
                                                    item-text="name"
                                                    description="Please select department."
                                                    prepend-icon="mdi-alpha-d-circle"
                                                    :label="$t('department')"
                                                    placeholder="Select a department"
                                                    required
                                                    @keyup="clearError('department_id')"
                                                    :rules="rules.department_id"
                                                    solo
                                                />
                                            </CCol>
                                            <CCol md="4">
                                                <v-select
                                                    v-model="designation_id"
                                                    :items="designations"
                                                    item-value="id"
                                                    item-text="name"
                                                    description="Please select designation."
                                                    prepend-icon="mdi-filter-variant"
                                                    :label="$t('designation')"
                                                    placeholder="Select a designation"
                                                    required
                                                    @keyup="clearError('designation_id')"
                                                    :rules="rules.designation_id"
                                                    solo
                                                />
                                            </CCol>
                                            <CCol md="4">
                                                <v-select
                                                    v-model="role_name"
                                                    :items="roles"
                                                    item-value="name"
                                                    item-text="name"
                                                    description="Please select role."
                                                    prepend-icon="mdi-account-check"
                                                    :label="$t('role')"
                                                    placeholder="Select a role"
                                                    required
                                                    @keyup="clearError('role_name')"
                                                    :rules="rules.role_name"
                                                    solo
                                                />
                                            </CCol>
                                        </CRow>
                                        <CRow>
                                            <CCol md="6">
                                                <v-text-field
                                                    v-model="address"
                                                    description="Please enter address."
                                                    prepend-icon="mdi-map-marker"
                                                    :label="$t('address')"
                                                    placeholder="Enter address..."
                                                    @keyup="clearError('address')"
                                                    solo
                                                />
                                            </CCol>
                                            <CCol md="6">
                                                <v-select
                                                    v-model="is_active"
                                                    :items="['Active','Inactive']"
                                                    description="Please select status."
                                                    prepend-icon="mdi-account-question"
                                                    :label="$t('status')"
                                                    placeholder="Select status..."
                                                    @keyup="clearError('status')"
                                                    solo
                                                />
                                            </CCol>
                                        </CRow>
                                    </v-form>

                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="create">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.submit') }}
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/users'">
                                            <CIcon name="cil-ban"/>
                                            {{ $t('button.cancel') }}
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
import config from "../../../config";

export default {
    name: "UserCreate",

    props: {
        source: String,
    },
    data () {
        return {
            cdnURL: config.cdnURL,
            baseURL: config.baseURL,
            designations: [],
            departments: [],
            roles: [],
            show1: false,
            show2: false,
            createProgress: false,
            emailValidation: false,
            usernameValidation: false,
            name: '',
            department_id: '',
            designation_id: '',
            username: '',
            is_active: '',
            email: '',
            mobile_no: '',
            address: '',
            password: '',
            confirm_password: '',
            role_name: '',
            image: [],
            search: '',
            progressL: false,
            productCount: 0,
            validated: false,
            error: {
                name: '',
                department_id: '',
                designation_id: '',
                username: '',
                is_active: '',
                email: '',
                mobile_no: '',
                address: '',
                password: '',
                confirm_password: '',
            },
            rules: {
                name: [
                    val => (val || '').length > 0 || i18n.t('validation.required'),
                ],
                username: [
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
                    v => v === this.password || i18n.t('validation.samePassword'),
                    v => /(?=.*[A-Z])/.test(v) || i18n.t('validation.uppercase'),
                    v => /(?=.*\d)/.test(v) || i18n.t('validation.numeric'),
                    v => /([!@$%:])/.test(v) || i18n.t('validation.special')
                ],
            },
        };
    },

    mounted() {
        this.password = '';
    },

    async created() {
        this.loadDepartments();
        this.loadDesignations();
        this.loadRoles();
        this.loadUsers();
    },
    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadUsers() {
            let rtn = await ApiServices.userIndex();
            if (rtn.success === true) {
                this.users = rtn.data;
            }
        },
        async loadDepartments() {
            let res = await ApiServices.departmentIndex();
            if (res.success === true) {
                this.departments = res.data;
                this.password = '';
            }
        },
        async loadDesignations() {
            let res = await ApiServices.designationIndex();
            if (res.success === true) {
                this.designations = res.data;
            }
        },
        async loadRoles() {
            let res = await ApiServices.roleIndex();
            if (res.success === true) {
                this.roles = res.data;
            }
        },

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

        async checkValidation(type) {
            let email = 0;
            let username = 0;
            if (type === 'username') {
                for (var i = 0; i < this.users.length; i++) {
                    if (this.username === this.users[i].username) {
                        username = 1;
                    }
                }
            } else {
                for (var j = 0; j < this.users.length; j++) {
                    if (this.email === this.users[j].email) {
                        email = 1;
                    }
                }
            }
            if ((username === 0) && (email === 0)) {
                this.emailValidation = false;
                this.usernameValidation = false;
            } else if (username === 1) {
                this.usernameValidation = true;
            } else if (email === 1) {
                this.emailValidation = true;
            }
        },

        async create() {
            this.createProgress = true;
            const data = new FormData();
            if (this.name !== null && this.name !== '') {
                data.append('name', this.name);
            }

            if (this.username !== null && this.username !== '') {
                data.append('username', this.username);
            }

            if (this.email !== null && this.email !== '') {
                data.append('email', this.email);
            }

            if (this.mobile_no !== null && this.mobile_no !== '') {
                data.append('mobile_no', this.mobile_no);
            }

            if (this.password !== null && this.password !== '') {
                data.append('password', this.password);
            }

            if (this.confirm_password !== null && this.confirm_password !== '') {
                data.append('confirm_password', this.confirm_password);
            }

            if (this.address !== null && this.address !== '') {
                data.append('address', this.address);
            }

            if (this.department_id !== null && this.department_id !== '') {
                data.append('department_id', this.department_id);
            }

            if (this.designation_id !== null && this.designation_id !== '') {
                data.append('designation_id', this.designation_id);
            }

            if (this.role_name !== null && this.role_name !== '') {
                data.append('role_name', this.role_name);
            }

            if (this.is_active !== null && this.is_active !== '') {
                if (this.is_active === 'Active') {
                    data.append('is_active', 1);
                } else {
                    data.append('is_active', 0);
                }
            }

            if (typeof this.image.name == 'string') {
                data.append('image', this.image);
            }

            let res = await ApiServices.userCreate(data);
            this.createProgress = false;
            if (res.success === true) {
                route.replace('/users/');
            }
        },
    }
}
</script>
<style scoped>
.notify-validation {
    color: #f65050;
}
</style>
