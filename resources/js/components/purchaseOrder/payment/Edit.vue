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
                                                            v-model="editedItem.due_date"
                                                            description="Please due date."
                                                            autocomplete=""
                                                            label="Due Date"
                                                            prepend-inner-icon="mdi-calender"
                                                            placeholder="Enter due date..."
                                                            required
                                                            solo
                                                        >
                                                        </v-text-field>
                                                    </v-col>
                                                </v-row>
                                            </v-col>
                                        </v-row>
                                    </v-form>
                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.submit') }}
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/purchaseOrders/payment/'+editedItem.purchase_order_id">
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
    import config from "../../../config";
    import ApiServices from "../../../services/ApiServices";
    import countryList from "../../../services/lib/country.json";
    import stateList from "../../../services/lib/state.json";
    import cityList from "../../../services/lib/city.json";

    export default {
        name: "PurchaseOrderBillEdit",

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
                    due_date: '',
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
                let res = await ApiServices.paymentShow(this.$route.params.id);
                if (res.success === true) {
                    this.editedItem = res.data;
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
                if (this.editedItem.due_date !== null && this.editedItem.due_date !== '') {
                    data.append('due_date', this.editedItem.due_date);
                }

                let res = await ApiServices.paymentEdit(this.editedItem.id, data);
                this.createProgress = false;
                if (res.success === true) {
                    route.replace('/purchaseOrders/payment/'+this.editedItem.purchase_order_id);
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
