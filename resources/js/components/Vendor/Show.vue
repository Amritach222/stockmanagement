<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>{{ $t('vendor') }} </strong> {{ show.name }}
                            </CCardHeader>
                            <CCardBody>
                                <CRow>
                                    <CCol>
                                <CRow>
                                    <CCol md="3">
                                        <h6>{{ $t('name') }}: </h6>
                                        <p>{{ show.name }}</p>
                                    </CCol>
                                    <CCol md="3">
                                        <h6>{{ $t('username') }}: </h6>
                                        <p>{{ show.username }}</p>
                                    </CCol>
                                    <CCol md="3">
                                        <h6>{{ $t('vat_no') }}: </h6>
                                        <p v-if="show.vat_no">{{ show.vat_no }}</p>
                                        <p v-else>---</p>
                                    </CCol>
                                    <CCol md="3">
                                        <h6>{{ $t('email') }}: </h6>
                                        <p v-if="show.email">{{ show.email }}</p>
                                        <p v-else>---</p>
                                    </CCol>
                                </CRow>
                                <CRow>
                                    <CCol md="3">
                                        <h6>{{ $t('landline') }}: </h6>
                                        <p v-if="show.landline">{{ show.landline }}</p>
                                        <p v-else>---</p>
                                    </CCol>
                                    <CCol md="3">
                                        <h6>{{ $t('mobile') }}: </h6>
                                        <p v-if="show.mobile">{{ show.mobile }}</p>
                                        <p v-else>---</p>
                                    </CCol>
                                    <CCol md="3">
                                        <h6>{{ $t('postal_code') }}: </h6>
                                        <p v-if="show.postal_code">{{ show.postal_code }}</p>
                                        <p v-else>---</p>
                                    </CCol>
                                    <CCol md="3">
                                        <h6>{{ $t('category') }}: </h6>
                                        <p v-if="show.category_id">{{ show.category.name }}</p>
                                        <p v-else>---</p>
                                    </CCol>
                                </CRow>
                                <CRow>
                                    <CCol md="3">
                                        <h6>{{ $t('country') }}: </h6>
                                        <p v-if="show.country">{{ show.country.name }}</p>
                                        <p v-else>---</p>
                                    </CCol>
                                    <CCol md="3">
                                        <h6>{{ $t('state') }}: </h6>
                                        <p v-if="show.state">{{ show.state.name }}</p>
                                        <p v-else>---</p>
                                    </CCol>
                                    <CCol md="3">
                                        <h6>{{ $t('city') }}: </h6>
                                        <p v-if="show.city">{{ show.city.name }}</p>
                                        <p v-else>---</p>
                                    </CCol>
                                    <CCol md="3">
                                        <h6>{{ $t('status') }}: </h6>
                                        <div v-if="show.is_active === 1" class="mb-2">
                                            <CButton size="sm" color="success">
                                                {{ $t('active') }}
                                            </CButton>
                                        </div>
                                        <div v-else class="mb-2">
                                            <CButton size="sm" color="danger">
                                                {{ $t('inactive') }}
                                            </CButton>
                                        </div>
                                    </CCol>
                                </CRow>
                                    </CCol>
                                    <CCol md="3" v-if="typeof(show.link) === 'string'">
                                        <v-col v-if="typeof(show.link) === 'string'">
                                            <v-card width="200"
                                                    v-on:click="openImage(show.link)">
                                                <v-img
                                                    :src="cdnURL+show.link"
                                                    height="125"
                                                    class="grey darken-4"
                                                ></v-img>
                                                <v-card-title class="title">
                                                    {{ show.company_name }}
                                                </v-card-title>
                                            </v-card>
                                        </v-col>
                                    </CCol>
                                </CRow>
                                <hr>
                                <CRow>
                                    <CCol md="12">
                                        <v-card flat>
                                            <v-card-title>
                                                {{ $t('products') }}
                                                <v-spacer></v-spacer>
                                            </v-card-title>
                                            <v-data-table
                                                class="elevation-1"
                                                :headers="headers"
                                                :items="products"
                                                sort-by="id"
                                                :loading="tableLoad"
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
                                                                    :label="$t('search')"
                                                                    solo
                                                                    hide-details
                                                                    max-width="100px"
                                                                ></v-text-field>
                                                            </v-col>
                                                        </v-row>
                                                    </v-toolbar>
                                                </template>
                                                <template v-slot:item.link="{ item }">
                                                    <img :src=cdnURL+item.link
                                                         v-if="item.link"
                                                         style="width: 50px; height: 50px; object-fit: cover;"
                                                         v-on:click="openImage(item.link)"/>

                                                    <img :src="baseURL+'images/placeholder.jpg'"
                                                         v-else
                                                         style="width: 50px; height: 50px; object-fit: cover"
                                                    />
                                                </template>
                                                <template v-slot:item.brand="{ item }">
                                                    {{ item.brand.name }}
                                                </template>
                                                <template v-slot:item.category="{ item }">
                                                    {{ item.category.name }}
                                                </template>
                                                <template v-slot:item.status="{ item }">
                                                    <div v-if="item.status === 'Pending'">
                                                        <CButton size="sm" color="secondary" class="m-1">
                                                            Pending
                                                        </CButton>
                                                    </div>
                                                    <div v-else>
                                                        <CButton size="sm" class="m-1" color="success"
                                                        >
                                                            Approved
                                                        </CButton>
                                                    </div>
                                                </template>
                                                <template v-slot:no-data>
                                                    <div>No Data</div>
                                                </template>
                                            </v-data-table>
                                        </v-card>
                                    </CCol>
                                </CRow>
                                <hr>
                                <CForm>
                                    <CCardFooter>
                                        <CButton size="sm" color="primary" v-if="$can('vendors.edit')" :to="'/vendors/edit/'+show.id">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.edit') }}
                                        </CButton>
                                        <CButton size="sm" color="warning" :to="'/vendors/permission/'+show.username">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.permissions') }}
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/vendors'">
                                            <CIcon name="cil-ban"/>
                                            {{ $t('button.back') }}
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
import ApiServices from "../../services/ApiServices";
import i18n from "../../i18n";
import config from "../../config";
import route from "../../router";
import countryList from "../../services/lib/country.json";
import stateList from "../../services/lib/state.json";
import cityList from "../../services/lib/city.json";


