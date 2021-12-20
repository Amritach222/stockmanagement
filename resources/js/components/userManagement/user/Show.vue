<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>{{ $t('user') }} </strong> {{ show.name }}
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
    name: "UserShow",

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
            let res = await ApiServices.userShow(this.$route.params.id);
            if (res.success === true) {
                this.show = res.data;
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
