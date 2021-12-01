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
                                        <h6>{{ $t('brand') }}: </h6>
                                        <p v-if="show.brand_id">{{ show.brand.name }}</p>
                                        <p v-else>---</p>
                                        <h6>{{ $t('category') }}: </h6>
                                        <p v-if="show.category_id">{{ show.category.name }}</p>
                                        <p v-else>---</p>
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
                                        <h6>{{ $t('details') }}: </h6>
                                        <p>{{ show.details }}</p>
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
            category_id: '',
            code: '',
            details: '',
            is_active: '',
            image_id: '',
        },
        variants: [],
        search: '',
        headers: [
            {text: i18n.t('id'), value: 'id'},
            {text: i18n.t('attributes'), value: 'name'},
            {text: i18n.t('image'), value: 'link'},
            {text: i18n.t('quantity'), value: 'quantity'},
            {text: i18n.t('price'), value: 'price'},
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
            let res = await ApiServices.productShow(this.$route.params.id);
            if (res.success === true) {
                this.show = res.data;
                this.variants = res.data.product_variants;
            }
        },
    }
}
</script>
