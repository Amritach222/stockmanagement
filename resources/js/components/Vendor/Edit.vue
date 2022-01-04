<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Edit</strong> Vendor
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
                                        <v-row>
                                            <v-col md="9">
                                                <v-row>
                                                    <v-col md="4">
                                                        <v-text-field
                                                            v-model="editedItem.name"
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
                                                            v-model="editedItem.username"
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
                                                            v-model="editedItem.company_name"
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
                                                            v-model="editedItem.email"
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
                                                            v-model="editedItem.landline"
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
                                                            v-model="editedItem.mobile"
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
                                                            v-model="editedItem.vat_no"
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
                                                            v-model="editedItem.category_id"
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
                                                            v-model="editedItem.postal_code"
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
                                                            <img :src=cdnURL+editedItem.link
                                                                 v-if="editedItem.link"
                                                                 style="width:100%;   height: 175px; object-fit: cover;"
                                                                 v-on:click="openImage(editedItem.link)"/>
                                                            <img :src="baseURL+'images/account-placeholder.png'"
                                                                 v-else
                                                                 style="width:100%;   height: 175px; object-fit: cover"
                                                            />
                                                            <!--                                                            <v-card-title class="title">-->
                                                            <!--                                                                {{ $t('image') }}-->
                                                            <!--                                                            </v-card-title>-->
                                                        </v-card>
                                                        <v-file-input
                                                            v-model="editedItem.image"
                                                            :label="$t('image')"
                                                            filled
                                                            class="mt-4"
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
                                                    v-model="editedItem.address"
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
                                                    v-model="editedItem.country"
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
                                                    v-on:change=getStates(editedItem.country)
                                                    return-object
                                                    solo
                                                ></v-select>
                                            </v-col>
                                            <v-col md="3">
                                                <v-select
                                                    v-model="editedItem.state"
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
                                                    v-on:change=getCities(editedItem.state)
                                                    return-object
                                                    :rules="rules.state"
                                                    solo
                                                ></v-select>
                                            </v-col>
                                            <v-col md="3">
                                                <v-select
                                                    v-model="editedItem.city"
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
                                                <v-select
                                                    v-model="editedItem.is_active"
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
                                        <CButton type="submit" size="sm" color="primary" @click="edit">
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
            cdnURL: config.cdnURL,
            baseURL: config.baseURL,
            users: [],
            categories: [],
            editedItem: {
                id: null,
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
            },
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
            },
        };
    },
    async created() {
        this.loadUsers();
        this.loadItems();
        this.loadCategories();
        this.countries = countryList;
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
        async loadItems() {
            let res = await ApiServices.vendorShow(this.$route.params.id);
            if (res.success === true) {
                this.editedItem = res.data;
                this.editedItem.country = JSON.parse(res.data.country);
                this.editedItem.state = JSON.parse(res.data.state);
                this.editedItem.city = JSON.parse(res.data.city);
                if(res.data.country !== null){
                    let rtn = this.getStates(this.editedItem.country);
                }
                if(res.data.state !== null){
                    let cty = this.getCities(this.editedItem.state)
                }
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
            if (name === 'company_name') {
                this.error.company_name = '';
            }
            if (name === 'email') {
                this.error.email = '';
            }
            if (name === 'landline') {
                this.error.landline = '';
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

        async edit() {
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

            if (this.editedItem.mobile !== null && this.editedItem.mobile !== '') {
                data.append('mobile', this.editedItem.mobile);
            }

            if (this.editedItem.password !== null && this.editedItem.password !== '') {
                data.append('password', this.editedItem.password);
            }

            if (this.editedItem.confirm_password !== null && this.editedItem.confirm_password !== '') {
                data.append('confirm_password', this.editedItem.confirm_password);
            }

            if (this.editedItem.address !== null && this.editedItem.address !== '') {
                data.append('address', this.editedItem.address);
            }

            if (this.editedItem.company_name !== null && this.editedItem.company_name !== '') {
                data.append('company_name', this.editedItem.company_name);
            }

            if (this.editedItem.vat_no !== null && this.editedItem.vat_no !== '') {
                data.append('vat_no', this.editedItem.vat_no);
            }

            if (this.editedItem.landline !== null && this.editedItem.landline !== '') {
                data.append('landline', parseInt(this.editedItem.landline));
            }

            if (this.editedItem.country !== null && this.editedItem.country !== '') {
                data.append('country', JSON.stringify(this.editedItem.country));
            }

            if (this.editedItem.state !== null && this.editedItem.state !== '') {
                data.append('state', JSON.stringify(this.editedItem.state));
            }

            if (this.editedItem.city !== null && this.editedItem.city !== '') {
                data.append('city', JSON.stringify(this.editedItem.city));
            }

            if (this.editedItem.postal_code !== null && this.editedItem.postal_code !== '') {
                data.append('postal_code', this.editedItem.postal_code);
            }

            if (this.editedItem.category_id !== null && this.editedItem.category_id !== '') {
                data.append('category_id', this.editedItem.category_id);
            }

            if (this.editedItem.is_active !== null && this.editedItem.is_active !== '') {
                data.append('is_active', this.editedItem.is_active);
            }

            if ('image' in this.editedItem) {
                if (typeof this.editedItem.image.name == 'string') {
                    data.append('image', this.editedItem.image);
                }
            }

            let res = await ApiServices.vendorEdit(this.editedItem.id, data);
            this.createProgress = false;
            if (res.success === true) {
                // route.replace('/vendors/');
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
