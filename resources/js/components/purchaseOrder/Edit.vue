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
                                                <v-select
                                                    v-model="editedItem.dept_id"
                                                    :items="departments"
                                                    item-value="id"
                                                    item-text="name"
                                                    prepend-icon="mdi-alpha-d-circle"
                                                    :label="$t('department')"
                                                    placeholder="Select department ..."
                                                    required
                                                    :rules="rules"
                                                    persistent-hint
                                                />
                                            </v-col>
                                            <v-col md="4">
                                                <v-text-field
                                                    v-model="editedItem.requester"
                                                    prepend-icon="mdi-account"
                                                    :label="$t('requested') + ' ' + $t('name')"
                                                    placeholder="Enter requested user name..."
                                                    required
                                                    :rules="rules"
                                                    persistent-hint
                                                />
                                            </v-col>
                                            <v-col md="4">
                                                <v-text-field
                                                    v-model="editedItem.location"
                                                    prepend-icon="mdi-account"
                                                    :label="$t('location')"
                                                    placeholder="Enter location..."
                                                    required
                                                    :rules="rules"
                                                    persistent-hint
                                                />
                                            </v-col>
                                            <v-col md="4">
                                                <v-row>
                                                    <v-col v-if="typeof(editedItem.link) === 'string'">
                                                        <v-file-input
                                                            v-model="editedItem.file"
                                                            label="File"
                                                            filled
                                                            outlined
                                                            prepend-icon="mdi-camera"
                                                            accept="application/pdf,application"
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
                                                            accept="application/pdf,application"
                                                        ></v-file-input>
                                                    </v-col>
                                                </v-row>
                                            </v-col>
                                        </v-row>

                                        <v-textarea
                                            v-model="editedItem.description"
                                            type="text"
                                            :label="$t('description')"
                                            placeholder="Enter description..."
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
                                            :items="poProducts"
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
                                                                                    v-model="addPoProduct.product_id"
                                                                                    :label="$t('product')"
                                                                                    :items="products"
                                                                                    item-text="name"
                                                                                    item-value="id"
                                                                                    required
                                                                                    outlined
                                                                                    :rules="rules"
                                                                                    v-on:change="getVariants(addPoProduct.product_id)"
                                                                                ></v-select>
                                                                                <div v-if="hasVariants">
                                                                                    <v-select
                                                                                        v-model="addPoProduct.product_variant_id"
                                                                                        :label="$t('product') +' '+ $t('variant')"
                                                                                        :items="variants"
                                                                                        item-value="id"
                                                                                        item-text="name"
                                                                                        outlined
                                                                                    ></v-select>
                                                                                </div>
                                                                                <div v-if="hasVendors">
                                                                                    <v-select
                                                                                        v-model="addPoProduct.vendor_id"
                                                                                        :label="$t('vendor')"
                                                                                        :items="selectVendors"
                                                                                        item-value="id"
                                                                                        item-text="name"
                                                                                        outlined
                                                                                    ></v-select>
                                                                                </div>
                                                                                <v-text-field
                                                                                    v-model="addPoProduct.quantity"
                                                                                    :label="$t('quantity')"
                                                                                    type="number"
                                                                                    outlined
                                                                                ></v-text-field>

                                                                                <v-select
                                                                                    v-model="addPoProduct.unit_id"
                                                                                    :label="$t('unit')"
                                                                                    :items="units"
                                                                                    item-text="name"
                                                                                    item-value="id"
                                                                                    required
                                                                                    outlined
                                                                                    :rules="rules"
                                                                                ></v-select>
                                                                                <v-text-field
                                                                                    v-model="addPoProduct.shipping_cost"
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
                                                                        @click="editQuoProduct"
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
                                                <p v-if="item.shipping_cost" class="mt-3">NRs. {{
                                                        item.shipping_cost
                                                    }}</p>
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
                                            <template v-slot:item.actions="{ item }">
                                                <div v-if="editedItem.is_pending">
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
                                                </div>
                                                <div v-else>
                                                    ---
                                                </div>
                                            </template>
                                            <template v-slot:no-data>
                                                <div>No Data</div>
                                            </template>
                                        </v-data-table>
                                    </v-card>

                                    <v-dialog
                                        v-model="dialogVConfirm"
                                        max-width="850px"
                                        max-height="450px"
                                    >
                                        <v-card>
                                            <v-card-title>
                                               Check The Product List
                                                <v-spacer></v-spacer>
                                            </v-card-title>
                                            <v-data-table
                                                item-key="name"
                                                class="elevation-1"
                                                :headers="headers"
                                                :items="poProducts"
                                                sort-by="id"
                                                :loading="tableLoad"
                                                loading-text="Loading... Please wait..."
                                                :search="searchSV"
                                            >
                                                <template v-slot:top>
                                                    <v-toolbar
                                                        flat
                                                    >
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
                                                        @click="closeVConfirm"
                                                    >
                                                        {{ $t('button.cancel') }}
                                                    </v-btn>
                                                    <v-btn
                                                        color="blue darken-1"
                                                        class="btn btn-primary card-btn"
                                                        text
                                                        @click="edit"
                                                    >
                                                        {{ $t('button.submit') }}
                                                    </v-btn>
                                                </v-card-actions>
                                            </v-row>
                                        </v-card>
                                    </v-dialog>

                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="edit">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.submit') }}
                                        </CButton>
                                        <CButton size="sm" color="warning" @click="statusChange" v-if="editedItem.status === 'Sent'">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.receive') }}
                                        </CButton>
                                        <CButton :to="'/purchaseOrders'" size="sm" color="danger">
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
import store from "../../store";
import route from "../../router";
import i18n from "../../i18n";
import ApiServices from "../../services/ApiServices";
import config from "../../config";

