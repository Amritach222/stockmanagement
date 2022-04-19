<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Show</strong> Quotation
                                <v-progress-circular
                                    v-if="changeProgress"
                                    indeterminate
                                    color="white"
                                    size="30"
                                ></v-progress-circular>
                            </CCardHeader>
                            <CCardBody>
                                <CForm>
                                    <v-form>
                                        <v-row>
                                            <v-col md="4">
                                                <h6>{{ $t('department') }}</h6>
                                                <p v-if="editedItem.department_id">{{ editedItem.department.name }}</p>
                                                <p v-else>---</p>
                                            </v-col>
                                            <v-col md="4">
                                                <h6>{{ $t('due') + ' ' + $t('date') }}</h6>
                                                <p v-if="editedItem.due_date">{{ editedItem.due_date }}</p>
                                                <p v-else>---</p>
                                            </v-col>
                                            <v-col md="4">
                                                <h6>{{ $t('desired') + ' ' + $t('delivery') + ' ' + $t('date') }}</h6>
                                                <p v-if="editedItem.desired_delivery_date">{{ editedItem.desired_delivery_date }}</p>
                                                <p v-else>---</p>
                                            </v-col>
                                            <v-col md="4">
                                                <h6>{{ $t('requested') + ' ' + $t('name') }}</h6>
                                                <p v-if="editedItem.requested_name">{{ editedItem.requested_name }}</p>
                                                <p v-else>---</p>
                                            </v-col>
                                            <v-col md="4">
                                                <v-row>
                                                    <v-col v-if="typeof(editedItem.link) === 'string'">
                                                        <v-col width="200" class="ml-3 file-link"
                                                               v-on:click="openImage(editedItem.link)">
                                                            <h5> Open File </h5>
                                                        </v-col>
                                                    </v-col>
                                                </v-row>
                                            </v-col>
                                        </v-row>

                                        <h6>{{ $t('note') }}</h6>
                                        <p>{{ editedItem.note }}</p>
                                    </v-form>

                                    <hr>
                                    <v-card flat>
                                        <v-card-title>
                                            {{ $t('products') }}
                                            <v-spacer></v-spacer>
                                        </v-card-title>
                                        <v-data-table
                                            :headers="headers"
                                            :items="quoProducts"
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
                                            <template v-slot:item.product_id="{ item }">
                                                <p v-if="item.product_id" class="mt-3">{{ item.product.name }}</p>
                                            </template>
                                            <template v-slot:item.product_variant_id="{ item }">
                                                <p v-if="item.product_variant_id" class="mt-3">{{
                                                        item.product_variant.name
                                                    }}</p>
                                                <p v-else class="mt-3">---</p>
                                            </template>
                                            <template v-slot:item.purchase_product_id="{ item }">
                                                <router-link
                                                    :to="'/purchase/purchase-request/'+item.purchase.id"
                                                    v-if="item.purchase_product_id" class="mt-3">
                                                    {{ item.purchase.reference_no }}
                                                    <!--                                                </p>-->
                                                </router-link>
                                                <p v-else class="mt-3">---</p>
                                            </template>
                                            <template v-slot:item.price="{ item }">
                                                <p v-if="item.price" class="mt-3">NRs. {{ item.price }}</p>
                                                <p v-else class="mt-3">0</p>
                                            </template>
                                            <template v-slot:item.tax_id="{ item }">
                                                <p v-if="item.tax_id" class="mt-3">{{ item.tax.value }}%</p>
                                                <p v-else class="mt-3">0</p>
                                            </template>
                                            <template v-slot:item.unit_id="{ item }">
                                                <p v-if="item.unit_id" class="mt-3">{{ item.unit.name }}</p>
                                                <p v-else class="mt-3">---</p>
                                            </template>
                                            <template v-slot:item.shipping_cost="{ item }">
                                                <p v-if="item.shipping_cost" class="mt-3">NRs. {{ item.shipping_cost }}</p>
                                                <p v-else class="mt-3">---</p>
                                            </template>
                                            <template v-slot:item.discount="{ item }">
                                                <p class="mt-3"
                                                   v-if="item.discount && item.discount_type === 'Amount'">NRs.
                                                    {{ item.discount }}</p>
                                                <p class="mt-3"
                                                   v-else-if="item.discount && item.discount_type === 'Percent'">
                                                    {{ item.discount }}%</p>
                                                <p class="mt-3" v-else>---</p>
                                            </template>
                                            <template v-slot:item.status="{ item }">
                                                <div v-if="item.status === 'On Progress'">
                                                    <CButton size="sm" color="warning" class="m-1">
                                                        On Progress
                                                    </CButton>
                                                </div>
                                                <div v-else-if="item.status === 'Pending'">
                                                    <CButton size="sm" color="secondary" class="m-1">
                                                        Pending
                                                    </CButton>
                                                </div>
                                                <div v-else-if="item.status === 'Rejected'">
                                                    <CButton size="sm" class="m-1" color="danger"
                                                    >
                                                        Rejected
                                                    </CButton>
                                                </div>
                                                <div v-else-if="item.status === 'Cancelled'">
                                                    <CButton size="sm" class="m-1" color="danger"
                                                    >
                                                        Cancelled
                                                    </CButton>
                                                </div>
                                                <div v-else-if="item.status === 'Approved'">
                                                    <CButton size="sm" class="m-1" color="success"
                                                    >
                                                        Approved
                                                    </CButton>
                                                </div>
                                                <div v-else-if="item.status === 'Accepted'">
                                                    <CButton size="sm" class="m-1" color="primary">
                                                        Accepted
                                                    </CButton>
                                                </div>
                                                <div v-else>
                                                    <CButton size="sm" class="m-1" color="warning">
                                                        {{ item.status }}
                                                    </CButton>
                                                </div>
                                            </template>
                                            <template v-slot:no-data>
                                                <div>No Data</div>
                                            </template>
                                        </v-data-table>
                                    </v-card>

                                    <hr>
                                    <v-card flat v-if="vendorCard">
                                        <v-card-title>
                                            {{ $t('vendors') }}
                                            <v-spacer></v-spacer>
                                        </v-card-title>
                                        <v-data-table
                                            :headers="headersV"
                                            :items="quoVendors"
                                            sort-by="name"
                                            loading
                                            loading-text="Loading... Please wait..."
                                            :search="searchV"
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
                                                                v-model="searchV"
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
                                            <template v-slot:item.status="{ item }">
                                                <div v-if="item.status === 'On Progress'">
                                                    <CButton size="sm" color="warning" class="m-1">
                                                        On Progress
                                                    </CButton>
                                                </div>
                                                <div v-else-if="item.status === 'Pending'">
                                                    <CButton size="sm" color="secondary" class="m-1">
                                                        Pending
                                                    </CButton>
                                                </div>
                                                <div v-else-if="item.status === 'Rejected'">
                                                    <CButton size="sm" class="m-1" color="danger"
                                                    >
                                                        Rejected
                                                    </CButton>
                                                </div>
                                                <div v-else-if="item.status === 'Cancelled'">
                                                    <CButton size="sm" class="m-1" color="danger"
                                                    >
                                                        Cancelled
                                                    </CButton>
                                                </div>
                                                <div v-else-if="item.status === 'Approved'">
                                                    <CButton size="sm" class="m-1" color="success"
                                                    >
                                                        Approved
                                                    </CButton>
                                                </div>
                                                <div v-else-if="item.status === 'Accepted'">
                                                    <CButton size="sm" class="m-1" color="primary">
                                                        Accepted
                                                    </CButton>
                                                </div>
                                                <div v-else>
                                                    <CButton size="sm" class="m-1" color="warning">
                                                        {{ item.status }}
                                                    </CButton>
                                                </div>
                                            </template>
                                            <template v-slot:item.actions="{ item }">
                                                <router-link
                                                    :to="'/quotations/vendor/'+$route.params.id+'/'+item.id"
                                                >
                                                    <v-icon
                                                        small
                                                        class="mr-2"
                                                    >
                                                        mdi-eye
                                                    </v-icon>
                                                </router-link>
                                            </template>
                                            <template v-slot:no-data>
                                                <div>No Data</div>
                                            </template>
                                        </v-data-table>
                                    </v-card>


                                    <CCardFooter>
                                        <CButton size="sm" color="warning" @click="sendQPtoPO">
                                            <CIcon name="cil-check-circle"/>
                                            Create PO
                                        </CButton>
                                        <CButton :to="'/quotations'" size="sm" color="danger">
                                            <CIcon name="cil-ban"/>
                                            Cancel
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
import ApiServices from "../../../services/ApiServices";
import config from "../../../config";

