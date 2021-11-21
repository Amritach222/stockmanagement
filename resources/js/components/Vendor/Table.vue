<template>
    <v-card>
        <v-card-title>
            Vendor
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="vendors"
            sort-by="id"
            loading
            loading-text="Loading... Please wait..."
            :search="search"
        >
            <template v-slot:top>
                <v-toolbar
                    flat
                >
                    <v-row>
                        <v-col
                            cols="12"
                            sm="4"
                            md="6"
                            lg="8"
                        >
                            <v-text-field
                                v-model="search"
                                append-icon="mdi-magnify"
                                label="Search"
                                solo
                                hide-details
                                max-width="100px"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-dialog
                        v-model="dialog"
                        max-width="600px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                color="green"
                                dark
                                class="mb-2"
                                v-bind="attrs"
                                v-on="on"
                            >
                                Add New Vendor
                            </v-btn>
                        </template>
                        <v-card>
                            <v-form ref="form">
                                <v-card-title>
                                    <span class="headline">{{ formTitle }}</span>
                                </v-card-title>

                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <v-col>
                                                <v-text-field
                                                    v-model="editedItem.name"
                                                    :label="$t('name')"
                                                    required
                                                    outlined
                                                    :rules="rules.name"
                                                    class="shrink"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col>
                                                <v-text-field
                                                    v-model="editedItem.company_name"
                                                    :label="$t('company_name')"
                                                    required
                                                    outlined
                                                    :rules="rules.company_name"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col>
                                                <v-text-field
                                                    v-model="editedItem.vat_no"
                                                    :label="$t('vat_pan')"
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
                                                    :label="$t('email')"
                                                    required
                                                    outlined
                                                    :rules="rules.email"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col>
                                                <v-text-field
                                                    v-model="editedItem.landline"
                                                    :label="$t('landline')"
                                                    required
                                                    outlined
                                                    type="number"
                                                    :rules="rules.landline"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col>
                                                <v-text-field
                                                    v-model="editedItem.mobile"
                                                    :label="$t('mobile')"
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
                                                    :label="$t('country')"
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
                                                    :label="$t('state')"
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
                                                    :label="$t('city')"
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
                                                    :label="$t('postal_code')"
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
                                                    :label="$t('categories')"
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
                                                    :label="$t('active_inactive')"
                                                    dense
                                                    outlined
                                                    required
                                                    :rules="rules.is_active"
                                                ></v-select>
                                            </v-col>
                                        </v-row>

                                    </v-container>
                                </v-card-text>

                                <v-card-actions>
                                    <v-progress-linear
                                        v-if="progressL"
                                        indeterminate
                                        color="green"
                                    ></v-progress-linear>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="close"
                                    >
                                        {{ $t('button.cancel') }}
                                    </v-btn>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="save"
                                    >
                                        {{ $t('button.submit') }}
                                    </v-btn>
                                </v-card-actions>
                            </v-form>
                        </v-card>
                    </v-dialog>
                    <v-dialog v-model="dialogDelete" max-width="500px">
                        <v-card>
                            <v-card-title class="text-h6">{{ $t('message.delete') }}</v-card-title>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="closeDelete">{{ $t('button.cancel') }}</v-btn>
                                <v-btn color="blue darken-1" text @click="deleteItemConfirm">{{ $t('button.confirm') }}</v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>
            <template v-slot:item.city="{ item }">
                {{getCityName(item)}}
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon
                    small
                    class="mr-2"
                    @click="editItem(item)"
                >
                    mdi-pencil
                </v-icon>
                <v-icon
                    small
                    @click="deleteItem(item)"
                >
                    mdi-delete
                </v-icon>
            </template>
            <template v-slot:no-data>
                <div>No Data</div>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import store from "../../store";
import ApiServices from "../../services/ApiServices";
import countryList from "../../services/lib/country.json";
import stateList from "../../services/lib/state.json";
import cityList from "../../services/lib/city.json";
import i18n from "../../i18n";


