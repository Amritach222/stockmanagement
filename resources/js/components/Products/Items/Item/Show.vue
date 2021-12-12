<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Item</strong> {{ show.name }}
                            </CCardHeader>
                            <CCardBody>
                                <CRow>
                                    <CCol md="4">
                                        <v-col v-if="typeof(show.link) === 'string'">
                                            <v-card width="200"
                                                    v-on:click="openImage(show.link)">
                                                <v-img
                                                    :src="cdnURL+show.link"
                                                    height="125"
                                                    class="grey darken-4"
                                                ></v-img>
                                                <v-card-title class="title">
                                                    Image
                                                </v-card-title>
                                            </v-card>
                                        </v-col>
                                    </CCol>
                                    <CCol md="8">
                                        <h6>Name: </h6>
                                        <p>{{ show.name }}</p>
                                        <h6>Code: </h6>
                                        <p>{{ show.code }}</p>
                                        <h6>Stock: </h6>
                                        <p>{{ show.stock }}</p>
                                        <h6>Alert Stock: </h6>
                                        <p>{{ show.alert_stock }}</p>
                                        <h6 v-if="show.product">Product: </h6>
                                        <p v-if="show.product">{{ show.product.name }}</p>
                                        <h6 v-if="show.brand">Brand: </h6>
                                        <p v-if="show.brand">{{ show.brand.name }}</p>
                                        <h6>Cost Price: </h6>
                                        <p>{{ show.cost_price }}</p>
                                        <h6 v-if="show.unit">Unit: </h6>
                                        <p v-if="show.unit">{{ show.unit.name }}</p>
                                        <h6 v-if="show.tax">Tax: </h6>
                                        <p v-if="show.tax">{{ show.tax.name }}</p>
                                        <h6>Tax Method: </h6>
                                        <p>{{ show.tax_method }}</p>
                                    </CCol>
                                </CRow>
                                <CForm>
                                    <CCardFooter>
                                        <CButton size="sm" color="primary" :to="'/items/edit/'+show.id">
                                            <CIcon name="cil-check-circle"/>
                                            Edit
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/items'">
                                            <CIcon name="cil-ban"/>
                                            Back
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
            console.log(res)
            if (res.success === true) {
                this.show = res.data;
            }
        },
    }
}
</script>
