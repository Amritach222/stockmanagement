<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Add New Purchase Order</strong>
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
                                                    persistent-hint
                                                    prepend-icon="mdi-alpha-d-circle"
                                                    :label="$t('department')"
                                                    placeholder="Select department ..."
                                                    required
                                                    :rules="rules"
                                                />
                                            </v-col>
                                            <!--                                            <v-col md="4">-->
                                            <!--                                                <v-menu-->
                                            <!--                                                    ref="menu1"-->
                                            <!--                                                    v-model="menu1"-->
                                            <!--                                                    :close-on-content-click="false"-->
                                            <!--                                                    transition="scale-transition"-->
                                            <!--                                                    offset-y-->
                                            <!--                                                    max-width="290px"-->
                                            <!--                                                    min-width="auto"-->
                                            <!--                                                >-->
                                            <!--                                                    <template v-slot:activator="{ on, attrs }">-->
                                            <!--                                                        <v-text-field-->
                                            <!--                                                            v-model="due_date"-->
                                            <!--                                                            :label="$t('due') + ' ' + $t('date')"-->
                                            <!--                                                            persistent-hint-->
                                            <!--                                                            prepend-icon="mdi-calendar"-->
                                            <!--                                                            v-bind="attrs"-->
                                            <!--                                                            v-on="on"-->
                                            <!--                                                        ></v-text-field>-->
                                            <!--                                                    </template>-->
                                            <!--                                                    <v-date-picker-->
                                            <!--                                                        v-model="due_date"-->
                                            <!--                                                        no-title-->
                                            <!--                                                        @input="menu1 = false"-->
                                            <!--                                                        v-on:change="checkDate('due_date',due_date)"-->
                                            <!--                                                    ></v-date-picker>-->
                                            <!--                                                </v-menu>-->
                                            <!--                                                &lt;!&ndash;                                                <v-text-field&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                    type="date"&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                    v-model="due_date"&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                    prepend-icon="mdi-alarm-check"&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                    :label="$t('due') + ' ' + $t('date')"&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                    placeholder="Select due date..."&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                    required&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                    :rules="rules"&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                    solo&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                    v-on:change="checkDate('due_date',due_date)"&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                />&ndash;&gt;-->
                                            <!--                                                <p v-if="dueDateValidation" class="date-validation">Please select a due-->
                                            <!--                                                    date after the date of today.</p>-->
                                            <!--                                            </v-col>-->
                                            <!--                                            <v-col md="4">-->
                                            <!--                                                <v-menu-->
                                            <!--                                                    ref="menu2"-->
                                            <!--                                                    v-model="menu2"-->
                                            <!--                                                    :close-on-content-click="false"-->
                                            <!--                                                    transition="scale-transition"-->
                                            <!--                                                    offset-y-->
                                            <!--                                                    max-width="290px"-->
                                            <!--                                                    min-width="auto"-->
                                            <!--                                                >-->
                                            <!--                                                    <template v-slot:activator="{ on, attrs }">-->
                                            <!--                                                        <v-text-field-->
                                            <!--                                                            v-model="desired_delivery_date"-->
                                            <!--                                                            :label="$t('desired') + ' ' + $t('delivery') + ' ' + $t('date')"-->
                                            <!--                                                            persistent-hint-->
                                            <!--                                                            prepend-icon="mdi-calendar"-->
                                            <!--                                                            v-bind="attrs"-->
                                            <!--                                                            v-on="on"-->
                                            <!--                                                        ></v-text-field>-->
                                            <!--                                                    </template>-->
                                            <!--                                                    <v-date-picker-->
                                            <!--                                                        v-model="desired_delivery_date"-->
                                            <!--                                                        no-title-->
                                            <!--                                                        @input="menu2 = false"-->
                                            <!--                                                        v-on:change="checkDate('desired_delivery_date',desired_delivery_date)"-->
                                            <!--                                                    ></v-date-picker>-->
                                            <!--                                                </v-menu>-->
                                            <!--                                                &lt;!&ndash;                                                <v-text-field&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                    type="date"&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                    v-model="desired_delivery_date"&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                    prepend-icon="mdi-briefcase-variant"&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                    :label="$t('desired') + ' ' + $t('delivery') + ' ' + $t('date')"&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                    placeholder="Select due date..."&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                    required&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                    :rules="rules"&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                    solo&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                    v-on:change="checkDate('delivery_date',desired_delivery_date)"&ndash;&gt;-->
                                            <!--                                                &lt;!&ndash;                                                />&ndash;&gt;-->
                                            <!--                                                <p v-if="deliveryDateValidation" class="date-validation">Please select a-->
                                            <!--                                                    desired delivery date after the date of today.</p>-->
                                            <!--                                            </v-col>-->
                                            <v-col md="4">
                                                <v-text-field
                                                    v-model="requested_name"
                                                    prepend-icon="mdi-account"
                                                    :label="$t('requested') + ' ' + $t('name')"
                                                    placeholder="Enter requested user name..."
                                                    required
                                                    persistent-hint
                                                    :rules="rules"
                                                />
                                            </v-col>
                                            <v-col md="4">
                                                <v-text-field
                                                    v-model="location"
                                                    prepend-icon="mdi-account"
                                                    label="Location"
                                                    placeholder="Enter location..."
                                                    required
                                                    persistent-hint
                                                    :rules="rules"
                                                />
                                            </v-col>
                                            <v-col md="4">
                                                <v-file-input
                                                    v-model="file"
                                                    :label="$t('file')"
                                                    filled
                                                    outlined
                                                    prepend-icon="mdi-camera"
                                                    accept="application/pdf,application"
                                                ></v-file-input>
                                            </v-col>
                                        </v-row>

                                        <v-textarea
                                            v-model="description"
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
                                                                v-if="fromScratch"
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
                                            <template v-slot:item.vendor="{ item }">
                                                <p>{{ item.vendor.name }}</p>
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


                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="create">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.submit') }}
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/purchaseOrders/'">
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
import store from "../../store";
import route from "../../router";
import i18n from "../../i18n";
import ApiServices from "../../services/ApiServices";
import config from "../../config";

