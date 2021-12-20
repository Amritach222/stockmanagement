<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>{{ $t('card_title.edit_user') }}</strong>
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
                                                            v-model="editedItem.name"
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
                                                            v-model="editedItem.username"
                                                            description="Please enter username."
                                                            prepend-icon="mdi-account-circle"
                                                            :label="$t('username')"
                                                            placeholder="Enter username..."
                                                            required
                                                            v-on:keyup="checkValidation('username')"
                                                            :rules="rules.username"
                                                            solo
                                                        />
                                                        <p v-if="usernameValidation" class="notify-validation">{{ $t('validation.username') }}</p>
                                                    </CCol>
                                                    <CCol md="6">
                                                        <v-text-field
                                                            v-model="editedItem.email"
                                                            description="Please enter email."
                                                            prepend-icon="mdi-at"
                                                            :label="$t('email')"
                                                            placeholder="Enter email..."
                                                            required
                                                            :rules="rules.email"
                                                            v-on:keyup="checkValidation('email')"
                                                            solo
                                                        />
                                                        <p v-if="emailValidation" class="notify-validation">{{ $t('validation.uniqueEmail') }}</p>
                                                    </CCol>

                                                    <CCol md="6">
                                                        <v-text-field
                                                            v-model="editedItem.mobile_no"
                                                            type="number"
                                                            description="Please enter mobile number."
                                                            prepend-icon="mdi-cellphone"
                                                            :label="$t('mobile')"
                                                            placeholder="Enter mobile number..."
                                                            required
                                                            @keyup="clearError('mobile_no')"
                                                            :rules="rules.mobile_no"
                                                            solo
                                                        />
                                                    </CCol>
                                                    <CCol md="6">
                                                        <v-select
                                                            v-model="editedItem.department_id"
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
                                                    <CCol md="6">
                                                        <v-select
                                                            v-model="editedItem.designation_id"
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
                                                </CRow>
                                            </CCol>
                                            <CCol md="4">
                                                <v-row>
                                                    <v-col>
                                                        <v-card width="200" style="margin-left:8%"
                                                        >
                                                            <img :src=cdnURL+editedItem.link
                                                                 v-if="editedItem.link"
                                                                 style="width:100%;   height: 120px; object-fit: cover;"
                                                                 v-on:click="openImage(editedItem.link)"/>
                                                            <img :src="baseURL+'images/account-placeholder.png'"
                                                                 v-else
                                                                 style="width:100%;   height: 120px; object-fit: cover"
                                                            />
                                                            <v-card-title class="title">
                                                                {{ $t('image') }}
                                                            </v-card-title>
                                                        </v-card>
                                                        <v-file-input
                                                            v-model="editedItem.image"
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
                                                <v-text-field
                                                    v-model="editedItem.address"
                                                    description="Please enter address."
                                                    prepend-icon="mdi-map-marker"
                                                    :label="$t('address')"
                                                    placeholder="Enter address..."
                                                    @keyup="clearError('address')"
                                                    solo
                                                />
                                            </CCol>
                                            <CCol md="4">
                                                <v-select
                                                    v-model="editedItem.is_active"
                                                    :items="status"
                                                    item-text="name"
                                                    item-value="value"
                                                    description="Please select status."
                                                    prepend-icon="mdi-account-question"
                                                    :label="$t('status')"
                                                    placeholder="Select status..."
                                                    @keyup="clearError('status')"
                                                    solo
                                                />
                                            </CCol>
                                            <CCol md="4">
                                                <v-select
                                                    v-model="editedItem.role_name"
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
    data: () => ({
        cdnURL: config.cdnURL,
        baseURL: config.baseURL,
        designations: [],
        departments: [],
        roles: [],
        users: [],
        status: [
            {name: 'Active', value: '1'},
            {name: 'Inactive', value: '0'},
        ],
        show1: false,
        show2: false,
        createProgress: false,
        emailValidation: false,
        usernameValidation: false,
        editedItem: {
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
        },
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
                v => (v === this.editedItem.password) || i18n.t('validation.samePassword'),
                v => /(?=.*[A-Z])/.test(v) || i18n.t('validation.uppercase'),
                v => /(?=.*\d)/.test(v) || i18n.t('validation.numeric'),
                v => /([!@$%:])/.test(v) || i18n.t('validation.special')
            ],
        },
    }),

    async created() {
        this.loadItems();
        this.loadDepartments();
        this.loadDesignations();
        this.loadRoles();
    },
    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadItems() {
            let res = await ApiServices.userShow(this.$route.params.id);
            if (res.success === true) {
                this.editedItem = res.data;
            }
            let rtn = await ApiServices.userIndex();
            if (rtn.success === true) {
                this.users = rtn.data;
            }

        },
        async loadDepartments() {
            let res = await ApiServices.departmentIndex();
            if (res.success === true) {
                this.departments = res.data;
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
                    if ((this.editedItem.username === this.users[i].username) && (this.editedItem.id !== this.users[i].id)) {
                        username = 1;
                    }
                }
            } else {
                for (var j = 0; j < this.users.length; j++) {
                    if ((this.editedItem.email === this.users[j].email) && (this.editedItem.id !== this.users[j].id)) {
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
            if (this.editedItem.name !== null && this.editedItem.name !== '') {
                data.append('name', this.editedItem.name);
            }

            if (this.editedItem.username !== null && this.editedItem.username !== '') {
                data.append('username', this.editedItem.username);
            }

            if (this.editedItem.email !== null && this.editedItem.email !== '') {
                data.append('email', this.editedItem.email);
            }

            if (this.editedItem.mobile_no !== null && this.editedItem.mobile_no !== '') {
                data.append('mobile_no', this.editedItem.mobile_no);
            }

            if (this.editedItem.address !== null && this.editedItem.address !== '') {
                data.append('address', this.editedItem.address);
            }

            if (this.editedItem.department_id !== null && this.editedItem.department_id !== '') {
                data.append('department_id', this.editedItem.department_id);
            }

            if (this.editedItem.designation_id !== null && this.editedItem.designation_id !== '') {
                data.append('designation_id', this.editedItem.designation_id);
            }

            if (this.editedItem.is_active !== null && this.editedItem.is_active !== '') {
                data.append('is_active', this.editedItem.is_active);
            }

            if ('image' in this.editedItem) {
                if (typeof this.editedItem.image.name == 'string') {
                    data.append('image', this.editedItem.image);
                }
            }

            let res = await ApiServices.userEdit(this.editedItem.id, data);
            this.createProgress = false;
            if (res.success === true) {
                route.replace('/users/');
            }
        },
    }
}
</script>
