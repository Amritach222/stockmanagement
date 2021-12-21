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
                                    <CCol md="3" v-if="show.profile_picture_id">
                                        <v-col v-if="typeof(show.link) === 'string'">
                                            <v-card width="200"
                                                    v-on:click="openImage(show.link)">
                                                <v-img
                                                    :src="cdnURL+show.link"
                                                    height="175"
                                                    class="grey darken-4"
                                                ></v-img>
<!--                                                <v-card-title class="title">-->
<!--                                                    {{ $t('image') }}-->
<!--                                                </v-card-title>-->
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
                                                <h6>{{ $t('username') }}: </h6>
                                                <p>{{ show.username }}</p>
                                            </CCol>
                                            <CCol md="4">
                                                <h6>{{ $t('email') }}: </h6>
                                                <p>{{ show.email }}</p>
                                            </CCol>
                                            <CCol md="4">
                                                <h6>{{ $t('mobile') }}: </h6>
                                                <p>{{ show.mobile_no }}</p>
                                            </CCol>
                                            <CCol md="4">
                                                <h6>{{ $t('address') }}: </h6>
                                                <p>{{ show.address }}</p>
                                            </CCol>
                                            <CCol md="4">
                                                <h6>{{ $t('department') }}: </h6>
                                                <p v-if="show.department_id">{{ show.department }}</p>
                                                <p v-else>---</p>
                                            </CCol>
                                            <CCol md="4">
                                                <h6>{{ $t('designation') }}: </h6>
                                                <p v-if="show.designation_id">{{ show.designation }}</p>
                                                <p v-else>---</p>
                                            </CCol>
                                            <CCol md="4">
                                                <h6>{{ $t('role') }}: </h6>
                                                <p v-if="show.role_name">{{ show.role_name }}</p>
                                                <p v-else>---</p>
                                            </CCol>
<!--                                            <CCol md="4">-->
<!--                                                <h6>{{ $t('stock') }}: </h6>-->
<!--                                                <p v-if="show.stock">{{ show.stock }}</p>-->
<!--                                                <p v-else>-&#45;&#45;</p>-->
<!--                                            </CCol>-->
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
<!--                                            <CCol md="4">-->
<!--                                                <h6>{{ $t('type') }}: </h6>-->
<!--                                                <p v-if="show.type">{{ show.type }}</p>-->
<!--                                                <p v-else>-&#45;&#45;</p>-->
<!--                                            </CCol>-->
                                        </CRow>
                                    </CCol>
                                </CRow>

                                <CForm>
                                    <CCardFooter>
                                        <CButton size="sm" color="primary" :to="'/users/edit/'+show.id">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.edit') }}
                                        </CButton>
                                        <CButton size="sm" color="warning" :to="'/users/edit/'+show.id">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.permissions') }}
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/users'">
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
            department_id: '',
            designation_id: '',
            username: '',
            is_active: '',
            email: '',
            mobile_no: '',
            address: '',
            password: '',
            confirm_password: '',
            role_name: '',
            link: '',
            profile_picture_id:'',
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
            // let rtn = await ApiServices.vendorIndex();
            // if (rtn.success === true) {
            //     this.tableLoad = false;
            //     this.allVendors = rtn.data;
            //
            //     let ids = await this.loadVendorProductIds();
            // }
        },
        // async loadVendorProductIds() {
        //     let res = await ApiServices.vendorProductIds('vendor', this.$route.params.id);
        //     if (res.success === true) {
        //         this.tableLoad = false;
        //         this.vendor_ids = res.data;
        //         for (let i = 0; i < this.allVendors.length; i++) {
        //             for (let j = 0; j < this.vendor_ids.length; j++) {
        //                 if (this.allVendors[i].id === this.vendor_ids[j]) {
        //                     this.vendors.push(this.allVendors[i]);
        //                 }
        //             }
        //         }
        //     }
        // },
    }
}
</script>
<style scoped>

</style>
