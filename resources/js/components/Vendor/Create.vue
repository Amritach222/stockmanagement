<template>
    <div class="c-app flex-row align-items-center">
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
                                    <v-form>
                                        <v-text-field
                                            v-model="name"
                                            type="text"
                                            name="name"
                                            description="Please enter vendor name."
                                            autocomplete=""
                                            label="Name"
                                            prepend-inner-icon="mdi-account"
                                            placeholder="Enter vendor name..."
                                            required
                                            @keyup="clearError('name')"
                                            @keyup.enter="create"
                                            :rules="rules.name"
                                            solo
                                        >
                                        </v-text-field>
                                        <v-text-field
                                            v-model="company_name"
                                            type="text"
                                            name="company_name"
                                            description="Please enter company name."
                                            prepend-inner-icon="mdi-alpha-c-circle"
                                            autocomplete=""
                                            label="Company Name"
                                            placeholder="Enter company name..."
                                            required
                                            @keyup="clearError('company_name')"
                                            @keyup.enter="create"
                                            :rules="rules.company_name"
                                            solo
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="vat_no"
                                            type="number"
                                            name="vat_no"
                                            description="Please enter VAT number."
                                            prepend-inner-icon="mdi-alpha-v-circle"
                                            autocomplete=""
                                            label="VAT No."
                                            placeholder="Enter VAT number..."
                                            required
                                            @keyup="clearError('vat_no')"
                                            @keyup.enter="create"
                                            :rules="rules.vat_no"
                                            solo
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="email"
                                            type="email"
                                            name="email"
                                            description="Please enter email."
                                            prepend-inner-icon="@"
                                            autocomplete=""
                                            label="Email"
                                            placeholder="Enter email..."
                                            required
                                            @keyup="clearError('email')"
                                            @keyup.enter="create"
                                            :rules="rules.email"
                                            solo
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="address"
                                            type="text"
                                            name="address"
                                            description="Please enter address."
                                            prepend-inner-icon="mdi-bookmark-minus"
                                            autocomplete=""
                                            label="Address"
                                            placeholder="Enter address..."
                                            @keyup="clearError('address')"
                                            @keyup.enter="create"
                                            solo
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="landline"
                                            type="number"
                                            name="landline"
                                            description="Please enter landline number."
                                            prepend-inner-icon="mdi-phone-classic"
                                            autocomplete=""
                                            label="Landline No."
                                            placeholder="Enter landline number..."
                                            @keyup="clearError('landline')"
                                            @keyup.enter="create"
                                            :rules="rules.landline"
                                            solo
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="mobile"
                                            type="number"
                                            name="mobile"
                                            description="Please enter mobile number."
                                            prepend-inner-icon="mdi-cellphone"
                                            autocomplete=""
                                            label="Mobile No."
                                            placeholder="Enter mobile number..."
                                            required
                                            @keyup="clearError('mobile')"
                                            @keyup.enter="create"
                                            :rules="rules.mobile"
                                            solo
                                        ></v-text-field>
                                        <v-select
                                            v-model="country"
                                            name="country"
                                            description="Please select a country."
                                            prepend-inner-icon="mdi-web"
                                            autocomplete=""
                                            label="Country"
                                            placeholder="Select country..."
                                            required
                                            @keyup="clearError('country')"
                                            @keyup.enter="create"
                                            :rules="rules.country"
                                            solo
                                        ></v-select>
                                        <v-select
                                            v-model="state"
                                            name="state"
                                            description="Please select a state."
                                            prepend-inner-icon="mdi-billboard"
                                            autocomplete=""
                                            label="State"
                                            placeholder="Select state..."
                                            required
                                            @keyup="clearError('state')"
                                            @keyup.enter="create"
                                            :rules="rules.state"
                                            solo
                                        ></v-select>
                                        <v-select
                                            v-model="city"
                                            name="city"
                                            description="Please select a city."
                                            prepend-inner-icon="mdi-city"
                                            autocomplete=""
                                            label="City"
                                            placeholder="Select city..."
                                            required
                                            @keyup="clearError('city')"
                                            @keyup.enter="create"
                                            :rules="rules.city"
                                            solo
                                        ></v-select>
                                        <v-text-field
                                            v-model="postal_code"
                                            type="text"
                                            name="postal_code"
                                            prepend-inner-icon="mdi-code-not-equal"
                                            description="Please enter postal code."
                                            autocomplete=""
                                            label="Postal Code"
                                            placeholder="Select postal code..."
                                            @keyup="clearError('postal_code')"
                                            @keyup.enter="create"
                                            solo
                                        ></v-text-field>
                                        <v-file-input
                                            v-model="image"
                                            type="file"
                                            name="image"
                                            description="Please upload a image."
                                            prepend-inner-icon="mdi-image"
                                            autocomplete=""
                                            label="Image"
                                            @keyup="clearError('image')"
                                            @keyup.enter="create"
                                            solo
                                        ></v-file-input>
                                        <v-select
                                            v-model="category_id"
                                            name="category_id"
                                            description="Please select category."
                                            prepend-inner-icon="mdi-shape"
                                            autocomplete=""
                                            label="Category"
                                            placeholder="Select category..."
                                            @keyup="clearError('category_id')"
                                            @keyup.enter="create"
                                            solo
                                        ></v-select>
                                        <v-checkbox
                                            v-model="is_active"
                                            name="is_active"
                                            description="Please check the box if vendor is active."
                                            autocomplete=""
                                            label="Active"
                                            value="1"
                                            @keyup="clearError('is_active')"
                                            @keyup.enter="create"
                                            solo
                                        ></v-checkbox>
                                    </v-form>
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
    name: "VendorCreate",

    props: {
        source: String,
    },
    data: () => ({
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
            country: [
                val => val > 0 || i18n.t('validation.required'),
            ],
            city: [
                val => val > 0 || i18n.t('validation.required'),
            ],
            state: [
                val => val > 0 || i18n.t('validation.required'),
            ],
            landline: [
                val => (val || '').length < 10 || 'Number of length exceeded.',
                val => Number.isInteger(Number(val)) || "The value must be number",
            ],
        },
    }),
    methods: {
        clearError(name) {
            if (name === 'name') {
                this.error.name = '';
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
        async create() {
            this.createProgress = true;
            store.state.settings.name = this.name;
            store.state.settings.company_name = this.company_name;
            store.state.settings.vat_no = this.vat_no;
            store.state.settings.email = this.email;
            store.state.settings.landline = this.landline;
            store.state.settings.mobile = this.mobile;
            store.state.settings.address = this.address;
            store.state.settings.image = this.image;
            store.state.settings.country = this.country;
            store.state.settings.city = this.city;
            store.state.settings.state = this.state;
            store.state.settings.postal_code = this.postal_code;
            store.state.settings.is_active = this.is_active;
            store.state.settings.category_id = this.category_id;
            let res = await store.dispatch('vendors/vendorCreate');
            this.createProgress = false;
            if (res === true) {
                route.replace('/index');
            }
        },
    }
}
</script>
