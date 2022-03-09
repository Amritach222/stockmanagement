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
                    <v-col>
                        <v-text-field
                            v-model="editedItem.vat_no"
                            label="Vat/Pan No"
                            outlined
                            type="number"
                            :rules="rules.vat_no"
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
                <v-btn
                    color="blue darken-1"
                    text
                    @click="save"
                >
                    Save
                </v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
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
