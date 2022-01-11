<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>{{ $t('product') }} </strong> {{ show.name }}
                            </CCardHeader>
                            <CCardBody>
                                <CRow>
                                    <CCol md="3" v-if="show.image_id">
                                        <v-col v-if="typeof(show.link) === 'string'">
                                            <v-card width="200"
                                                    v-on:click="openImage(show.link)">
                                                <v-img
                                                    :src="cdnURL+show.link"
                                                    height="125"
                                                    class="grey darken-4"
                                                ></v-img>
                                                <v-card-title class="title">
                                                    {{ $t('image') }}
                                                </v-card-title>
                                            </v-card>
                                        </v-col>
                                    </CCol>
                                    <CCol>
                                        <CRow>
                                            <CCol md="4">
                                                <h6>{{ $t('name') }}: </h6>
                                                <p>{{ show.name }}</p>
                                            </CCol>
                                            <CCol md="4">
                                                <h6>{{ $t('code') }}: </h6>
                                                <p>{{ show.code }}</p>
                                            </CCol>
                                            <CCol md="4">
                                                <h6>{{ $t('brand') }}: </h6>
                                                <p v-if="show.brand_id">{{ show.brand.name }}</p>
                                                <p v-else>---</p>
                                            </CCol>
                                        </CRow>
                                        <CRow>
                                            <CCol md="4">
                                                <h6>{{ $t('category') }}: </h6>
                                                <p v-if="show.category_id">{{ show.category.name }}</p>
                                                <p v-else>---</p>
                                            </CCol>
                                            <CCol md="4">
                                                <h6>{{ $t('cost_price') }}: </h6>
                                                <p v-if="show.cost_price">Rs. {{ show.cost_price }}</p>
                                                <p v-else>---</p>
                                            </CCol>
                                            <CCol md="4">
                                                <h6>{{ $t('stock') }}: </h6>
                                                <p v-if="show.stock">{{ show.stock }}</p>
                                                <p v-else>---</p>
                                            </CCol>
                                        </CRow>
                                        <CRow>
                                            <CCol md="4">
                                                <h6>{{ $t('alert') + ' ' + $t('stock') }}: </h6>
                                                <p v-if="show.alert_stock">{{ show.alert_stock }}</p>
                                                <p v-else>---</p>
                                            </CCol>
                                            <CCol md="4">
                                                <h6>{{ $t('unit') }}: </h6>
                                                <p v-if="show.unit_id">{{ show.unit.name }}</p>
                                                <p v-else>---</p>
                                            </CCol>
                                            <CCol md="4">
                                                <h6>{{ $t('distribute') + ' ' + $t('unit') }}: </h6>
                                                <p v-if="show.distribute_unit_id">{{ show.distribute_unit.name }}</p>
                                                <p v-else>---</p>
                                            </CCol>
                                        </CRow>
                                        <CRow>
                                            <CCol md="4">
                                                <h6>{{ $t('status') }}: </h6>
                                                <div v-if="show.is_active === 1" class="ml-1">
                                                    <CButton size="sm" color="success">
                                                        {{ $t('active') }}
                                                    </CButton>
                                                </div>
                                                <div v-else class="ml-1">
                                                    <CButton size="sm" color="danger">
                                                        {{ $t('inactive') }}
                                                    </CButton>
                                                </div>
                                            </CCol>
                                            <CCol md="4">
                                                <h6>{{ $t('type') }}: </h6>
                                                <p v-if="show.type">{{ show.type }}</p>
                                                <p v-else>---</p>
                                            </CCol>
                                        </CRow>
                                    </CCol>
                                    <CCol md="3">
                                        <h6>{{ $t('details') }}: </h6>
                                        <p v-if="show.details">{{ show.details }}</p>
                                        <p v-else>-----</p>
                                    </CCol>
                                </CRow>
                                <hr>
                                <v-toolbar flat style="height: 110px">
                                    <template v-slot:extension>
                                        <v-tabs
                                            v-model="tabs"
                                            fixed-tabs
                                        >
                                            <v-tabs-slider></v-tabs-slider>
                                            <v-tab
                                                href="#variants"
                                                class="primary--text"
                                            >
                                                {{ $t('variants') }}
                                            </v-tab>

                                            <v-tab
                                                href="#vendor"
                                                class="primary--text"
                                            >
                                                {{ $t('vendors') }}
                                            </v-tab>
                                        </v-tabs>
                                    </template>
                                </v-toolbar>

                                <v-tabs-items v-model="tabs">
                                    <v-tab-item
                                        :value="'variants'"
                                    >
                                        <v-card flat>
                                            <v-data-table
                                                :headers="headers"
                                                :items="variants"
                                                sort-by="id"
                                                loading
                                                loading-text="Loading... Please wait..."
                                                :search="search"
                                                class="mt-2"
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
                                                <template v-slot:no-data>
                                                    <div>No Data</div>
                                                </template>
                                            </v-data-table>
                                        </v-card>
                                    </v-tab-item>
                                    <v-tab-item
                                        :value="'vendor'"
                                    >
                                        <v-card flat>
                                            <v-data-table
                                                :headers="headers1"
                                                :items="vendors"
                                                sort-by="id"
                                                loading
                                                loading-text="Loading... Please wait..."
                                                :search="search1"
                                                class="mt-2"
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
                                                                    v-model="search1"
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
                                                <template v-slot:item.city="{ item }">
                                                    {{ getCityName(item) }}
                                                </template>
                                                <template v-slot:item.actions="{ item }">
                                                    <router-link
                                                        :to="'/vendors/'+item.id"
                                                        v-if="$can('vendors')"
                                                    >
                                                        <v-icon
                                                            small
                                                        >
                                                            mdi-eye
                                                        </v-icon>
                                                    </router-link>
                                                    <v-icon
                                                        small
                                                        class="mr-2"
                                                        @click="editItem(item)"
                                                        v-if="$can('vendors.edit')"
                                                    >
                                                        mdi-pencil
                                                    </v-icon>
                                                    <v-icon
                                                        small
                                                        @click="deleteItem(item)"
                                                        v-if="$can('vendors.delete')"
                                                    >
                                                        mdi-delete
                                                    </v-icon>
                                                    <router-link
                                                        :to="'/vendorProducts/add/'+item.id"
                                                        v-if="$is('Store Keeper')"
                                                    >
                                                        <v-icon
                                                            small
                                                        >
                                                            mdi-chart-box-plus-outline
                                                        </v-icon>
                                                    </router-link>

                                                </template>
                                                <template v-slot:no-data>
                                                    <div>No Data</div>
                                                </template>
                                            </v-data-table>
                                        </v-card>
                                    </v-tab-item>
                                </v-tabs-items>
                                <hr>
                                <CForm>
                                    <CCardFooter>
                                        <CButton size="sm" color="primary" :to="'/products/edit/'+show.id">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.edit') }}
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/products'">
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
import route from "../../../router";
import i18n from "../../../i18n";
import ApiServices from "../../../services/ApiServices";
import config from "../../../config";

