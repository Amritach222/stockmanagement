<template>
    <v-card>
        <v-card-title>
            <span class="headline">Add Vendor</span>
        </v-card-title>
        <v-form ref="form">
            <v-container>
                <v-row>
                    <v-col>
                        <v-text-field
                            v-model="editedItem.vat_no"
                            label="Vat/Pan No"
                            outlined
                            :append-icon="wright ? 'mdi-checkbox-marked-circle-outline' : 'mdi-close-circle-outline'"
                            :append-outer-icon="'mdi-cloud-download'"
                            type="number"
                            :rules="rules.vat_no"
                            :error-messages="error.vat_no"
                            @click:append-outer="searchPan(editedItem.vat_no)"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="1" v-if="load">
                        <CSpinner color="warning" variant="grow"/>
                    </v-col>
                    <v-col>
                        <v-text-field
                            v-model="editedItem.name"
                            label="Name"
                            required
                            outlined
                            :rules="rules.name"
                            class="shrink"
                        ></v-text-field>
                    </v-col>
                    <v-col>
                        <v-text-field
                            v-model="editedItem.company_name"
                            label="Company Name"
                            required
                            outlined
                            :rules="rules.company_name"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-text-field
                            v-model="editedItem.email"
                            label="Email"
                            required
                            outlined
                            :rules="rules.email"
                        ></v-text-field>
                    </v-col>
                    <v-col>
                        <v-text-field
                            v-model="editedItem.landline"
                            label="Landline No."
                            required
                            outlined
                            type="number"
                            :rules="rules.landline"
                        ></v-text-field>
                    </v-col>
                    <v-col>
                        <v-text-field
                            v-model="editedItem.mobile"
                            label="Mobile No."
                            required
                            outlined
                            type="number"
                            :rules="rules.mobile"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-select
                            v-model="editedItem.country"
                            :items="country"
                            item-text="name"
                            item-value="name"
                            label="Country"
                            dense
                            outlined
                            required
                            :rules="rules.country"
                            return-object
                            v-on:change=getStates(editedItem.country)
                        ></v-select>
                    </v-col>
                    <v-col>
                        <v-select
                            v-model="editedItem.state"
                            :items="state"
                            item-text="name"
                            item-value="name"
                            label="State"
                            dense
                            outlined
                            required
                            :rules="rules.state"
                            return-object
                            v-on:change=getCities(editedItem.state)
                        ></v-select>
                    </v-col>
                    <v-col>
                        <v-select
                            v-model="editedItem.city"
                            :items="city"
                            item-text="name"
                            item-value="name"
                            label="City"
                            dense
                            outlined
                            required
                            :rules="rules.city"
                            return-object
                        ></v-select>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-text-field
                            v-model="editedItem.postal_code"
                            label="Postal Code"
                            required
                            outlined
                            type="number"
                        ></v-text-field>
                    </v-col>
                    <v-col>
                        <v-select
                            v-model="editedItem.category_id"
                            :items="categories"
                            item-text="name"
                            item-value="id"
                            label="Categories"
                            dense
                            outlined
                            required
                            :rules="rules.category_id"
                        ></v-select>
                    </v-col>
                    <v-col>
                        <v-select
                            v-model="editedItem.is_active"
                            :items="activePassive"
                            item-text="text"
                            item-value="value"
                            label="Active or Inactive"
                            dense
                            outlined
                            required
                            :rules="rules.is_active"
                        ></v-select>
                    </v-col>
                </v-row>

            </v-container>
            <v-card-actions>
                <v-spacer></v-spacer>
                <CButton type="submit" size="sm" color="primary" @click="save">
                    <CIcon name="cil-check-circle"/>
                    {{ $t('button.submit') }}
                </CButton>
                <CButton class="ml-2" size="sm" color="danger" :to="'/vendors'">
                    <CIcon name="cil-ban"/>
                    {{ $t('button.cancel') }}
                </CButton>
            </v-card-actions>
        </v-form>
    </v-card>
</template>

<script>
import store from "../../store";
import route from "../../router";
import i18n from "../../i18n";
import countryList from "../../services/lib/country.json";
import stateList from "../../services/lib/state.json";
import cityList from "../../services/lib/city.json";
import ApiServices from "../../services/ApiServices";

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
        postal_code: '',
        is_active: '',
        category_id: '',
        createProgress: false,
        wright: false,
        load: false,
        country: [],
        state: [],
        city: [],
        categories: [],
        activePassive: [
            {text: 'Active', value: 1},
            {text: 'Inactive', value: 0},
        ],
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
        editedItem: {
            id: null,
            name: '',
            company_name: '',
            vat_no: '',
            email: '',
            landline: '',
            mobile: '',
            country: '',
            state: '',
            city: '',
            postal_code: '',
            category_id: '',
            is_active: '',
        },
        rules: {
            name: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ], company_name: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ], vat_no: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ], email: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
                val => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(val) || i18n.t('validation.email'),
            ], landline: [
                val => /(\d{0,3})(\d{0,3})(\d{0,4})/.test(val) || i18n.t('validation.phone'),
            ], mobile: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
                val => /(\d{0,3})(\d{0,3})(\d{0,4})/.test(val) || i18n.t('validation.phone'),
            ],
        },
    }),

    async created() {
        this.loadCategories();
        this.country = countryList;
    },

    methods: {
        async searchPan(pan) {
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
            let res = await ApiServices.vendorCreate(data);
            if (res.success === true) {
                this.$refs.form.reset();
                route.replace('/vendors');
            }
        },
    }
}
</script>
