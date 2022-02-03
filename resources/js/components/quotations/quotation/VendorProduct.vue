<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Vendor</strong> Quotation
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
                                            <v-col md="9">
                                                <v-row>
                                                    <v-col md="4">
                                                        <h6>{{ $t('desired') + ' ' + $t('delivery') + ' ' + $t('date')
                                                            }}</h6>
                                                        <p>{{ editedItem.desired_delivery_date }}</p>
                                                    </v-col>
                                                    <v-col md="4">
                                                        <h6>{{ $t('due') +' '+ $t('date') }}</h6>
                                                        <p>{{ editedItem.due_date }}</p>
                                                    </v-col>
                                                    <v-col md="4">
                                                        <h6>{{ $t('requester') }}</h6>
                                                        <p>{{ editedItem.requested_name }}</p>
                                                    </v-col>
                                                </v-row>
                                                <div>
                                                    <h6>{{ $t('details') }}</h6>
                                                    <p v-if="editedItem.note">{{ editedItem.note }}</p>
                                                    <p v-else>----</p>
                                                </div>
                                            </v-col>
                                            <v-col md-3>
                                                <v-card>
                                                    <v-card-title class="status-card-title">
                                                        <v-row>
                                                            <h6 class="status-title"> Quotation is </h6>
                                                            <div v-if="quotationItem.status === 'On Progress'">
                                                                <CButton size="sm" color="warning">
                                                                    {{ quotationItem.status }}
                                                                </CButton>
                                                            </div>
                                                            <div v-else-if="quotationItem.status === 'Pending'">
                                                                <CButton size="sm" color="secondary">
                                                                    {{ quotationItem.status }}
                                                                </CButton>
                                                            </div>
                                                            <div v-else-if="quotationItem.status === 'Rejected'">
                                                                <CButton size="sm" color="danger"
                                                                >
                                                                    {{ quotationItem.status }}
                                                                </CButton>
                                                            </div>
                                                            <div v-else-if="quotationItem.status === 'Cancelled'">
                                                                <CButton size="sm" color="danger"
                                                                >
                                                                    {{ quotationItem.status }}
                                                                </CButton>
                                                            </div>
                                                            <div v-else-if="quotationItem.status === 'Approved'">
                                                                <CButton size="sm" color="success"
                                                                >
                                                                    {{ quotationItem.status }}
                                                                </CButton>
                                                            </div>
                                                            <div v-else-if="quotationItem.status === 'Accepted'">
                                                                <CButton size="sm" color="primary">
                                                                    {{ quotationItem.status }}
                                                                </CButton>
                                                            </div>
                                                            <div v-else>
                                                                <CButton size="sm" color="warning">
                                                                    {{ quotationItem.status }}
                                                                </CButton>
                                                            </div>
                                                            .
                                                        </v-row>
                                                    </v-card-title>

                                                    <v-card-text>
                                                        <v-container class="mt-1">
                                                            <h6>What do you want to do?</h6>
                                                            <v-row class="mt-1 ml-1">
                                                                <div
                                                                    v-if="(quotationItem.status === 'Accepted') || (quotationItem.status === 'Pending') || (quotationItem.status === 'Review') || (quotationItem.status === 'Reviewed')">
                                                                    <CButton size="sm" class="m-1" color="success"
                                                                             @click="allStatusChange('Approved',quotationItem.id)"
                                                                    >
                                                                        Approve
                                                                    </CButton>
                                                                </div>
                                                                <div
                                                                    v-if="(quotationItem.status === 'Accepted') || (quotationItem.status === 'Pending') || (quotationItem.status === 'Review') || (quotationItem.status === 'Reviewed') || (quotationItem.status === 'On Progress')">
                                                                    <CButton size="sm" class="m-1" color="danger"
                                                                             @click="allStatusChange('Cancelled',quotationItem.id)"
                                                                    >
                                                                        Cancel
                                                                    </CButton>
                                                                </div>
                                                            </v-row>
                                                        </v-container>
                                                    </v-card-text>
                                                </v-card>
                                            </v-col>
                                        </v-row>
                                    </v-form>

                                    <hr>
                                    <v-card flat>
                                        <v-data-table
                                            :headers="headers"
                                            :items="quoProducts"
                                            sort-by="id"
                                            loading
                                            loading-text="Loading... Please wait..."
                                        >
                                            <template v-slot:item.product_id="{ item }">
                                                <p v-if="item.quotation_product.product_id" class="mt-3">
                                                    {{ item.quotation_product.product.name }}</p>
                                            </template>
                                            <template v-slot:item.product_variant_id="{ item }">
                                                <p v-if="item.quotation_product.product_variant_id" class="mt-3">{{
                                                    item.quotation_product.product_variant.name
                                                    }}</p>
                                                <p v-else class="mt-3">---</p>
                                            </template>
                                            <template v-slot:item.quantity="{ item }">
                                                <div v-if="item.status === 'Review'">
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
                                                <div v-if="item.status === 'Review'">
                                                    <v-text-field
                                                        v-model="item.price"
                                                        placeholder="Enter price"
                                                        class="mt-2"
                                                    ></v-text-field>
                                                </div>
                                                <div v-else>
                                                    <p class="mt-3" v-if="item.price">{{ item.price }}</p>
                                                    <p class="mt-3" v-else>---</p>
                                                </div>
                                            </template>
                                            <template v-slot:item.shipping_cost="{ item }">
                                                <div v-if="item.status === 'Review'">
                                                    <v-text-field
                                                        v-model="item.shipping_cost"
                                                        placeholder="Enter shipping cost"
                                                        class="mt-2"
                                                    ></v-text-field>
                                                </div>
                                                <div v-else>
                                                    <p class="mt-3" v-if="item.shipping_cost">{{
                                                        item.shipping_cost
                                                        }}</p>
                                                    <p class="mt-3" v-else>---</p>
                                                </div>
                                            </template>
                                            <template v-slot:item.tax_id="{ item }">
                                                <div v-if="item.status === 'Review'">
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
                                                <div v-if="item.status === 'Review'">
                                                    <v-text-field
                                                        v-model="item.discount"
                                                        placeholder="Enter discount"
                                                        class="mt-2"
                                                    ></v-text-field>
                                                </div>
                                                <div v-else>
                                                    <p class="mt-3" v-if="item.discount">{{ item.discount }}</p>
                                                    <p class="mt-3" v-else>---</p>
                                                </div>
                                            </template>
                                            <template v-slot:item.discount_type="{ item }">
                                                <div v-if="item.status === 'Review'">
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
                                            <template v-slot:item.status="{ item }">
                                                <div v-if="item.status === 'On Progress'">
                                                    <CButton size="sm" color="warning" class="m-1">
                                                        On Progress
                                                    </CButton>
                                                </div>
                                                <div v-if="item.status === 'Review'">
                                                    <CButton size="sm" color="warning" class="m-1">
                                                        Review
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
                                                <div v-else-if="item.status === 'Reviewed'">
                                                    <CButton size="sm" class="m-1" color="primary">
                                                        Reviewed
                                                    </CButton>
                                                </div>
                                            </template>
                                            <template v-slot:item.actions="{ item }">
                                                <div class="text-center">
                                                    <v-menu offset-y>
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-icon
                                                                small
                                                                v-bind="attrs"
                                                                v-on="on"
                                                            >
                                                                mdi-dots-vertical
                                                            </v-icon>
                                                        </template>
                                                        <v-list>
                                                            <v-list-item
                                                            >
                                                                <div
                                                                    v-if="(item.status === 'Accepted') || (item.status === 'Reviewed')">
                                                                    <v-list-item-title
                                                                        @click="statusChange('Review',item)"
                                                                        class="password-btn">Review
                                                                    </v-list-item-title>
                                                                    <hr>
                                                                    <v-list-item-title
                                                                        @click="statusChange('Approved',item)"
                                                                        class="password-btn">
                                                                        Approve
                                                                    </v-list-item-title>
                                                                    <hr>
                                                                    <v-list-item-title
                                                                        @click="statusChange('Cancelled',item)"
                                                                        class="password-btn">
                                                                        Cancelled
                                                                    </v-list-item-title>
                                                                </div>
                                                                <div
                                                                    v-else-if="item.status === 'Review'">
                                                                    <v-list-item-title
                                                                        @click="editItem(item)"
                                                                        class="password-btn">
                                                                        Edit
                                                                    </v-list-item-title>
                                                                    <hr>
                                                                    <v-list-item-title
                                                                        @click="statusChange('Cancelled',item)"
                                                                        class="password-btn">
                                                                        Cancel
                                                                    </v-list-item-title>
                                                                </div>
                                                                <div
                                                                    v-else-if="(item.status === 'On Progress') || (item.status === 'Pending')">
                                                                    <v-list-item-title
                                                                        @click="statusChange('Cancelled',item)"
                                                                        class="password-btn">
                                                                        Cancel
                                                                    </v-list-item-title>
                                                                </div>
                                                                <div v-else>
                                                                    <v-list-item-title>
                                                                        No Actions
                                                                    </v-list-item-title>
                                                                </div>
                                                            </v-list-item>
                                                        </v-list>
                                                    </v-menu>
                                                </div>
                                            </template>
                                            <template v-slot:no-data>
                                                <div>No Data</div>
                                            </template>
                                        </v-data-table>
                                    </v-card>

                                    <hr>
                                    <v-row>
                                        <v-col md="4">
                                            <v-row>
                                                <v-col v-if="typeof(quotationItem.link) === 'string'">
                                                    <h6>FIle</h6>
                                                    <CButton size="sm" color="primary" class="m-1"
                                                             v-on:click="openImage(quotationItem.link)">
                                                        Open File
                                                    </CButton>
                                                </v-col>
                                            </v-row>
                                        </v-col>

                                    </v-row>
                                    <div>
                                        <h6>{{ $t('comment') }}</h6>
                                        <p v-if="quotationItem.comment">{{ quotationItem.comment }}</p>
                                        <p v-else>----</p>
                                    </div>

                                    <CCardFooter>
                                        <CButton :to="'/quotations/edit/'+$route.params.id" size="sm" color="danger">
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
        name: "VendorProduct",

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
                {text: i18n.t('tax'), value: 'tax_id'},
                {text: i18n.t('discount') + ' ' + i18n.t('type'), value: 'discount_type'},
                {text: i18n.t('discount'), value: 'discount'},
                {text: i18n.t('shipping_cost'), value: 'shipping_cost'},
                {text: i18n.t('status'), value: 'status', sortable: true},
                {text: i18n.t('action'), value: 'actions', sortable: false},
            ],
            quotations: [],
            tableLoad: false,
            productCount: 0,
            editedIndex: -1,
            quoProducts: [],
            products: [],
            vendors: [],
            quoVendors: [],
            selectVendors: [],
            selectedVendors: [],
            taxes: [],
            singleSelect: false,
            selected: [],
            deleteProduct: [],
            vendorCard: false,
            quoProduct: {
                id: null,
                product_id: '',
                product_variant_id: '',
                quantity: '',
                shipping_cost: '',
                discount_type: '',
                discount: '',
                tax_id: '',
                price: '',
            },
            changeProgress: false,
            validated: false,
            departments: [],
            variants: [],
            hasVariants: false,
            quotationItem: {
                comment: '',
                file: '',
                discount_type: '',
                discount: '',
                status: '',
                total_item: '',
                total_price: '',
            },
            editedItem: {
                id: null,
                due_date: '',
                desired_delivery_date: '',
                requested_name: '',
                details: '',
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
            this.loadTax();
            // this.loadQuoProducts();
        },
        methods: {
            openImage(data) {
                window.open(config.cdnURL + data, `_blank`);
            },
            async loadData() {
                let rtn = await ApiServices.quotationShow(this.$route.params.id);
                if (rtn.success === true) {
                    this.editedItem = rtn.data;
                }
                let res = await ApiServices.vendorQuotationDetails(this.$route.params.id, this.$route.params.vendor);
                if (res.success === true) {
                    this.quotationItem = res.data;
                    this.quoProducts = res.data.vendor_quotation_products;
                }
            },
            async loadTax() {
                let rtn = await ApiServices.taxList();
                if (rtn.success === true) {
                    this.taxes = rtn.data;
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

            async allStatusChange(type, id) {
                const data = new FormData();
                data.append('status', type);
                let res = await ApiServices.vendorQuotationStatusUpdate(id, data);
                if (res.success === true) {
                    this.quotationItem = res.data;
                    this.quoProducts = [];
                    this.quoProducts = res.vendor_quotation_products;
                }
            },

            editItem(item) {
                this.editedIndex = this.quoProducts.indexOf(item)
                this.quoProduct = Object.assign({}, item)
                this.editQuoProduct();
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

            async edit() {
                // this.validate();
                // if (this.validated) {
                this.changeProgress = true;
                const data = new FormData();
                data.append('status', this.editedItem.status);
                data.append('comment', this.editedItem.comment);

                if ('file' in this.editedItem) {
                    if (typeof this.editedItem.file.name == 'string') {
                        data.append('file', this.editedItem.file);
                    }
                }

                let res = await ApiServices.vendorQuotationUpdate(this.editedItem.id, data);
                this.changeProgress = false;
                if (res.success === true) {
                    route.replace('/vendor/new-product-request');
                }
                // }
            },


            async editQuoProduct() {
                this.productValidate();
                if (this.validated) {
                    //edit goes here
                    const data = new FormData();
                    if (this.quoProduct.tax_id !== null && this.quoProduct.tax_id !== '') {
                        data.append('tax_id', this.quoProduct.tax_id);
                    }
                    data.append('quantity', this.quoProduct.quantity);
                    data.append('price', this.quoProduct.price);
                    data.append('discount', this.quoProduct.discount);
                    data.append('discount_type', this.quoProduct.discount_type);
                    data.append('shipping_cost', this.quoProduct.shipping_cost);
                    let res = await ApiServices.vendorQuotationProductEdit(this.quoProduct.id, data);
                    if (res.success === true) {
                        Object.assign(this.quoProducts[this.editedIndex], res.data)
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

    .password-btn {
        cursor: pointer;
    }

    .status-title {
        margin-top: 8px !important;
        margin-left: 3px !important;
        margin-right: 3px !important;
    }

    .status-card-title {
        background-color: #efebea !important;
    }
</style>
