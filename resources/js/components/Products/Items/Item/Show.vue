<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                    <strong>{{ $t('item') }} </strong> {{ show.name }}
                            </CCardHeader>
                            <CCardBody>
                                <CRow>
                                    <CCol md="4" v-if="show.image_id">
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
                                    <CCol md="8">
                                        <h6>{{ $t('name') }}: </h6>
                                        <p>{{ show.name }}</p>
                                        <h6>{{ $t('code') }}: </h6>
                                        <p>{{ show.code }}</p>
                                        <h6>{{ $t('stock') }}: </h6>
                                        <p>{{ show.stock }}</p>
                                        <h6>{{ $t('alert_stock') }}: </h6>
                                        <p>{{ show.alert_stock }}</p>
                                        <h6 v-if="show.product">{{ $t('product') }}: </h6>
                                        <p v-if="show.product">{{ show.product.name }}</p>
                                        <h6 v-if="show.brand">{{ $t('brand') }}: </h6>
                                        <p v-if="show.brand">{{ show.brand.name }}</p>
                                        <h6>{{ $t('cost_price') }}: </h6>
                                        <p>{{ show.cost_price }}</p>
                                        <h6 v-if="show.unit">{{ $t('unit') }}: </h6>
                                        <p v-if="show.unit">{{ show.unit.name }}</p>
                                        <h6 v-if="show.tax">{{ $t('tax') }}: </h6>
                                        <p v-if="show.tax">{{ show.tax.name }}</p>
                                        <h6>{{ $t('tax_method') }}: </h6>
                                        <p>{{ show.tax_method }}</p>
                                    </CCol>
                                </CRow>
                                <hr>
                                <v-card>
                                    <v-card-title>
                                        {{ $t('variants') }}
                                        <v-spacer></v-spacer>
                                    </v-card-title>
                                    <v-data-table
                                        :headers="headers"
                                        :items="variants"
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
                                <CForm>
                                    <CCardFooter>
                                        <CButton size="sm" color="primary" :to="'/items/edit/'+show.id">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.edit') }}
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/items'">
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
import route from "../../../../router";
import i18n from "../../../../i18n";
import ApiServices from "../../../../services/ApiServices";
import config from "../../../../config";

export default {
    name: "ItemShow",

    props: {
        source: String,
    },
    data: () => ({
        cdnURL: config.cdnURL,
        baseURL: config.baseURL,
        show: {
            id: null,
            name: '',
            brand_id: '',
            product_id: '',
            stock: '',
            alert_stock: '',
            cost_price: '',
            unit_id: '',
            tax_id: '',
            tax_method: '',
            image: [],
        },
        variants: [],
        search: '',
        headers: [
            {text: 'Id', value: 'id'},
            {text: 'Attributes', value: 'name'},
            {text: 'Image', value: 'link'},
            {text: 'Quantity', value: 'quantity'},
            {text: 'Price', value: 'price'},
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
        async loadItems() {
            let res = await ApiServices.itemShow(this.$route.params.id);
            if (res.success === true) {
                this.show = res.data;
                this.variants = res.data.item_variants;
            }
        },
    }
}
</script>