export default {
    name: "PurchaseOrderEdit",

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
            {text: i18n.t('shipping_cost'), value: 'shipping_cost'},
            {text: i18n.t('unit'), value: 'unit_id'},
            {text: i18n.t('grand_total'), value: 'grand_total'},
            // {text: i18n.t('actions'), value: 'actions', sortable: false},
        ],
        quotations: [],
        tableLoad: false,
        productCount: 0,
        editedIndex: -1,
        poProducts: [],
        products: [],
        vendors: [],
        units: [],
        poVendors: [],
        newPoVendors: [],
        selectVendors: [],
        selectedVendors: [],
        singleSelect: false,
        selected: [],
        deleteProduct: [],
        vendorCard: false,
        addPoProduct: {
            product_id: '',
            product_variant_id: '',
            vendor_id: '',
            quantity: '',
            shipping_cost: '',
            unit_data: '',
        },
        changeProgress: false,
        validated: false,
        departments: [],
        variants: [],
        hasVariants: false,
        hasVendors: false,
        editedItem: {
            id: null,
            dept_id: '',
            file: [],
            description: '',
            location: '',
            requester: '',
            is_pending: '',
        },
        error: {
            department_id: '',
            file: [],
            description: '',
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
        let data = await this.loadData();
        let department = await this.loadDepartments();
        let item = await this.loadItems();
        let user = await this.loadUserName();
        let vendor = await this.loadVendors();
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
        async loadItems() {
            let res = await ApiServices.productIndex();
            if (res.success === true) {
                this.products = res.data;
            }
        },
        async loadData() {
            let res = await ApiServices.purchaseOrderShow(this.$route.params.id);
            if (res.success === true) {
                this.editedItem = res.data;
                this.poProducts = res.data.purchase_order_products;
                this.poVendors = res.data.vendor;
                if (res.data.is_from_purchase === 1) {
                    this.headers.unshift({
                        text: i18n.t('purchase') + ' ' + i18n.t('request'), value: 'purchase_product_id'
                    })
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
                // for (var i = 0; i < this.vendors.length; i++) {
                //     for (var j = 0; j < this.quoVendors.length; j++) {
                //         if (this.quoVendors[j].id === this.vendors[i].id) {
                //             this.vendors.slice(i, 1);
                //         }
                //     }
                // }
                let rtn = await this.filterVendors();
            }
        },

        async filterVendors() {
            for (var i = 0; i < this.vendors.length; i++) {
                for (var j = 0; j < this.poVendors.length; j++) {
                    if (this.poVendors[j].id === this.vendors[i].id) {
                        this.vendors.splice(i, 1)
                    }
                }
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
            for (let i = 0; i < this.poProducts.length; i++) {
                let res = await ApiServices.vendorProductIds('vendor', this.poProducts[i].product_id);
                if (res.success === true) {
                    this.vendor_products = res.data;
                    for (let j = 0; j < this.vendors.length; j++) {
                        for (let k = 0; k < this.vendor_products.length; k++) {
                            if (this.vendors[j].id === this.vendor_products[k].vendor_id) {
                                if (!(this.selectVendors.indexOf(this.vendors[j]) >= 0)) {
                                    if (this.vendor_products[k].status === 'Verified') {
                                        this.selectVendors.push(this.vendors[j]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        },

        editItem(item) {
            this.editedIndex = this.poProducts.indexOf(item)
            this.addPoProduct = Object.assign({}, item)
            this.getVariants(this.addPoProduct.item_id)
            this.dialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.poProducts.indexOf(item)
            this.addPoProduct = Object.assign({}, item)
            this.dialogDelete = true
        },

        deleteVItem(item) {
            this.editedIndex = this.poVendors.indexOf(item)
            this.dialogVDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.quotationProductDelete(this.addPoProduct.id);
            if (res.success === true) {
                this.poProducts.splice(this.editedIndex, 1)
            }
            this.closeDelete()
        },

        async deleteVConfirm() {
            var vendor = this.poVendors[this.editedIndex];
            var index = this.newPoVendors.indexOf(vendor);
            this.poVendors.splice(this.editedIndex, 1)
            this.newPoVendors.splice(index, 1);
            this.closeVDelete()
        },

        close() {
            this.progressL = false;
            this.dialog = false;
            this.$nextTick(() => {
                this.addPoProduct = Object.assign({}, this.defaultItem)
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
                this.addPoProduct = Object.assign({}, this.defaultItem)
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
            this.selected = this.newPoVendors;
            this.dialogV = true;
            let res = await this.loadProductVendors();
        },

        async addVendor() {
            this.newPoVendors = this.selected;
            this.selected = [];
            for (var i = 0; i < this.newPoVendors.length; i++) {
                if (this.poVendors.indexOf(this.newPoVendors[i]) < 0) {
                    this.newPoVendors[i].status = 'Additional';
                    this.poVendors.push(this.newPoVendors[i])
                }
            }
            this.dialogV = false;
        },

        closeVConfirm() {
            this.dialogVConfirm = false
        },

        async edit() {
            this.validate();
            let due = await this.checkDate('due_date', this.editedItem.due_date);
            let delivery = await this.checkDate('delivery_date', this.editedItem.desired_delivery_date);
            if ((this.deliveryDateValidation === false) && (this.dueDateValidation === false)) {
                if (this.validated) {
                    this.changeProgress = true;
                    const data = new FormData();
                    data.append('department_id', this.editedItem.department_id);
                    data.append('note', this.editedItem.note);

                    if ('file' in this.editedItem) {
                        if (typeof this.editedItem.file.name == 'string') {
                            data.append('file', this.editedItem.file);
                        }
                    }

                    data.append('products', JSON.stringify(this.poProducts));
                    data.append('vendors', JSON.stringify(this.newPoVendors));

                    let res = await ApiServices.quotationEdit(this.editedItem.id, data);
                    this.changeProgress = false;
                    if (res.success === true) {
                        route.replace('/quotations/');
                    }
                }
            }
        },

        async editQuoProduct() {
            this.productValidate();
            if (this.validated) {
                if (this.editedIndex > -1) {
                    //edit goes here
                    this.progressL = true;
                    const data = new FormData();
                    data.append('product_id', this.addPoProduct.product_id);
                    if (this.addQuoProduct.product_variant_id !== null && this.addPoProduct.product_variant_id !== '') {
                        data.append('product_variant_id', this.addPoProduct.product_variant_id);
                    }
                    data.append('quantity', this.addPoProduct.quantity);
                    data.append('shipping_cost', this.addPoProduct.shipping_cost);
                    let res = await ApiServices.quotationProductEdit(this.addPoProduct.id, data);
                    if (res.success === true) {
                        Object.assign(this.poProducts[this.editedIndex], res.data)
                        this.$refs.form.reset();
                        this.close();
                    }
                } else {
                    //add new
                    this.progressL = true;
                    const data = new FormData();
                    data.append('product_id', this.addPoProduct.product_id);
                    if (this.addQuoProduct.product_variant_id !== null && this.addPoProduct.product_variant_id !== '') {
                        data.append('product_variant_id', this.addPoProduct.product_variant_id);
                    }
                    data.append('quantity', this.addPoProduct.quantity);
                    data.append('shipping_cost', this.addPoProduct.shipping_cost);
                    data.append('quotation_id', this.editedItem.id);
                    let res = await ApiServices.quotationProductCreate(data);
                    if (res.success === true) {
                        this.poProducts.push(res.data);
                        this.$refs.form.reset();
                        this.close()
                    }
                }
            }
        },

        validate() {
            if (this.department_id === '') {
                this.validated = false;
            } else {
                this.validated = true;
            }
        },

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
