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
                                                    <v-dialog
                                                        v-model="dialog"
                                                        max-width="600px"
                                                    >
                                                        <!--                                                        <template v-slot:activator="{ on, attrs }">-->
                                                        <!--                                                            <v-btn-->
                                                        <!--                                                                color="green"-->
                                                        <!--                                                                dark-->
                                                        <!--                                                                class="mb-2"-->
                                                        <!--                                                                v-bind="attrs"-->
                                                        <!--                                                                v-on="on"-->
                                                        <!--                                                            >-->
                                                        <!--                                                                {{ $t('button.add_new_product') }}-->
                                                        <!--                                                            </v-btn>-->
                                                        <!--                                                        </template>-->
                                                        <!--                                                        <v-card>-->
                                                        <!--                                                            <v-form ref="form">-->
                                                        <!--                                                                <v-card-title>-->
                                                        <!--                                                                    <span class="headline">{{ formTitle }}</span>-->
                                                        <!--                                                                </v-card-title>-->

                                                        <!--                                                                <v-card-text>-->
                                                        <!--                                                                    <v-container>-->
                                                        <!--                                                                        <v-row>-->
                                                        <!--                                                                            <v-col>-->
                                                        <!--                                                                                <v-select-->
                                                        <!--                                                                                    v-model="addQuoProduct.product_id"-->
                                                        <!--                                                                                    :label="$t('product')"-->
                                                        <!--                                                                                    :items="products"-->
                                                        <!--                                                                                    item-text="name"-->
                                                        <!--                                                                                    item-value="id"-->
                                                        <!--                                                                                    required-->
                                                        <!--                                                                                    outlined-->
                                                        <!--                                                                                    :rules="rules"-->
                                                        <!--                                                                                    v-on:change="getVariants(addQuoProduct.product_id)"-->
                                                        <!--                                                                                ></v-select>-->
                                                        <!--                                                                                <div v-if="hasVariants">-->
                                                        <!--                                                                                    <v-select-->
                                                        <!--                                                                                        v-model="addQuoProduct.product_variant_id"-->
                                                        <!--                                                                                        :label="$t('product') +' '+ $t('variant')"-->
                                                        <!--                                                                                        :items="variants"-->
                                                        <!--                                                                                        item-text="name"-->
                                                        <!--                                                                                        item-value="id"-->
                                                        <!--                                                                                        outlined-->
                                                        <!--                                                                                    ></v-select>-->
                                                        <!--                                                                                </div>-->
                                                        <!--                                                                                <v-text-field-->
                                                        <!--                                                                                    v-model="addQuoProduct.quantity"-->
                                                        <!--                                                                                    :label="$t('quantity')"-->
                                                        <!--                                                                                    type="number"-->
                                                        <!--                                                                                    outlined-->
                                                        <!--                                                                                ></v-text-field>-->
                                                        <!--                                                                                <v-text-field-->
                                                        <!--                                                                                    v-model="addQuoProduct.shipping_cost"-->
                                                        <!--                                                                                    :label="$t('shipping_cost')"-->
                                                        <!--                                                                                    type="number"-->
                                                        <!--                                                                                    outlined-->
                                                        <!--                                                                                ></v-text-field>-->
                                                        <!--                                                                            </v-col>-->
                                                        <!--                                                                        </v-row>-->
                                                        <!--                                                                    </v-container>-->
                                                        <!--                                                                </v-card-text>-->

                                                        <!--                                                                <v-card-actions>-->
                                                        <!--                                                                    <v-progress-linear-->
                                                        <!--                                                                        v-if="progressL"-->
                                                        <!--                                                                        indeterminate-->
                                                        <!--                                                                        color="green"-->
                                                        <!--                                                                    ></v-progress-linear>-->
                                                        <!--                                                                    <v-spacer></v-spacer>-->
                                                        <!--                                                                    <v-btn-->
                                                        <!--                                                                        color="blue darken-1"-->
                                                        <!--                                                                        text-->
                                                        <!--                                                                        @click="close"-->
                                                        <!--                                                                    >-->
                                                        <!--                                                                        {{ $t('button.cancel') }}-->
                                                        <!--                                                                    </v-btn>-->
                                                        <!--                                                                    <v-btn-->
                                                        <!--                                                                        color="blue darken-1"-->
                                                        <!--                                                                        text-->
                                                        <!--                                                                        @click="editQuoProduct"-->
                                                        <!--                                                                    >-->
                                                        <!--                                                                        {{ $t('button.submit') }}-->
                                                        <!--                                                                    </v-btn>-->
                                                        <!--                                                                </v-card-actions>-->
                                                        <!--                                                            </v-form>-->
                                                        <!--                                                        </v-card>-->

                                                    </v-dialog>
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
                                                <div v-if="item.status === 'Accepted'">
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
                                                <div v-if="item.status === 'Accepted'">
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
                                                <div v-if="item.status === 'Accepted'">
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
                                                <div v-if="item.status === 'Accepted'">
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
                                                <div v-if="item.status === 'Accepted'">
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
                                                <div v-if="item.status === 'Accepted'">
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
                                            <template v-slot:item.actions="{ item }">
                                                <div v-if="item.status === 'On Progress'">
                                                    <CButton size="sm" color="success" class="m-1"
                                                             @click="statusChange('Accepted',item)">
                                                        <!--                                                        <CIcon name="cil-check-circle"/>-->
                                                        Accept
                                                    </CButton>
                                                    <CButton size="sm" class="m-1" color="danger"
                                                             @click="statusChange('Rejected',item)">
                                                        <!--                                                        <CIcon name="cil-ban"/>-->
                                                        Reject
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
                                                    <v-icon
                                                        small
                                                        class="mr-2"
                                                        @click="editItem(item)"
                                                    >
                                                        mdi-check
                                                    </v-icon>
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
                                                <v-col v-if="typeof(editedItem.link) === 'string'">
                                                    <v-file-input
                                                        v-model="editedItem.file"
                                                        label="File"
                                                        filled
                                                        outlined
                                                        prepend-icon="mdi-camera"
                                                        accept="*/application"
                                                    ></v-file-input>
                                                    <v-col width="200" class="ml-3 file-link"
                                                           v-on:click="openImage(editedItem.link)">
                                                        <h5> Open File </h5>
                                                    </v-col>
                                                </v-col>
                                                <v-col v-else>
                                                    <v-file-input
                                                        v-model="editedItem.file"
                                                        label="File"
                                                        :label="$t('file')"
                                                        filled
                                                        outlined
                                                        prepend-icon="mdi-camera"
                                                        accept="*/application"
                                                    ></v-file-input>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                        <v-col md="4">
                                            <v-select
                                                v-model="editedItem.status"
                                                :label="$t('status')"
                                                :items="['Pending','On Progress','Accepted','Approved','Rejected','Cancelled']"
                                                outlined
                                            />
                                        </v-col>
                                    </v-row>
                                    <v-textarea
                                        v-model="editedItem.comment"
                                        :label="$t('comment')"
                                        outlined
                                    />


                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="edit">
                                            <CIcon name="cil-check-circle"/>
                                            Submit
                                        </CButton>
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
            data.append('quantity', this.quoProduct.quantity);
            data.append('price', this.quoProduct.price);
            data.append('discount_type', this.quoProduct.discount_type);
            data.append('discount', this.quoProduct.discount);
            data.append('tax_id', this.quoProduct.tax_id);
            data.append('shipping_cost', this.quoProduct.shipping_cost);
            let res = await ApiServices.vendorQuotationProductUpdate(this.quoProduct.id, data);
            if (res.success === true) {
                Object.assign(this.quoProducts[this.editedIndex], res.data)
            }
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
