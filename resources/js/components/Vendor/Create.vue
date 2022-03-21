<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Add</strong> Vendor
                                <v-progress-circular
                                    v-if="createProgress"
                                    indeterminate
                                    color="white"
                                    size="30"
                                ></v-progress-circular>
                            </CCardHeader>
                            <CCardBody>
                                <CForm>
                                    <v-form ref="form">
                                        <v-row>
                                            <v-col md="9">
                                                <v-row>
                                                    <v-col md="4">
                                                        <v-text-field
                                                            v-model="name"
                                                            description="Please enter name."
                                                            autocomplete=""
                                                            label="Name"
                                                            prepend-inner-icon="mdi-account"
                                                            placeholder="Enter name..."
                                                            required
                                                            @keyup="clearError('name')"
                                                            :rules="rules.name"
                                                            solo
                                                        >
                                                        </v-text-field>
                                                    </v-col>
                                                    <v-col md="4">
                                                        <v-text-field
                                                            v-model="username"
                                                            description="Please enter username."
                                                            autocomplete=""
                                                            label="Username"
                                                            prepend-inner-icon="mdi-account"
                                                            placeholder="Enter username..."
                                                            required
                                                            @keyup="clearError('username')"
                                                            :rules="rules.username"
                                                            v-on:keyup="checkValidation('username')"
                                                            solo
                                                        >
                                                        </v-text-field>
                                                        <p v-if="usernameValidation" class="notify-validation">
                                                            {{ $t('validation.username') }}</p>
                                                    </v-col>
                                                    <v-col md="4">
                                                        <v-text-field
                                                            v-model="company_name"
                                                            description="Please enter company name."
                                                            prepend-inner-icon="mdi-alpha-c-circle"
                                                            autocomplete=""
                                                            label="Company Name"
                                                            placeholder="Enter company name..."
                                                            required
                                                            @keyup="clearError('company_name')"
                                                            :rules="rules.company_name"
                                                            solo
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col md="4">
                                                        <v-text-field
                                                            v-model="email"
                                                            type="email"
                                                            description="Please enter email."
                                                            prepend-inner-icon="@"
                                                            autocomplete=""
                                                            label="Email"
                                                            placeholder="Enter email..."
                                                            required
                                                            @keyup="clearError('email')"
                                                            :rules="rules.email"
                                                            v-on:keyup="checkValidation('email')"
                                                            solo
                                                        ></v-text-field>
                                                        <p v-if="emailValidation" class="notify-validation">
                                                            {{ $t('validation.uniqueEmail') }}</p>
                                                    </v-col>
                                                    <v-col md="4">
                                                        <v-text-field
                                                            v-model="landline"
                                                            type="number"
                                                            description="Please enter landline number."
                                                            prepend-inner-icon="mdi-phone-classic"
                                                            autocomplete=""
                                                            label="Landline No."
                                                            placeholder="Enter landline number..."
                                                            @keyup="clearError('landline')"
                                                            :rules="rules.landline"
                                                            solo
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col md="4">
                                                        <v-text-field
                                                            v-model="mobile"
                                                            type="number"
                                                            description="Please enter mobile number."
                                                            prepend-inner-icon="mdi-cellphone"
                                                            autocomplete=""
                                                            label="Mobile No."
                                                            placeholder="Enter mobile number..."
                                                            required
                                                            @keyup="clearError('mobile')"
                                                            :rules="rules.mobile"
                                                            solo
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col md="4">
                                                        <v-text-field
                                                            v-model="vat_no"
                                                            type="number"
                                                            description="Please enter VAT number."
                                                            prepend-inner-icon="mdi-alpha-v-circle"
                                                            autocomplete=""
                                                            label="VAT No."
                                                            placeholder="Enter VAT number..."
                                                            required
                                                            @keyup="clearError('vat_no')"
                                                            :rules="rules.vat_no"
                                                            solo
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col md="4">
                                                        <v-select
                                                            v-model="category_id"
                                                            :items="categories"
                                                            item-value="id"
                                                            item-text="name"
                                                            description="Please select category."
                                                            prepend-inner-icon="mdi-shape"
                                                            autocomplete=""
                                                            label="Category"
                                                            placeholder="Select category..."
                                                            @keyup="clearError('category_id')"
                                                            solo
                                                        ></v-select>
                                                    </v-col>
                                                    <v-col md="4">
                                                        <v-text-field
                                                            v-model="postal_code"
                                                            type="text"
                                                            prepend-inner-icon="mdi-code-not-equal"
                                                            description="Please enter postal code."
                                                            autocomplete=""
                                                            label="Postal Code"
                                                            placeholder="Select postal code..."
                                                            @keyup="clearError('postal_code')"
                                                            solo
                                                        ></v-text-field>
                                                    </v-col>
                                                </v-row>
                                            </v-col>
                                            <v-col md="3">
                                                <v-row>
                                                    <v-col>
                                                        <v-card width="200" style="margin-left:8%"
                                                        >
                                                            <img :src="baseURL+'images/account-placeholder.png'"
                                                                 style="width:100%;   height: 120px; object-fit: cover"
                                                            />
                                                            <v-card-title class="title">
                                                                {{ $t('logo') }}
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
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col md="3">
                                                <v-text-field
                                                    v-model="address"
                                                    type="text"
                                                    description="Please enter address."
                                                    prepend-inner-icon="mdi-bookmark-minus"
                                                    autocomplete=""
                                                    label="Address"
                                                    placeholder="Enter address..."
                                                    @keyup="clearError('address')"
                                                    solo
                                                ></v-text-field>
                                            </v-col>
                                            <v-col md="3">
                                                <v-select
                                                    v-model="country"
                                                    :items="countries"
                                                    item-text="name"
                                                    item-value="id"
                                                    description="Please select a country."
                                                    prepend-inner-icon="mdi-web"
                                                    autocomplete=""
                                                    label="Country"
                                                    placeholder="Select country..."
                                                    required
                                                    @keyup="clearError('country')"
                                                    :rules="rules.country"
                                                    v-on:change=getStates(country)
                                                    return-object
                                                    solo
                                                ></v-select>
                                            </v-col>
                                            <v-col md="3">
                                                <v-select
                                                    v-model="state"
                                                    :items="states"
                                                    item-text="name"
                                                    item-value="id"
                                                    description="Please select a state."
                                                    prepend-inner-icon="mdi-billboard"
                                                    autocomplete=""
                                                    label="State"
                                                    placeholder="Select state..."
                                                    required
                                                    @keyup="clearError('state')"
                                                    v-on:change=getCities(state)
                                                    return-object
                                                    :rules="rules.state"
                                                    solo
                                                ></v-select>
                                            </v-col>
                                            <v-col md="3">
                                                <v-select
                                                    v-model="city"
                                                    :items="cities"
                                                    item-text="name"
                                                    item-value="id"
                                                    description="Please select a city."
                                                    prepend-inner-icon="mdi-city"
                                                    autocomplete=""
                                                    label="City"
                                                    placeholder="Select city..."
                                                    required
                                                    @keyup="clearError('city')"
                                                    return-object
                                                    :rules="rules.city"
                                                    solo
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col md="4">
                                                <v-text-field
                                                    v-model="password"
                                                    type="password"
                                                    description="Please enter password."
                                                    :label="$t('password')"
                                                    placeholder="**********"
                                                    prepend-inner-icon="mdi-lock"
                                                    :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                                    :type="show1 ? 'text' : 'password'"
                                                    @click:append="show1 = !show1"
                                                    :error-messages="error.password"
                                                    required
                                                    @keyup="clearError('password')"
                                                    :rules="rules.password"
                                                    solo
                                                />
                                            </v-col>
                                            <v-col md="4">
                                                <v-text-field
                                                    v-model="confirm_password"
                                                    description="Please enter confirm password."
                                                    prepend-inner-icon="mdi-lock"
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
                                            </v-col>
                                            <v-col md="4">
                                                <v-select
                                                    v-model="is_active"
                                                    description="Please select a status."
                                                    prepend-inner-icon="mdi-account-question"
                                                    :items="status"
                                                    item-value="value"
                                                    item-text="name"
                                                    autocomplete=""
                                                    label="Status"
                                                    placeholder="Select status..."
                                                    required
                                                    @keyup="clearError('state')"
                                                    solo
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                    </v-form>
                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="create">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.submit') }}
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/vendors'">
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
import store from "../../store";
import route from "../../router";
import i18n from "../../i18n";
import config from "../../config";
import ApiServices from "../../services/ApiServices";
import countryList from "../../services/lib/country.json";
import stateList from "../../services/lib/state.json";
import cityList from "../../services/lib/city.json";