export default {
    name: "QuotationShow",

    props: {
        source: String,
    },
    data: () => ({
        cdnURL: config.cdnURL,
        createProgress: false,
        search: '',
        progressL: false,
        dialog: false,
        dialogDelete: false,
        searchV: '',
        searchSV: '',
        dialogV: false,
        dialogVDelete: false,
        dialogVConfirm: false,
        dueDateValidation: false,
        deliveryDateValidation: false,
        menu1: false,
        menu2: false,
        headers: [
            {text: i18n.t('product'), value: 'product_id'},
            {text: i18n.t('product') + ' ' + i18n.t('variant'), value: 'product_variant_id'},
            {text: i18n.t('quantity'), value: 'quantity'},
            {text: i18n.t('price'), value: 'price'},
            {text: i18n.t('total'), value: 'total'},
            {text: i18n.t('tax'), value: 'tax_id'},
            {text: i18n.t('discount'), value: 'discount'},
            {text: i18n.t('shipping_cost'), value: 'shipping_cost'},
            {text: i18n.t('unit'), value: 'unit_id'},
            {text: i18n.t('grand_total'), value: 'grand_total'},
            {text: i18n.t('status'), value: 'status'},
            // {text: i18n.t('actions'), value: 'actions', sortable: false},
        ],
        headersV: [
            {text: i18n.t('name'), value: 'name'},
            {text: i18n.t('email'), value: 'email'},
            {text: i18n.t('company_name'), value: 'company_name'},
            {text: i18n.t('mobile'), value: 'mobile'},
            {text: i18n.t('status'), value: 'status'},
            {text: i18n.t('actions'), value: 'actions'},
        ],
        headersSV: [
            {text: i18n.t('name'), value: 'name'},
            {text: i18n.t('email'), value: 'email'},
            {text: i18n.t('company_name'), value: 'company_name'},
            {text: i18n.t('mobile'), value: 'mobile'},
        ],
        quotations: [],
        tableLoad: false,
        productCount: 0,
        editedIndex: -1,
        quoProducts: [],
        products: [],
        vendors: [],
        quoVendors: [],
        newQuoVendors: [],
        selectVendors: [],
        selectedVendors: [],
        singleSelect: false,
        selected: [],
        deleteProduct: [],
        vendorCard: false,
        changeProgress: false,
        validated: false,
        departments: [],
        variants: [],
        hasVariants: false,
        editedItem: {
            id: null,
            department_id: '',
            file: [],
            note: '',
            due_date: '',
            desired_delivery_date: '',
            requested_name: '',
            is_pending: '',
        },
        rules: [
            value => !!value || 'Required.',
        ]
    }),
    computed: {
    },
    async created() {
        let data = await this.loadData();
        let item = await this.loadItems();
        // this.loadQuoProducts();
    },
    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async sendQPtoPO () {
            let res = await store.dispatch('purchase/addSelectedProducts', this.quoProducts);
            route.replace('/purchaseOrders/create?create=po');
        },
        async loadItems() {
            let res = await ApiServices.productIndex();
            if (res.success === true) {
                this.products = res.data;
            }
        },
        async loadData() {
            let res = await ApiServices.quotationShow(this.$route.params.id);
            if (res.success === true) {
                this.editedItem = res.data;
                this.quoProducts = res.data.quotation_products;
                if (this.quoProducts.length > 0) {
                    this.vendorCard = true;
                }
                this.quoVendors = res.data.vendors;
                if (res.data.is_from_purchase === 1) {
                    this.headers.unshift({
                        text: i18n.t('purchase') + ' ' + i18n.t('request'), value: 'purchase_product_id'
                    })
                }
            }
        },
    }
}
</script>

<style scoped>
.file-link {
    cursor: pointer;
    text-decoration: underline;
}

.card-btn {
    color: #fff !important;
    margin-left: 3px !important;
}
</style>