export default {
    name: "VendorShow",
    data: () => ({
        search: '',
        cdnURL: config.cdnURL,
        baseURL: config.baseURL,
        validated: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        singleSelect: false,
        allProducts: [],
        headers: [
            {text: i18n.t('id'), align: 'start', sortable: true, value: 'id'},
            {text: i18n.t('name'), value: 'name'},
            {text: i18n.t('image'), value: 'link', sortable: false},
            {text: i18n.t('brand'), value: 'brand', sortable: false},
            {text: i18n.t('category'), value: 'category', sortable: false},
            {text: i18n.t('status'), value: 'status'},
        ],
        show: {
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
        products: [],
        product_ids: [],
        tableLoad: true,
    }),

    async created() {
        this.loadItems();
    },

    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadItems() {
            let rtn = await ApiServices.vendorShow(this.$route.params.id);
            if (rtn.success === true) {
                this.show = rtn.data;
                this.show.country = JSON.parse(this.show.country);
                this.show.state = JSON.parse(this.show.state);
                this.show.city = JSON.parse(this.show.city);
            }
            let res = await ApiServices.productList();
            if (res.success === true) {
                this.tableLoad = false;
                this.allProducts = res.data;
                let ids = await this.loadVendorProductIds();
            }
        },
        async loadVendorProductIds() {
            let res = await ApiServices.vendorProductIds('product',this.$route.params.id);
            if (res.success === true) {
                this.tableLoad = false;
                this.vendor_products = res.data;
                for (let i = 0; i < this.vendor_products.length; i++) {
                    for (let j = 0; j < this.allProducts.length; j++) {
                        if (this.allProducts[j].id === this.vendor_products[i].product_id) {
                            this.allProducts[j].status = this.vendor_products[i].status;
                            this.products.push(this.allProducts[j]);
                        }
                    }
                }
            }
        },
    },
}
</script>


<style scoped>
.btn-back {
    color: #fff !important;
    font-weight: 500;
}

.btn-submit {
    color: #fff !important;
    font-weight: 500;
}
</style>
