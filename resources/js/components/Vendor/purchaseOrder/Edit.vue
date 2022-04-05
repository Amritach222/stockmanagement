<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Edit</strong> Purchase Order
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
                                            <v-col md="3">
                                                <h6>{{ $t('requested') + ' ' + $t('name') }}</h6>
                                                <p>{{ editedItem.requester }}</p>
                                            </v-col>
                                            <v-col md="3">
                                                <h6>{{ $t('location') }}</h6>
                                                <p>{{ editedItem.location }}</p>
                                            </v-col>
                                            <v-col md="3">
                                                <h6>{{ $t('date') + ' ' + $t('of') + ' ' + $t('order') }}</h6>
                                                <p>{{ editedItem.date_of_order }}</p>
                                            </v-col>
                                            <v-col md="3">
                                                <h6>{{ $t('status') }}</h6>
                                                <p>{{ editedItem.status }}</p>
                                            </v-col>
                                        </v-row>
                                        <h6>{{ $t('description') }}</h6>
                                        <p>{{ editedItem.description }}</p>
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
                                                    <v-dialog v-model="dialogDelete" max-width="500px">
                                                        <v-card>
                                                            <v-card-title class="text-h6">
                                                                {{ $t('message.delete') }}
                                                            </v-card-title>
                                                            <v-card-actions>
                                                                <v-spacer></v-spacer>
                                                                <v-btn color="blue darken-1" text @click="closeDelete">
                                                                    {{ $t('button.cancel') }}
                                                                </v-btn>
                                                                <v-btn color="blue darken-1" text
                                                                       @click="deleteItemConfirm">
                                                                    {{ $t('button.submit') }}
                                                                </v-btn>
                                                                <v-spacer></v-spacer>
                                                            </v-card-actions>
                                                        </v-card>
                                                    </v-dialog>
                                                </v-toolbar>
                                            </template>
                                            <template v-slot:item.product_id="{ item }">
                                                <p v-if="item.product_id" class="mt-3">
                                                    {{ item.product.name }}</p>
                                            </template>
                                            <template v-slot:item.product_variant_id="{ item }">
                                                <p v-if="item.product_variant_id" class="mt-3">{{
                                                        item.product_variant.name
                                                    }}</p>
                                                <p v-else class="mt-3">---</p>
                                            </template>
                                            <template v-slot:item.quantity="{ item }">
                                                <div v-if="(item.status === 'Accepted') || (item.status === 'Review')">
                                                    <v-text-field
                                                        v-model="item.quantity"
                                                        placeholder="Enter quantity"
                                                        class="mt-2"
                                                    ></v-text-field>
                                                </div>
                                                <div v-else>
                                                    <p class="mt-3" v-if="item.quantity">{{ item.quantity }}</p>
                                                    <p class="mt-3" v-else>---</p>
                                                </div>
                                            </template>
                                            <template v-slot:item.price="{ item }">
                                                <div v-if="(item.status === 'Accepted') || (item.status === 'Review')">
                                                    <v-text-field
                                                        v-model="item.price"
                                                        placeholder="Enter price"
                                                        class="mt-2"
                                                    ></v-text-field>
                                                </div>
                                                <div v-else>
                                                    <p class="mt-3" v-if="item.price">NRs. {{ item.price }}</p>
                                                    <p class="mt-3" v-else>---</p>
                                                </div>
                                            </template>
                                            <template v-slot:item.shipping_cost="{ item }">
                                                <div v-if="(item.status === 'Accepted') || (item.status === 'Review')">
                                                    <v-text-field
                                                        v-model="item.shipping_cost"
                                                        placeholder="Enter shipping cost"
                                                        class="mt-2"
                                                    ></v-text-field>
                                                </div>
                                                <div v-else>
                                                    <p class="mt-3" v-if="item.shipping_cost">Nrs. {{
                                                            item.shipping_cost
                                                        }}</p>
                                                    <p class="mt-3" v-else>---</p>
                                                </div>
                                            </template>
                                            <template v-slot:item.tax_id="{ item }">
                                                <div v-if="(item.status === 'Accepted') || (item.status === 'Review')">
                                                    <v-select
                                                        v-model="item.tax_id"
                                                        class="mt-2"
                                                        :items="taxes"
                                                        placeholder="Select tax type"
                                                        item-value="id"
                                                        item-text="name"
                                                    ></v-select>
                                                </div>
                                                <div v-else>
                                                    <p v-if="item.tax_id" class="mt-3">{{ item.tax.value }}%</p>
                                                    <p v-else class="mt-3">0</p>
                                                </div>
                                            </template>
                                            <template v-slot:item.discount="{ item }">
                                                <div v-if="(item.status === 'Accepted') || (item.status === 'Review')">
                                                    <v-text-field
                                                        v-model="item.discount"
                                                        placeholder="Enter discount"
                                                        class="mt-2"
                                                    ></v-text-field>
                                                </div>
                                                <div v-else>
                                                    <p class="mt-3"
                                                       v-if="item.discount">
                                                        {{ item.discount }}</p>
                                                    <p class="mt-3" v-else>---</p>
                                                </div>
                                            </template>
                                            <template v-slot:item.discount_type="{ item }">
                                                <div v-if="(item.status === 'Accepted') || (item.status === 'Review')">
                                                    <v-select
                                                        v-model="item.discount_type"
                                                        class="mt-2"
                                                        :items="['Percent','Amount']"
                                                        placeholder="Select discount type"
                                                    ></v-select>
                                                </div>
                                                <div v-else>
                                                    <p class="mt-3">{{ item.discount_type }}</p>
                                                    <!--                                                    <p v-else class="mt-3">0</p>-->
                                                </div>
                                            </template>

                                            <template v-slot:no-data>
                                                <div>No Data</div>
                                            </template>
                                        </v-data-table>
                                    </v-card>

                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="edit('Approved')" v-if="editedItem.status === 'Pending'">
                                            <CIcon name="cil-check-circle"/>
                                            Accept
                                        </CButton>
                                        <CButton type="submit" size="sm" color="primary" @click="edit('Sent')" v-if="editedItem.status === 'Approved'">
                                            <CIcon name="cil-check-circle"/>
                                            Ship
                                        </CButton>
                                        <CButton :to="'/vendor/purchase-orders'" size="sm" color="danger">
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
import store from "../../../store";
import route from "../../../router";
import i18n from "../../../i18n";
import ApiServices from "../../../services/ApiServices";
import config from "../../../config";

