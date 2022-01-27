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
                                                    v-model="editedItem.department_id"
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
                                                    v-model="editedItem.due_date"
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
                                                    v-model="editedItem.desired_delivery_date"
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
                                                    v-model="editedItem.requested_name"
                                                    prepend-icon="mdi-alpha-d-circle"
                                                    :label="$t('requested') + ' ' + $t('name')"
                                                    placeholder="Enter requested user name..."
                                                    required
                                                    :rules="rules"
                                                    solo
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
                                        </v-row>

                                        <v-textarea
                                            v-model="editedItem.note"
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
                                                                                        item-text="name"
                                                                                        item-value="id"
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
                                            <template v-slot:item.tax_id="{ item }">
                                                <p v-if="item.tax_id" class="mt-3">{{ item.tax.value }}%</p>
                                                <p v-else class="mt-3">0</p>
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
                                                    <!--                                                <v-dialog v-model="dialogDelete" max-width="500px">-->
                                                    <!--                                                    <v-card>-->
                                                    <!--                                                        <v-card-title class="text-h6">-->
                                                    <!--                                                            {{ $t('message.delete') }}-->
                                                    <!--                                                        </v-card-title>-->
                                                    <!--                                                        <v-card-actions>-->
                                                    <!--                                                            <v-spacer></v-spacer>-->
                                                    <!--                                                            <v-btn color="blue darken-1" text @click="closeDelete">-->
                                                    <!--                                                                {{ $t('button.cancel') }}-->
                                                    <!--                                                            </v-btn>-->
                                                    <!--                                                            <v-btn color="blue darken-1" text-->
                                                    <!--                                                                   @click="deleteItemConfirm">-->
                                                    <!--                                                                {{ $t('button.submit') }}-->
                                                    <!--                                                            </v-btn>-->
                                                    <!--                                                            <v-spacer></v-spacer>-->
                                                    <!--                                                        </v-card-actions>-->
                                                    <!--                                                    </v-card>-->
                                                    <!--                                                </v-dialog>-->
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

                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="edit">
                                            <CIcon name="cil-check-circle"/>
                                            Submit
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
        name: "QuotationEdit",

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
                {text: i18n.t('tax'), value: 'tax_id'},
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
            editedItem: {
                id: null,
                department_id: '',
                file: [],
                note: '',
                due_date: '',
                desired_delivery_date: '',
                requested_name: '',
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
            this.loadData();
            this.loadDepartments();
            this.loadItems();
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
                this.validate();
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

                    let res = await ApiServices.quotationEdit(this.editedItem.id, data);
                    this.changeProgress = false;
                    if (res.success === true) {
                        route.replace('/quotations/');
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

            async addVendor() {
                this.quoVendors = this.selected;
                this.selected = [];
                this.dialogV = false;
            },

            async createProductVendor() {
                let data = new FormData();
                data.append('quotation_id', parseInt(this.$route.params.id));
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