export default {
    name: "ProductShow",

    props: {
        source: String,
    },
    data: () => ({
        cdnURL: config.cdnURL,
        baseURL: config.baseURL,
        tabs: null,
        show: {
            id: null,
            name: '',
            brand_id: '',
            category_id: '',
            code: '',
            details: '',
            is_active: '',
            image_id: '',
        },
        variants: [],
        allVendors: [],
        vendors: [],
        vendor_ids: [],
        search: '',
        search1: '',
        headers: [
            {text: i18n.t('id'), value: 'id'},
            {text: i18n.t('attributes'), value: 'name'},
            {text: i18n.t('image'), value: 'link'},
            {text: i18n.t('quantity'), value: 'quantity'},
            {text: i18n.t('price'), value: 'price'},
        ],
        headers1: [
            // {text: i18n.t('id'), align: 'start', sortable: false, value: 'id'},
            {text: i18n.t('name'), value: 'name'},
            {text: i18n.t('company_name'), value: 'company_name'},
            {text: i18n.t('vat_pan') + ' ' + i18n.t('number'), value: 'vat_no'},
            {text: i18n.t('email'), value: 'email'},
            {text: i18n.t('mobile'), value: 'landline'},
            {text: i18n.t('city'), value: 'city'},
        ],
        tableLoad: false,
    }),
    async created() {
        this.loadItems();
    },
    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        getCityName(item) {
            if (item.city !== null) return JSON.parse(item.city).name;
        },
        async loadItems() {
            let res = await ApiServices.productShow(this.$route.params.id);
            if (res.success === true) {
                this.show = res.data;
                this.variants = res.data.product_variants;
            }
            let rtn = await ApiServices.vendorIndex();
            if (rtn.success === true) {
                this.tableLoad = false;
                this.allVendors = rtn.data;

                let ids = await this.loadVendorProductIds();
            }
        },
        async loadVendorProductIds() {
            let res = await ApiServices.vendorProductIds('vendor', this.$route.params.id);
            if (res.success === true) {
                this.tableLoad = false;
                this.vendor_ids = res.data;
                for (let i = 0; i < this.allVendors.length; i++) {
                    for (let j = 0; j < this.vendor_ids.length; j++) {
                        if (this.allVendors[i].id === this.vendor_ids[j]) {
                            this.vendors.push(this.allVendors[i]);
                        }
                    }
                }
            }
        },
    }
}
</script>
<style scoped>

</style>
