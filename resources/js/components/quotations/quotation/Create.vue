<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>{{ $t('card_title.add_quotation') }}</strong>
                                <v-progress-circular
                                    v-if="createProgress"
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
                                                <v-select
                                                    v-model="department_id"
                                                    :items="departments"
                                                    item-value="id"
                                                    item-text="name"
                                                    prepend-icon="mdi-alpha-d-circle"
                                                    :label="$t('department')"
                                                    placeholder="Select department ..."
                                                    required
                                                    :rules="rules"
                                                    solo
                                                />
                                            </v-col>
                                            <v-col md="4">
                                                <v-text-field
                                                    type="date"
                                                    v-model="due_date"
                                                    prepend-icon="mdi-alpha-d-circle"
                                                    :label="$t('due') + ' ' + $t('date')"
                                                    placeholder="Select due date..."
                                                    required
                                                    :rules="rules"
                                                    solo
                                                />
                                            </v-col>
                                            <v-col md="4">
                                                <v-text-field
                                                    type="date"
                                                    v-model="desired_delivery_date"
                                                    prepend-icon="mdi-alpha-d-circle"
                                                    :label="$t('desired') + ' ' + $t('delivery') + ' ' + $t('date')"
                                                    placeholder="Select due date..."
                                                    required
                                                    :rules="rules"
                                                    solo
                                                />
                                            </v-col>
                                            <v-col md="4">
                                                <v-text-field
                                                    v-model="requested_name"
                                                    prepend-icon="mdi-alpha-d-circle"
                                                    :label="$t('requested') + ' ' + $t('name')"
                                                    placeholder="Enter requested user name..."
                                                    required
                                                    :rules="rules"
                                                    solo
                                                />
                                            </v-col>
                                            <v-col md="4">
                                                <v-file-input
                                                    v-model="file"
                                                    :label="$t('file')"
                                                    filled
                                                    outlined
                                                    prepend-icon="mdi-camera"
                                                    accept="*/application"
                                                ></v-file-input>
                                            </v-col>
                                        </v-row>

                                        <v-textarea
                                            v-model="note"
                                            type="text"
                                            :label="$t('note')"
                                            placeholder="Enter quotation note..."
                                            solo
                                        />
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
                                            sort-by="item_name"
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
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-btn
                                                                color="green"
                                                                dark
                                                                class="mb-2"
                                                                v-bind="attrs"
                                                                v-on="on"
                                                            >
                                                                {{ $t('button.add_new_product') }}
                                                            </v-btn>
                                                        </template>
                                                        <v-card>
                                                            <v-form ref="form">
                                                                <v-card-title>
                                                                    <span class="headline">{{ formTitle }}</span>
                                                                </v-card-title>

                                                                <v-card-text>
                                                                    <v-container>
                                                                        <v-row>
                                                                            <v-col>
                                                                                <v-select
                                                                                    v-model="addQuoProduct.product_id"
                                                                                    :label="$t('product')"
                                                                                    :items="products"
                                                                                    item-text="name"
                                                                                    item-value="id"
                                                                                    required
                                                                                    outlined
                                                                                    :rules="rules"
                                                                                    v-on:change="getVariants(addQuoProduct.product_id)"
                                                                                ></v-select>
                                                                                <div v-if="hasVariants">
                                                                                    <v-select
                                                                                        v-model="addQuoProduct.product_variant_id"
                                                                                        :label="$t('product') +' '+ $t('variant')"
                                                                                        :items="variants"
                                                                                        item-value="id"
                                                                                        item-text="name"
                                                                                        outlined
                                                                                    ></v-select>
                                                                                </div>
                                                                                <v-text-field
                                                                                    v-model="addQuoProduct.quantity"
                                                                                    :label="$t('quantity')"
                                                                                    type="number"
                                                                                    outlined
                                                                                ></v-text-field>
                                                                                <v-text-field
                                                                                    v-model="addQuoProduct.shipping_cost"
                                                                                    :label="$t('shipping_cost')"
                                                                                    type="number"
                                                                                    outlined
                                                                                ></v-text-field>
                                                                            </v-col>
                                                                        </v-row>
                                                                    </v-container>
                                                                </v-card-text>

                                                                <v-card-actions>
                                                                    <v-progress-linear
                                                                        v-if="progressL"
                                                                        indeterminate
                                                                        color="green"
                                                                    ></v-progress-linear>
                                                                    <v-spacer></v-spacer>
                                                                    <v-btn
                                                                        color="blue darken-1"
                                                                        text
                                                                        @click="close"
                                                                    >
                                                                        {{ $t('button.cancel') }}
                                                                    </v-btn>
                                                                    <v-btn
                                                                        color="blue darken-1"
                                                                        text
                                                                        @click="addProduct"
                                                                    >
                                                                        {{ $t('button.submit') }}
                                                                    </v-btn>
                                                                </v-card-actions>
                                                            </v-form>
                                                        </v-card>
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
                                            <template v-slot:item.actions="{ item }">
                                                <v-icon
                                                    small
                                                    class="mr-2"
                                                    @click="editItem(item)"
                                                >
                                                    mdi-pencil
                                                </v-icon>
                                                <v-icon
                                                    small
                                                    @click="deleteItem(item)"
                                                >
                                                    mdi-delete
                                                </v-icon>
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
                                                    <v-dialog
                                                        v-model="dialogV"
                                                        max-width="850px"
                                                        max-height="450px"
                                                    >
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-btn
                                                                color="green"
                                                                dark
                                                                class="mb-2"
                                                                v-bind="attrs"
                                                                v-on="on"
                                                                @click="openDialogV"
                                                            >
                                                                {{ $t('button.add_new_vendor') }}
                                                            </v-btn>
                                                        </template>
                                                        <v-card>
                                                            <v-card-title>
                                                                {{ $t('vendors') }}
                                                                <v-spacer></v-spacer>
                                                            </v-card-title>
                                                            <v-data-table
                                                                v-model="selected"
                                                                :single-select="singleSelect"
                                                                item-key="name"
                                                                show-select
                                                                class="elevation-1"
                                                                :headers="headersSV"
                                                                :items="selectVendors"
                                                                sort-by="id"
                                                                :loading="tableLoad"
                                                                loading-text="Loading... Please wait..."
                                                                :search="searchSV"
                                                            >
                                                                <template v-slot:top>
                                                                    <v-toolbar
                                                                        flat
                                                                    >
                                                                        <v-row>
                                                                            <v-col
                                                                                cols="12"
                                                                                sm="2"
                                                                                md="3"
                                                                                lg="4"
                                                                            >
                                                                                <v-switch
                                                                                    v-model="singleSelect"
                                                                                    label="Single select"
                                                                                    class="pa-3"
                                                                                ></v-switch>
                                                                            </v-col>
                                                                            <v-col
                                                                                cols="12"
                                                                                sm="4"
                                                                                md="6"
                                                                                lg="8"
                                                                            >
                                                                                <v-text-field
                                                                                    v-model="searchSV"
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
                                                                <template v-slot:no-data>
                                                                    <div>No Data</div>
                                                                </template>
                                                            </v-data-table>
                                                            <v-row class="m-4 d-flex justify-content-end">
                                                                <v-card-actions>
                                                                    <v-btn
                                                                        color="blue darken-1"
                                                                        class="btn btn-danger card-btn"
                                                                        text
                                                                        @click="closeV"
                                                                    >
                                                                        {{ $t('button.cancel') }}
                                                                    </v-btn>
                                                                    <v-btn
                                                                        color="blue darken-1"
                                                                        class="btn btn-primary card-btn"
                                                                        text
                                                                        @click="addVendor"
                                                                    >
                                                                        {{ $t('button.submit') }}
                                                                    </v-btn>
                                                                </v-card-actions>
                                                            </v-row>
                                                        </v-card>
                                                    </v-dialog>
                                                    <v-dialog v-model="dialogVDelete" max-width="500px">
                                                        <v-card>
                                                            <v-card-title class="text-h6">
                                                                {{ $t('message.delete') }}
                                                            </v-card-title>
                                                            <v-card-actions>
                                                                <v-spacer></v-spacer>
                                                                <v-btn color="blue darken-1" text @click="closeVDelete">
                                                                    {{ $t('button.cancel') }}
                                                                </v-btn>
                                                                <v-btn color="blue darken-1" text
                                                                       @click="deleteVConfirm">
                                                                    {{ $t('button.submit') }}
                                                                </v-btn>
                                                                <v-spacer></v-spacer>
                                                            </v-card-actions>
                                                        </v-card>
                                                    </v-dialog>
                                                </v-toolbar>
                                            </template>
                                            <template v-slot:item.actions="{ item }">
                                                <v-icon
                                                    small
                                                    @click="deleteVItem(item)"
                                                >
                                                    mdi-delete
                                                </v-icon>
                                            </template>
                                            <template v-slot:no-data>
                                                <div>No Data</div>
                                            </template>
                                        </v-data-table>
                                    </v-card>

                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="create">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.submit') }}
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/quotations/'">
                                            <CIcon name="cil-ban"/>
                                            {{ $t('button.cancel') }}
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
    name: "QuotationCreate",

    props: {
        source: String,
    },
    data: () => ({
        cdnURL: config.cdnURL,
        createProgress: false,
        search: '',
        searchV: '',
        searchSV: '',
        progressL: false,
        dialog: false,
        dialogV: false,
        dialogDelete: false,
        dialogVDelete: false,
        headers: [
            {text: i18n.t('product'), value: 'product_name'},
            {text: i18n.t('product') + ' ' + i18n.t('variant'), value: 'product_variant'},
            {text: i18n.t('quantity'), value: 'quantity'},
            {text: i18n.t('shipping_cost'), value: 'shipping_cost'},
            {text: i18n.t('actions'), value: 'actions', sortable: false},
        ],
        headersV: [
            {text: i18n.t('name'), value: 'name'},
            {text: i18n.t('email'), value: 'email'},
            {text: i18n.t('company_name'), value: 'company_name'},
            {text: i18n.t('mobile'), value: 'mobile'},
            {text: i18n.t('actions'), value: 'actions', sortable: false},
        ],
        headersSV: [
            {text: i18n.t('name'), value: 'name'},
            {text: i18n.t('email'), value: 'email'},
            {text: i18n.t('company_name'), value: 'company_name'},
            {text: i18n.t('mobile'), value: 'mobile'},
        ],
        quotations: [],
        tableLoad: false,
        hasVariants: false,
        department_id: '',
        due_date: '',
        desired_delivery_date: '',
        requested_name: '',
        file: [],
        note: '',
        departments: [],
        productCount: 0,
        editedIndex: -1,
        quoProducts: [],
        vendors: [],
        quoVendors: [],
        products: [],
        selectVendors: [],
        selectedVendors: [],
        variants: [],
        singleSelect: false,
        selected: [],
        deleteProduct: [],
        vendorCard: false,
        addQuoProduct: {
            product_id: '',
            product_variant_id: '',
            quantity: '',
        },
        productQuo: {
            product_id: '',
            product_variant_id: '',
            quantity: '',
        },
        error: {
            department_id: '',
            file: [],
            note: '',
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
        this.loadDepartments();
        this.loadItems();
        this.loadUserName();
        this.loadVendors();
    },
    methods: {
        async loadDepartments() {
            let res = await ApiServices.departmentList();
            if (res.success === true) {
                this.departments = res.data;
            }
        },

        async loadItems() {
            let res = await ApiServices.productList();
            if (res.success === true) {
                this.products = res.data;
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

        editItem(item) {
            this.editedIndex = this.quoProducts.indexOf(item)
            this.addQuoProduct = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.quoProducts.indexOf(item)
            this.addQuoProduct = Object.assign({}, item)
            this.dialogDelete = true
        },

        deleteVItem(item) {
            this.editedIndex = this.quoVendors.indexOf(item)
            this.dialogVDelete = true
        },

        async deleteItemConfirm() {
            this.deleteProduct = this.quoProducts[this.editedIndex];
            this.quoProducts.splice(this.editedIndex, 1)
            let ven = await this.loadProductVendors();
            // let res = await this.deleteProductVendor();
            this.closeDelete()
        },

        async deleteVConfirm() {
            this.quoVendors.splice(this.editedIndex, 1)
            this.closeVDelete()
        },

        // async deleteProductVendor() {
        //     let vendors = [];
        //     console.log('after', vendors)
        //     for (let j = 0; j < this.quoVendors.length; j++) {
        //         for (let k = 0; k < this.selectVendors.length; k++) {
        //             if (this.quoVendors[j].id === this.selectVendors[k].id) {
        //                 if (!(vendors.indexOf(this.quoVendors[j]) >= 0)) {
        //                     vendors.push(this.quoVendors[j]);
        //                 }
        //             }
        //         }
        //     }
        //     this.quoVendors = vendors;
        // },

        async setSelectedVendors() {
            this.selectedVendors = Object.assign({}, this.quoVendors);
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

        closeVDelete() {
            this.dialogVDelete = false
            this.$nextTick(() => {
                this.editedIndex = -1
            })
        },

        async openDialogV() {
            this.selected = this.quoVendors;
            this.dialogV = true;
            let res = await this.loadProductVendors();
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

        async addVendor() {
            this.quoVendors = this.selected;
            this.selected = [];
            this.dialogV = false;
        },

        async addProduct() {
            var varName = '---';
            let res = await ApiServices.productShow(this.addQuoProduct.product_id);
            if (this.addQuoProduct.product_variant_id) {
                let rtn = await ApiServices.productVariantShow(this.addQuoProduct.product_variant_id);
                varName = rtn.data.name;
            }
            if (this.editedIndex > -1) {
                Object.assign(this.quoProducts[this.editedIndex], {
                    'product_id': this.addQuoProduct.product_id,
                    'product_name': res.data.name,
                    'product_variant': varName,
                    'product_variant_id': this.addQuoProduct.product_variant_id,
                    'quantity': this.addQuoProduct.quantity,
                    // 'shipping_cost': this.addQuoProduct.shipping_cost,
                })
            } else {
                this.quoProducts.push({
                    'product_id': this.addQuoProduct.product_id,
                    'product_name': res.data.name,
                    'product_variant_id': this.addQuoProduct.product_variant_id,
                    'product_variant': varName,
                    'quantity': this.addQuoProduct.quantity,
                    // 'shipping_cost': this.addQuoProduct.shipping_cost,
                });
            }
            if (this.quoProducts.length > 0) {
                this.vendorCard = true;
            }
            this.$refs.form.reset();
            this.close()
        },

        async create() {
            this.validate();
            if (this.validated) {
                this.createProgress = true;
                const data = new FormData();
                data.append('note', this.note);
                data.append('department_id', this.department_id);
                data.append('due_date', this.due_date);
                data.append('desired_delivery_date', this.desired_delivery_date);
                data.append('requested_name', this.requested_name);

                if (typeof this.file.name == 'string') {
                    data.append('file', this.file);
                }

                let res = await ApiServices.quotationCreate(data);
                this.createProgress = false;
                if (res.success === true) {
                    if (this.quoProducts.length > 0) {
                        await this.createProduct(res.data.id);
                        await this.createProductVendor(res.data.id);
                    } else {
                        route.replace('/quotations/');
                    }
                }
            }
        },

        async createProduct(id) {
            for (var i = 0; i < this.quoProducts.length; i++) {
                let productData = new FormData();
                productData.append('product_id', parseInt(this.quoProducts[i].product_id));
                productData.append('quantity', parseInt(this.quoProducts[i].quantity));
                productData.append('quotation_id', parseInt(id));
                // if(this.quoProducts[i].shipping_cost !== null && this.quoProducts[i].shipping_cost !== '' && typeof(parseInt(this.quoProducts[i].shipping_cost) === 'integer')) {
                //     productData.append('shipping_cost', parseInt(this.quoProducts[i].shipping_cost));
                // }
                if (this.quoProducts[i].product_variant_id !== '') {
                    productData.append('product_variant_id', parseInt(this.quoProducts[i].product_variant_id));
                }
                let res = await ApiServices.quotationProductCreate(productData);
            }
            // route.replace('/quotations/');
        },

        async createProductVendor(id) {
            let data = new FormData();
            data.append('quotation_id', parseInt(id));
            data.append('products', JSON.stringify(this.quoProducts));
            data.append('vendors', JSON.stringify(this.quoVendors));
            let res = await ApiServices.vendorQuotationCreate(data);
            if (res.success === true) {
                route.replace()
            }
        },

        validate() {
            if (this.department_id === '') {
                this.validated = false;
            } else {
                this.validated = true;
            }
        },
    }
}
</script>
<style scoped>
.card-btn {
    color: #fff !important;
    margin-left: 3px !important;
}
</style>