export default {
    name: "PurchaseOrderCreate",

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
        dialogVConfirm: false,
        dueDateValidation: false,
        deliveryDateValidation: false,
        menu1: false,
        menu2: false,
        headers: [
            {text: i18n.t('product'), value: 'product_name'},
            {text: i18n.t('product') + ' ' + i18n.t('variant'), value: 'product_variant'},
            {text: i18n.t('vendor'), value: 'vendor'},
            {text: i18n.t('price'), value: 'price'},
            {text: i18n.t('quantity'), value: 'quantity'},
            {text: i18n.t('unit'), value: 'unit'},
            {text: i18n.t('total'), value: 'total'},
            {text: i18n.t('shipping_cost'), value: 'shipping_cost'},
            {text: i18n.t('grand') + ' ' + i18n.t('total'), value: 'grand_total'},
            {text: i18n.t('actions'), value: 'actions', sortable: false},
        ],
        quotations: [],
        tableLoad: false,
        hasVariants: false,
        hasVendors: false,
        department_id: '',
        requester: '',
        location: '',
        requested_name: '',
        file: [],
        description: '',
        departments: [],
        productCount: 0,
        editedIndex: -1,
        poProducts: [],
        vendors: [],
        poVendors: [],
        products: [],
        units: [],
        selectVendors: [],
        selectedVendors: [],
        variants: [],
        singleSelect: false,
        selected: [],
        deleteProduct: [],
        vendorCard: false,
        fromScratch: true,
        successCount: 0,
        addPoProduct: {
            product_id: '',
            product_variant_id: '',
            quantity: '',
            unit_id: '',
            vendor_id: '',
            vendor: '',
            shipping_cost: '',
        },
        productPo: {
            product_id: '',
            product_variant_id: '',
            quantity: '',
            unit_id: '',
            vendor_id: '',
            vendor: '',
            shipping_cost: '',
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
        this.loadUnits();
        if (this.$route.query.create === 'po') {
            this.fromScratch = false;
            let selectedProducts = store.state.purchase.selectedPurchaseRequestedProducts;
            console.log(selectedProducts)
            if (Object.keys(selectedProducts).length > 0) {
                let productData = new FormData();
                productData.append('status', 'Approved');
                for (const singleData of selectedProducts) {
                    await this.addPrProducts(singleData);
                }
                this.vendorCard = true;
            }
        }
    },
    methods: {
        async addPrProducts(product) {
            var varName = '---';
            var varId = '';
            var unit = '';
            let res = await ApiServices.productShow(product.product_id);
            if (res.success === true) {
                if (product.product_variant_id) {
                    varName = product.product_variant.name;
                    varId = product.product_variant_id;
                }
                for (var i = 0; i < this.units.length; i++) {
                    if (product.unit_id === this.units[i].id) {
                        unit = this.units[i].name;
                    }
                }
                this.poProducts.push({
                    'product_id': product.product_id,
                    'product_name': product.product.name,
                    'product_variant_id': product.product_variant_id,
                    'product_variant': varName,
                    'quantity': product.quantity,
                    'price': product.price,
                    'total': product.total,
                    'shipping_cost': product.shipping_cost,
                    'unit_id': product.unit_id,
                    'unit': unit,
                    'grand_total': product.grand_total,
                    'quotation_product_id': product.id,
                    'vendor_id': product.vendor_id,
                    'vendor': product.vendor
                });
            }
            for (var j = 0; j < this.vendors.length; j++) {
                if (this.vendors[j].id === product.vendor_id) {
                    if (!(this.poVendors.indexOf(this.vendors[j]) >= 0)) {
                        this.poVendors.push(this.vendors[j]);
                    }
                }
            }
        },
        async loadDepartments() {
            let res = await ApiServices.departmentList();
            if (res.success === true) {
                this.departments = res.data;
            }
        },
        async loadUnits() {
            let res = await ApiServices.unitList();
            if (res.success === true) {
                this.units = res.data;
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
            this.loadProductVendors(product);
        },

        editItem(item) {
            this.editedIndex = this.poProducts.indexOf(item)
            this.addPoProduct = Object.assign({}, item)
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
            this.deleteProduct = this.poProducts[this.editedIndex];
            this.poProducts.splice(this.editedIndex, 1)
            let ven = await this.loadProductVendors();
            this.closeDelete()
        },

        async deleteVConfirm() {
            this.poVendors.splice(this.editedIndex, 1)
            this.closeVDelete()
        },

        async setSelectedVendors() {
            this.selectedVendors = Object.assign({}, this.poVendors);
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

        closeVConfirm() {
            this.dialogVConfirm = false
        },

        async openDialogV() {
            this.selected = this.quoVendors;
            this.dialogV = true;
            let res = await this.loadProductVendors();
        },

        async loadProductVendors(product_id) {
            this.hasVendors = true;
            let res = await ApiServices.vendorProductIds('vendor', product_id);
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
        },

        async addVendor() {
            this.poVendors = this.selected;
            this.selected = [];
            this.dialogV = false;
        },

        async addProduct() {
            var varName = '---';
            var varId = '';
            var unit = '';
            var vendor = '--';
            var shipping_cost = 0;
            if (this.addPoProduct.shipping_cost !== null) {
                shipping_cost = this.addPoProduct.shipping_cost;
            }
            let res = await ApiServices.productShow(this.addPoProduct.product_id);
            if (this.addPoProduct.product_variant_id) {
                let rtn = await ApiServices.productVariantShow(this.addPoProduct.product_variant_id);
                varName = rtn.data.name;
                varId = rtn.data.id;
            }
            for (var i = 0; i < this.units.length; i++) {
                if (this.addPoProduct.unit_id === this.units[i].id) {
                    unit = this.units[i].name;
                }
            }
            for (var i = 0; i < this.vendors.length; i++) {
                if (this.addPoProduct.vendor_id === this.vendors[i].id) {
                    vendor = this.vendors[i];
                    if (!(this.poVendors.indexOf(this.vendors[i]) >= 0)) {
                        this.poVendors.push(this.vendors[i])
                    }
                }
            }
            var total = parseInt(res.data.cost_price) * parseInt(this.addPoProduct.quantity);
            var grand_total = parseInt(total) + parseInt(shipping_cost);
            if (this.editedIndex > -1) {
                Object.assign(this.poProducts[this.editedIndex], {
                    'product_id': this.addPoProduct.product_id,
                    'product_name': res.data.name,
                    'product_variant': varName,
                    'product_variant_id': varId,
                    'unit': unit,
                    'unit_id': this.addPoProduct.unit_id,
                    'quantity': this.addPoProduct.quantity,
                    'price': res.data.cost_price,
                    'total': total,
                    'vendor_id': this.addPoProduct.vendor_id,
                    'vendor': vendor,
                    'shipping_cost': shipping_cost,
                    'grand_total': grand_total,
                })
            } else {
                this.poProducts.push({
                    'product_id': this.addPoProduct.product_id,
                    'product_name': res.data.name,
                    'product_variant_id': varId,
                    'product_variant': varName,
                    'unit': unit,
                    'unit_id': this.addPoProduct.unit_id,
                    'quantity': this.addPoProduct.quantity,
                    'price': res.data.cost_price,
                    'total': total,
                    'vendor_id': this.addPoProduct.vendor_id,
                    'vendor': vendor,
                    'shipping_cost': shipping_cost,
                    'grand_total': grand_total,
                });
            }
            this.$refs.form.reset();
            this.close()
        },

        async create() {
            this.dialogVConfirm = false;
            this.validate();
            if (this.validated) {
                this.createProgress = true;
                const data = new FormData();
                data.append('description', this.description);
                data.append('dept_id', this.department_id);
                data.append('location', this.location);
                // data.append('desired_delivery_date', this.desired_delivery_date);
                data.append('requester', this.requested_name);

                if (this.$route.query.create === 'po') {
                    data.append('is_from_quotation', 1);
                } else {
                    data.append('is_from_quotation', 0);
                }

                if (typeof this.file.name == 'string') {
                    data.append('file', this.file);
                }

                data.append('products', JSON.stringify(this.poProducts));
                data.append('vendors', JSON.stringify(this.poVendors));
                console.log(this.poProducts)

                let res = await ApiServices.purchaseOrderCreate(data);
                this.createProgress = false;
                if (res.success === true) {
                    route.replace('/purchaseOrders/');
                } else {
                    store.state.home.snackbar = true;
                    store.state.home.snackbarText = res.message;
                    store.state.home.snackbarColor = 'red';
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
    }
}
</script>
<style scoped>
.card-btn {
    color: #fff !important;
    margin-left: 3px !important;
}

.date-validation {
    color: #f31c1c !important;
}
</style>