export default {
    name: "TableWrapper",
    data: () => ({
        search: '',
        validated: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        headers: [
            {text: 'Id', align: 'start', sortable: false, value: 'id'},
            {text: 'Name', value: 'name'},
            {text: 'Company Name', value: 'company_name'},
            {text: 'Vat/Pan No', value: 'vat_no'},
            {text: 'Email', value: 'email'},
            {text: 'Phone No', value: 'landline'},
            {text: 'City', value: 'city'},
            {text: 'Actions', value: 'actions', sortable: false},
        ],
        activePassive: [
            {text: 'Active', value: 1},
            {text: 'Inactive', value: 0},
            ],
        categories: [],
        vendors: [],
        editedIndex: -1,
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
        defaultItem: {
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
            ],company_name: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],vat_no: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],email: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
                val => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(val) || i18n.t('validation.email'),
            ],landline: [
                val => /(\d{0,3})(\d{0,3})(\d{0,4})/.test(val) || i18n.t('validation.phone'),
            ],mobile: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
                val => /(\d{0,3})(\d{0,3})(\d{0,4})/.test(val) || i18n.t('validation.phone'),
            ],
        },
        tableLoad: false,
        country:[],
        state:[],
        city:[],
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Add Vendor' : 'Edit Vendor'
        },
    },

    watch: {
        dialog(val) {
            val || this.close()
        },
        dialogDelete(val) {
            val || this.closeDelete()
        },
    },

    async created() {
        this.loadItems();
        this.loadCategories();
        this.country = countryList;
    },

    methods: {
        getCityName(item){
            if(item.city !== null) return JSON.parse(item.city).name;
        },
        async getStates(country){
            this.state = stateList.filter(function(value, index) {
                return value.country_id === country.id;
            })
        },
        async getCities(state){
            this.city = cityList.filter(function(value, index) {
                return value.state_id === state.id
            })
        },
        async loadItems() {
            let res = await ApiServices.vendorIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.vendors = res.data;
            }
        },
        async loadCategories() {
            let res = await ApiServices.categoryIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.categories = res.data;
            }
        },
        editItem(item) {
            this.editedIndex = this.vendors.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.editedItem.country = JSON.parse(this.editedItem.country);
            this.editedItem.state = JSON.parse(this.editedItem.state);
            this.editedItem.city = JSON.parse(this.editedItem.city);
            console.log('edit but', this.editedItem);
            this.getStates(this.editedItem.country);
            this.getCities(this.editedItem.state);
            this.dialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.vendors.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.vendorDelete(this.editedItem.id);
            if (res.success === true) {
                this.vendors.splice(this.editedIndex, 1)
            }
            this.closeDelete()
        },

        close() {
            this.progressL = false;
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            });
            this.loadItems();
        },

        closeDelete() {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        async save() {
            if (this.editedIndex > -1) {
                //edit goes here
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
                let res = await ApiServices.vendorEdit(this.editedItem.id, data);
                if (res.success === true) {
                    Object.assign(this.vendors[this.editedIndex], this.editedItem)
                    this.$refs.form.reset();
                    this.close();
                }
            } else {
                //add new
                this.validateData();
                if (this.validated) {
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
                        this.vendors.push(this.editedItem);
                        this.$refs.form.reset();
                        this.close()
                    }
                }
            }
        },
        validateData() {
            this.$refs.form.validate();
            if (this.editedItem.name === null) {
                this.validated = false
            }if (this.editedItem.company_name === null) {
                this.validated = false
            }if (this.editedItem.vat_no === null) {
                this.validated = false
            }if (this.editedItem.email === null) {
                this.validated = false
            }if (this.editedItem.landline === null) {
                this.validated = false
            }if (this.editedItem.mobile === null) {
                this.validated = false
            }if (this.editedItem.country === null) {
                this.validated = false
            }if (this.editedItem.state === null) {
                this.validated = false
            }if (this.editedItem.city === null) {
                this.validated = false
            }if (this.editedItem.postal_code === null) {
                this.validated = false
            }if (this.editedItem.category_id === null) {
                this.validated = false
            }if (this.editedItem.is_active === null) {
                this.validated = false
            } else {
                this.validated = true
            }
        }
    },
}
</script>


<style scoped>

</style>
