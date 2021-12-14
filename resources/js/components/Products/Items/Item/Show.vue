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
                                        <h6>{{ $t('quantity') }}: </h6>
                                        <p>{{ show.quantity }}</p>
                                        <h6 v-if="show.product">{{ $t('product') }}: </h6>
                                        <p v-if="show.product">{{ show.product.name }}</p>
                                        <h6 v-if="show.product_variant">{{ $t('product') +' '+ $t('variant') }}: </h6>
                                        <p v-if="show.product_variant">{{ show.product_variant.name }}</p>
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
                                    <v-card-title>
                                        {{ $t('users') }}
                                        <v-spacer></v-spacer>
                                    </v-card-title>
                                    <v-data-table
                                        :headers="headers"
                                        :items="itemUsers"
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
                                        <template v-slot:item.user_id="{ item }">
                                            <p v-if="item.user_id" class="mt-3">{{ item.user.name }}</p>
                                            <p v-else class="mt-3">---</p>
                                        </template>
                                        <template v-slot:item.department_id="{ item }">
                                            <p v-if="item.department_id" class="mt-3">{{ item.department.name }}</p>
                                            <p v-else class="mt-3">---</p>
                                        </template>
                                        <template v-slot:no-data>
                                            <div>No Data</div>
                                        </template>
                                    </v-data-table>

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
            product_variant_id: '',
            quantity: '',
            cost_price: '',
            unit_id: '',
            tax_id: '',
            tax_method: '',
            image: [],
        },
        itemUsers: [],
        changeProgress: false,
        search: '',
        progressL: false,
        dialog: false,
        editDialog: false,
        dialogDelete: false,
        headers: [
            {text: i18n.t('user'), value: 'user_id'},
            {text: i18n.t('department'), value: 'department_id'},
            {text: i18n.t('time_span'), value: 'time_span'},
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
                let rtn = await this.loadItemUsers(res.data.id);
            }
        },
        async loadItemUsers(id) {
            let res = await ApiServices.itemUsers(id);
            if (res.success === true) {
                this.itemUsers = res.data;
            }
        },
    }
}
</script>