export default {
    name: "VendorQuotationEdit",

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
        headers: [
            {text: i18n.t('product'), value: 'product_id'},
            {text: i18n.t('product') + ' ' + i18n.t('variant'), value: 'product_variant_id'},
            {text: i18n.t('quantity'), value: 'quantity'},
            {text: i18n.t('price'), value: 'price'},
            {text: i18n.t('total'), value: 'total'},
            // {text: i18n.t('tax'), value: 'tax_id'},
            // {text: i18n.t('discount'), value: 'discount'},
            {text: i18n.t('shipping_cost'), value: 'shipping_cost'},
            {text: i18n.t('grand_total'), value: 'grand_total'},
        ],
        quotations: [],
        tableLoad: false,
        productCount: 0,
        editedIndex: -1,
        taxes: [],
        quoProducts: [],
        products: [],
        vendors: [],
        quoVendors: [],
        selectVendors: [],
        selectedVendors: [],
        singleSelect: false,
        selected: [],
        deleteProduct: [],
        vendorCard: false,
        quoProduct: {
            id: '',
            product_id: '',
            product_variant_id: '',
            quantity: '',
            shipping_cost: '',
            price: '',
            tax_id: '',
            discount_type: '',
            discount: '',
            status: '',
        },
        changeProgress: false,
        validated: false,
        departments: [],
        variants: [],
        hasVariants: false,
        quotationItem: {
            id: null,
            description: '',
            location: '',
            date_of_order: '',
            requester: '',
        },
        editedItem: {
            id: null,
            comment: '',
            file: '',
            discount_type: '',
            discount: '',
            status: '',
            total_item: '',
            total_price: '',
        },
        rules: [
            value => !!value || 'Required.',
        ]
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? i18n.t('card_title.add_quotation_product') : i18n.t('card_title.edit_quotation_product')
        },
    },
    async created() {
        this.loadData();
        this.loadDepartments();
        this.loadUserName();
        this.loadVendors();
        this.loadTaxes();
        // this.loadQuoProducts();
    },
    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadDepartments() {
            let res = await ApiServices.departmentList();
            if (res.success === true) {
                this.departments = res.data;
            }
        },
        async loadTaxes() {
            let res = await ApiServices.taxList();
            if (res.success === true) {
                this.taxes = res.data;
            }
        },
        async loadData() {
            let res = await ApiServices.vendorPurchaseOrderShow(this.$route.params.id);
            if (res.success === true) {
                this.editedItem = res.data;
                this.quoProducts = res.data.purchase_order_products;
                if (this.quoProducts.length > 0) {
                    this.vendorCard = true;
                }
            }
        },
        async loadUserName() {
            let user = JSON.parse(localStorage.getItem('userData'));
            this.requested_name = user.name;
        },

        async loadVendors() {
            let res = await ApiServices.vendorList();
            if (res.success === true) {
                this.vendors = res.data;
            }
        },
        async getVariants(product) {
            let res = await ApiServices.productShow(product);
            if (res.success === true) {
                if (res.data.product_variants.length > 0) {
                    this.hasVariants = true;
                } else {
                    this.hasVariants = false;
                }
                this.variants = res.data.product_variants;
            }
        },

        deleteItem(item) {
            this.editedIndex = this.quoProducts.indexOf(item)
            this.addQuoProduct = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.quotationProductDelete(this.addQuoProduct.id);
            if (res.success === true) {
                this.quoProducts.splice(this.editedIndex, 1)
            }
            this.closeDelete()
        },

        close() {
            this.progressL = false;
            this.dialog = false;
            this.$nextTick(() => {
                this.addQuoProduct = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            });
            this.loadItems();
        },

        closeV() {
            this.progressL = false;
            this.dialogV = false;
        },

        closeDelete() {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.addQuoProduct = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        async openDialogV() {
            this.selected = this.quoVendors;
            this.dialogV = true;
            let res = await this.loadProductVendors();
        },

        async statusChange(type, item) {
            this.editedIndex = this.quoProducts.indexOf(item)
            this.quoProduct = Object.assign({}, item)
            const data = new FormData();
            data.append('status', type);
            let res = await ApiServices.vendorQuotationProductStatusUpdate(this.quoProduct.id, data);
            if (res.success === true) {
                Object.assign(this.quoProducts[this.editedIndex], res.data)
            }
        },

        async editItem(item) {
            this.editedIndex = this.quoProducts.indexOf(item)
            this.quoProduct = Object.assign({}, item)
            const data = new FormData();
            if (this.quoProduct.quantity !== null && this.quoProduct.quantity !== '') {
                data.append('quantity', this.quoProduct.quantity);
            }
            if (this.quoProduct.price !== null && this.quoProduct.price !== '') {
                data.append('price', this.quoProduct.price);
            }
            if (this.quoProduct.discount_type !== null && this.quoProduct.discount_type !== '') {
                data.append('discount_type', this.quoProduct.discount_type);
            }
            if (this.quoProduct.discount !== null && this.quoProduct.discount !== '') {
                data.append('discount', this.quoProduct.discount);
            }
            if (this.quoProduct.tax_id !== null && this.quoProduct.tax_id !== '') {
                data.append('tax_id', this.quoProduct.tax_id);
            }
            if (this.quoProduct.shipping_cost !== null && this.quoProduct.shipping_cost !== '') {
                data.append('shipping_cost', this.quoProduct.shipping_cost);
            }
            let res = await ApiServices.vendorQuotationProductUpdate(this.quoProduct.id, data);
            if (res.success === true) {
                Object.assign(this.quoProducts[this.editedIndex], res.data)
            }
        },

        async edit(status) {
            // this.validate();
            // if (this.validated) {
            this.changeProgress = true;
            const data = new FormData();
            data.append('status', status);
            var changed_status = '';
            if(status === 'Approved'){
                changed_status = 'accepted';
            }else if(status === 'Sent'){
                changed_status = 'shipped';
            }

            let res = await ApiServices.vendorPurchaseOrderEdit(this.editedItem.id, data);
            this.changeProgress = false;
            if (res.success === true) {
                this.editedItem = res.data;
                this.quoProducts = res.data.purchase_order_products;
                store.state.home.snackbar = true;
                store.state.home.snackbarText = 'Purchase Order has been '+ changed_status;
                store.state.home.snackbarColor = 'green';
                // route.replace('/vendor/purchase-orders');
            }else{
                store.state.home.snackbar = true;
                store.state.home.snackbarText = res.message;
                store.state.home.snackbarColor = 'red';
            }
            // }
        },

        async editQuoProduct() {
            this.productValidate();
            if (this.validated) {
                if (this.editedIndex > -1) {
                    //edit goes here
                    this.progressL = true;
                    const data = new FormData();
                    data.append('product_id', this.addQuoProduct.product_id);
                    if (this.addQuoProduct.product_variant_id !== null && this.addQuoProduct.product_variant_id !== '') {
                        data.append('product_variant_id', this.addQuoProduct.product_variant_id);
                    }
                    data.append('quantity', this.addQuoProduct.quantity);
                    data.append('shipping_cost', this.addQuoProduct.shipping_cost);
                    let res = await ApiServices.quotationProductEdit(this.addQuoProduct.id, data);
                    if (res.success === true) {
                        Object.assign(this.quoProducts[this.editedIndex], res.data)
                        this.$refs.form.reset();
                        this.close();
                    }
                } else {
                    //add new
                    this.progressL = true;
                    const data = new FormData();
                    data.append('product_id', this.addQuoProduct.product_id);
                    if (this.addQuoProduct.product_variant_id !== null && this.addQuoProduct.product_variant_id !== '') {
                        data.append('product_variant_id', this.addQuoProduct.product_variant_id);
                    }
                    data.append('quantity', this.addQuoProduct.quantity);
                    data.append('shipping_cost', this.addQuoProduct.shipping_cost);
                    data.append('quotation_id', this.editedItem.id);
                    let res = await ApiServices.quotationProductCreate(data);
                    if (res.success === true) {
                        this.quoProducts.push(res.data);
                        this.$refs.form.reset();
                        this.close()
                    }
                }
            }
        },

        // validate() {
        //     if (this.department_id === '') {
        //         this.validated = false;
        //     } else {
        //         this.validated = true;
        //     }
        // },

        productValidate() {
            if (this.product_id === '') {
                this.validated = false;
            } else {
                this.validated = true;
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