export default {
    name: "VendorCreate",

    props: {
        source: String,
    },
    data() {
        return {
            baseURL: config.baseURL,
            validated: false,
            users: [],
            categories: [],
            name: '',
            username: '',
            company_name: '',
            image: [],
            vat_no: '',
            email: '',
            address: '',
            landline: '',
            mobile: '',
            country: '',
            city: '',
            state: '',
            postal_code: '',
            is_active: '',
            category_id: '',
            password: '',
            confirm_password: '',
            show1: false,
            show2: false,
            countries: [],
            states: [],
            cities: [],
            emailValidation: false,
            usernameValidation: false,
            status: [
                {name: 'Active', value: 1},
                {name: 'Inactive', value: 0}
            ],
            createProgress: false,
            error: {
                name: '',
                company_name: '',
                image: '',
                vat_no: '',
                email: '',
                address: '',
                landline: '',
                mobile: '',
                country: '',
                city: '',
                state: '',
                postal_code: '',
                is_active: '',
                category_id: '',
            },
            rules: {
                name: [
                    val => (val || '').length > 0 || i18n.t('validation.required'),
                ],
                username: [
                    val => (val || '').length > 0 || i18n.t('validation.required'),
                ],
                company_name: [
                    val => (val || '').length > 0 || i18n.t('validation.required'),
                ],
                email: [
                    val => (val || '').length > 0 || i18n.t('validation.required'),
                    val => !val || /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(val) || i18n.t('validation.email')
                ],
                vat_no: [
                    val => (val || '').length > 0 || i18n.t('validation.required'),
                ],
                mobile: [
                    val => (val || '').length > 0 || i18n.t('validation.required'),
                    val => (val || '').length < 14 || 'Number of length exceeded.',
                    val => Number.isInteger(Number(val)) || "The value must be number",
                ],
                landline: [
                    val => (val || '').length < 10 || 'Number of length exceeded.',
                    val => Number.isInteger(Number(val)) || "The value must be number",
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
    async created() {
        this.loadUsers();
        this.loadCategories();
        this.countries = countryList;
    },
    methods: {
        async searchPan(pan) {
            if(pan === '' || pan === undefined){
                this.wright = false;
            } else {
                this.load = true;
                let res = await ApiServices.getPanDetails(pan);
                if (res.data.data === 0) {
                    this.wright = false;
                } else {
                    this.wright = true;
                    this.editedItem.company_name = res.data.data.panDetails[0].trade_Name_Eng.toUpperCase();
                    this.editedItem.landline = res.data.data.panDetails[0].telephone;
                    this.editedItem.mobile = res.data.data.panDetails[0].mobile;
                }
        async loadUsers() {
            let rtn = await ApiServices.userIndex();
            if (rtn.success === true) {
                this.users = rtn.data;
            }
        },
        async loadCategories() {
            let res = await ApiServices.categoryIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.categories = res.data;
            }
        },
        async getStates(country) {
            this.states = stateList.filter(function (value, index) {
                return value.country_id === country.id;
            })
        },
        async getCities(state) {
            this.cities = cityList.filter(function (value, index) {
                return value.state_id === state.id
            })
        },
        clearError(name) {
            if (name === 'name') {
                this.error.name = '';
            }
            if (name === 'username') {
                this.error.username = '';
            }
            if (name === 'vat_no') {
                this.error.vat_no = '';
            }
            this.load = false;
        },
        getCityName(item) {
            if (item.city !== null) return JSON.parse(item.city).name;
        },
        async getStates(country) {
            this.state = stateList.filter(function (value, index) {
                return value.country_id === country.id;
            })
        },
        async getCities(state) {
            this.city = cityList.filter(function (value, index) {
                return value.state_id === state.id
            })
        },
        async loadCategories() {
            let res = await ApiServices.categoryIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.categories = res.data;
            }
        },
        async save() {
            this.$refs.form.validate();
            this.progressL = true;
            const data = new FormData();
            data.append('name', this.editedItem.name);
            data.append('company_name', this.editedItem.company_name);
            data.append('vat_no', this.editedItem.vat_no);
            data.append('email', this.editedItem.email);
            data.append('landline', this.editedItem.landline);
            data.append('mobile', this.editedItem.mobile);
            data.append('country', JSON.stringify(this.editedItem.country));
            data.append('state', JSON.stringify(this.editedItem.state));
            data.append('city', JSON.stringify(this.editedItem.city));
            data.append('postal_code', this.editedItem.postal_code);
            data.append('category_id', this.editedItem.category_id);
            data.append('is_active', this.editedItem.is_active);
            if(this.wright){
                let res = await ApiServices.vendorCreate(data);
                if (res.success === true) {
                    this.$refs.form.reset();
                    route.replace('/vendors');
                }
            } else {
                store.state.home.snackbar = true;
                store.state.home.snackbarText = "Pan/Vat Number is not valid";
                store.state.home.snackbarColor = 'danger';
            }
            if (name === 'mobile') {
                this.error.mobile = '';
            }
            if (name === 'address') {
                this.error.address = '';
            }
            if (name === 'country') {
                this.error.country = '';
            }
            if (name === 'city') {
                this.error.city = '';
            }
            if (name === 'state') {
                this.error.state = '';
            }
            if (name === 'postal_code') {
                this.error.postal_code = '';
            }
            if (name === 'category_id') {
                this.error.category_id = '';
            }
            if (name === 'is_active') {
                this.error.is_active = '';
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
            this.validateData();
            if (this.validated) {
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

                if (this.mobile !== null && this.mobile !== '') {
                    data.append('mobile', this.mobile);
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

                if (this.company_name !== null && this.company_name !== '') {
                    data.append('company_name', this.company_name);
                }

                if (this.vat_no !== null && this.vat_no !== '') {
                    data.append('vat_no', this.vat_no);
                }

                if (this.landline !== null && this.landline !== '') {
                    data.append('landline', parseInt(this.landline));
                }

                if (this.country !== null && this.country !== '') {
                    data.append('country', JSON.stringify(this.country));
                }

                if (this.state !== null && this.state !== '') {
                    data.append('state', JSON.stringify(this.state));
                }

                if (this.city !== null && this.city !== '') {
                    data.append('city', JSON.stringify(this.city));
                }

                if (this.postal_code !== null && this.postal_code !== '') {
                    data.append('postal_code', this.postal_code);
                }

                if (this.category_id !== null && this.category_id !== '') {
                    data.append('category_id', this.category_id);
                }

                if (this.is_active !== null && this.is_active !== '') {
                    data.append('is_active', this.is_active);
                }
                if (this.image !== []) {
                    if (typeof this.image.name == 'string') {
                        data.append('image', this.image);
                    }
                }
                let res = await ApiServices.vendorCreate(data);
                this.createProgress = false;
                if (res.success === true) {
                    route.replace('/vendors/');
                }
            }
        },
        validateData() {
            this.$refs.form.validate();
            if (this.name === null) {
                this.validated = false
            }
            if (this.company_name === null) {
                this.validated = false
            }
            if (this.vat_no === null) {
                this.validated = false
            }
            if (this.email === null) {
                this.validated = false
            }
            if (this.landline === null) {
                this.validated = false
            }
            if (this.mobile === null) {
                this.validated = false
            }
            if (this.country === null) {
                this.validated = false
            }
            if (this.state === null) {
                this.validated = false
            }
            if (this.city === null) {
                this.validated = false
            }
            if (this.postal_code === null) {
                this.validated = false
            }
            if (this.category_id === null) {
                this.validated = false
            }
            if (this.is_active === null) {
                this.validated = false
            } else {
                this.validated = true
            }
        }
    }
}
</script>
<style scoped>
.notify-validation {
    color: #f65050;
}
</style>
