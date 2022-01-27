<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Edit</strong> Quotation
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
                                                <h6>{{ $t('requested') + ' ' + $t('name') }}</h6>
                                                <p>{{ quotationItem.requested_name }}</p>
                                            </v-col>
                                            <v-col md="4">
                                                <h6>{{ $t('due') + ' ' + $t('date') }}</h6>
                                                <p>{{ quotationItem.due_date }}</p>
                                            </v-col>
                                            <v-col md="4">
                                                <h6>{{ $t('desired') + ' ' + $t('delivery') + ' ' + $t('date') }}</h6>
                                                <p>{{ quotationItem.desired_delivery_date }}</p>
                                            </v-col>
                                        </v-row>
                                        <h6>{{ $t('note') }}</h6>
                                        <p>{{ quotationItem.note }}</p>
                                    </v-form>

                                    <hr>
                                    <v-card flat>
<!--                                        <v-card-title>-->
<!--                                            {{ $t('products') }}-->
<!--                                            <v-spacer></v-spacer>-->
<!--                                        </v-card-title>-->
                                        <v-data-table
                                            :headers="headers"
                                            :items="quoProducts"
                                            sort-by="id"
                                            loading
                                            loading-text="Loading... Please wait..."
                                        >
                                            <template v-slot:item.product_id="{ item }">
                                                <p v-if="item.quotation_product.product_id" class="mt-3">{{ item.quotation_product.product.name }}</p>
                                            </template>
                                            <template v-slot:item.product_variant_id="{ item }">
                                                <p v-if="item.quotation_product.product_variant_id" class="mt-3">{{
                                                    item.quotation_product.product_variant.name
                                                    }}</p>
                                                <p v-else class="mt-3">---</p>
                                            </template>
                                            <template v-slot:item.tax_id="{ item }">
                                                <p v-if="item.tax_id" class="mt-3">{{ item.tax.value }}%</p>
                                                <p v-else class="mt-3">0</p>
                                            </template>
                                            <template v-slot:item.actions="{ item }">
                                                <div v-if="item.status === 'On Progress'">
                                                    <CButton size="sm" color="secondary" class="m-1">
                                                        On Progress
                                                    </CButton>
                                                </div>
                                                <div v-if="item.status === 'Pending'">
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
                                                <div v-else>
                                                    <CButton size="sm" class="m-1" color="primary">
                                                        Accepted
                                                    </CButton>
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
                                            <h6>{{ $t('status') }}</h6>
                                            <p>{{ editedItem.status }}</p>
                                        </v-col>
                                        <v-col md="4">
                                            <v-row>
                                                <v-col v-if="typeof(editedItem.link) === 'string'">
<!--                                                    <h6>FIle</h6>-->
                                                    <v-col width="200" class="ml-3 file-link"
                                                           v-on:click="openImage(editedItem.link)">
                                                        <h5> Open File </h5>
                                                    </v-col>
                                                </v-col>
                                            </v-row>
                                        </v-col>

                                    </v-row>
                                    <div>
                                        <h6>{{ $t('comment') }}</h6>
                                        <p>{{ editedItem.comment }}</p>
                                    </div>


                                    <CCardFooter>
                                        <CButton :to="'/vendor/new-product-request'" size="sm" color="danger">
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
        name: "VendorQuotationShow",

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
                {text: i18n.t('actions'), value: 'actions', sortable: false},
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
            singleSelect: false,
            selected: [],
            deleteProduct: [],
            vendorCard: false,
            addQuoProduct: {
                product_id: '',
                product_variant_id: '',
                quantity: '',
                shipping_cost: '',
            },
            changeProgress: false,
            validated: false,
            departments: [],
            variants: [],
            hasVariants: false,
            quotationItem: {
                id: null,
                note: '',
                due_date: '',
                desired_delivery_date: '',
                requested_name: '',
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
            async loadData() {
                let res = await ApiServices.vendorQuotation(this.$route.params.id);
                if (res.success === true) {
                    this.quotationItem = res.data;
                    this.editedItem = res.data.vendor_quotation;
                    this.quoProducts = res.data.vendor_quotation_products;
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

            async loadProductVendors() {
                for (let i = 0; i < this.quoProducts.length; i++) {
                    let res = await ApiServices.vendorProductIds('vendor', this.quoProducts[i].product_id);
                    if (res.success === true) {
                        this.vendor_ids = res.data;
                        for (let j = 0; j < this.vendors.length; j++) {
                            for (let k = 0; k < this.vendor_ids.length; k++) {
                                if (this.vendors[j].id === this.vendor_ids[k]) {
                                    if (!(this.selectVendors.indexOf(this.vendors[j]) >= 0)) {
                                        this.selectVendors.push(this.vendors[j]);
                                    }
                                }
                            }
                        }
                    }
                }
            },

            editItem(item) {
                this.editedIndex = this.quoProducts.indexOf(item)
                this.addQuoProduct = Object.assign({}, item)
                this.getVariants(this.addQuoProduct.item_id)
                this.dialog = true
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
