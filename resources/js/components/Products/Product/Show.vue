<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Product </strong> {{ show.name }}
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
                                        <h6>Brand: </h6>
                                        <p v-if="show.brand_id">{{ show.brand.name }}</p>
                                        <p v-else>---</p>
                                        <h6>Category: </h6>
                                        <p v-if="show.category_id">{{ show.category.name }}</p>
                                        <p v-else>---</p>
                                        <h6 v-if="show.product">Product: </h6>
                                        <p v-if="show.product">{{ show.product.name }}</p>
                                        <h6>Status: </h6>
                                        <div v-if="show.is_active === 1" class="mb-2">
                                            <CButton size="sm" color="success">
                                                Active
                                            </CButton>
                                        </div>
                                        <div v-else class="mb-2">
                                            <CButton size="sm" color="danger">
                                                Inactive
                                            </CButton>
                                        </div>
                                        <h6>Details: </h6>
                                        <p>{{ show.details }}</p>
                                    </CCol>
                                </CRow>
                                <CForm>
                                    <CCardFooter>
                                        <CButton size="sm" color="primary" :to="'/products/edit/'+show.id">
                                            <CIcon name="cil-check-circle"/>
                                            Edit
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/products'">
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
            }
        },
    }
}
</script>
