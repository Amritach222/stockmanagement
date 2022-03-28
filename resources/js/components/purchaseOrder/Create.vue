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
                                                                                <!--                                                                                <v-text-field-->
                                                                                <!--                                                                                    v-model="addQuoProduct.shipping_cost"-->
                                                                                <!--                                                                                    :label="$t('shipping_cost')"-->
                                                                                <!--                                                                                    type="number"-->
                                                                                <!--                                                                                    outlined-->
                                                                                <!--                                                                                ></v-text-field>-->
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
                                            :items="poVendors"
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
                                                                v-if="fromScratch"
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

                                    <v-dialog
                                        v-model="dialogVConfirm"
                                        max-width="850px"
                                        max-height="450px"
                                    >
                                        <v-card>
                                            <v-card-title>
                                                Do you want to send you quotation to these vendors?
                                                <v-spacer></v-spacer>
                                            </v-card-title>
                                            <v-data-table
                                                v-model="selected"
                                                item-key="name"
                                                class="elevation-1"
                                                :headers="headersSV"
                                                :items="poVendors"
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
                                                        @click="create"
                                                    >
                                                        {{ $t('button.submit') }}
                                                    </v-btn>
                                                </v-card-actions>
                                            </v-row>
                                        </v-card>
                                    </v-dialog>

                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="confirmCreate">
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
            {text: i18n.t('quantity'), value: 'quantity'},
            {text: i18n.t('unit'), value: 'unit'},
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
        fromScratch:true,
        successCount: 0,
        addPoProduct: {
            product_id: '',
            product_variant_id: '',
            quantity: '',
        },
        productPo: {
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
                    let rtn = await ApiServices.productVariantShow(product.product_variant_id);
                    varName = rtn.data.name;
                    varId = rtn.data.id;
                }
                for (var i = 0; i < this.units.length; i++) {
                    if (product.unit_id === this.units[i].id) {
                        unit = this.units[i].name;
                    }
                }
                this.poProducts.push({
                    'product_id': product.product_id,
                    'product_name': res.data.name,
                    'product_variant_id': product.product_variant_id,
                    'product_variant': varName,
                    'quantity': product.quantity,
                    'price':product.price,
                    'shipping_cost': product.shipping_cost,
                    'unit_id': product.unit_id,
                    'unit': unit,
                    'quotation_product_id': product.id,
                });
            }
            for (var j=0; j<this.vendors.length; j++){
                if(this.vendors[j].id === product.vendor_id){
                    if(!(this.poVendors.indexOf(this.vendors[j]) >= 0)){
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
            // let res = await this.deleteProductVendor();
            this.closeDelete()
        },

        async deleteVConfirm() {
            this.poVendors.splice(this.editedIndex, 1)
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

        async loadProductVendors() {
            if (this.poProducts.length > 0) {
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
            } else {
                this.vendorCard = false;
                this.selectVendors = [];
                this.poVendors = [];
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
            if (this.editedIndex > -1) {
                Object.assign(this.poProducts[this.editedIndex], {
                    'product_id': this.addPoProduct.product_id,
                    'product_name': res.data.name,
                    'product_variant': varName,
                    'product_variant_id': varId,
                    'unit': unit,
                    'unit_id': this.addPoProduct.unit_id,
                    'quantity': this.addPoProduct.quantity,
                    // 'shipping_cost': this.addQuoProduct.shipping_cost,
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
                    // 'shipping_cost': this.addQuoProduct.shipping_cost,
                });
            }
            if (this.poProducts.length > 0) {
                this.vendorCard = true;
            }
            this.$refs.form.reset();
            this.close()
        },

        async checkDate(type, date) {
            var currDate = new Date().toISOString().slice(0, 10);
            var inpDate1 = date.replace('-', '');
            var inpDate2 = inpDate1.replace('-', '');
            var currDateReplace1 = currDate.replace('-', '');
            var currDateReplace2 = currDateReplace1.replace('-', '');
            if (currDateReplace2 > inpDate2) {
                if (type === 'due_date') {
                    this.dueDateValidation = true;
                } else {
                    this.deliveryDateValidation = true;
                }
            } else {
                if (type === 'due_date') {
                    this.dueDateValidation = false;
                } else {
                    this.deliveryDateValidation = false;
                }
            }
        },

        async confirmCreate() {
            if (this.poVendors.length > 0) {
                this.validate();
                this.checkDate('due_date', this.due_date);
                this.checkDate('delivery_date', this.desired_delivery_date);
                if ((this.deliveryDateValidation === false) && (this.dueDateValidation === false)) {
                    if (this.validated) {
                        this.dialogVConfirm = true;
                    }
                }
            } else {
                this.create();
            }
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
                        // if (this.poProducts.length > 0) {
                        //     await this.createProduct(res.data.id);
                        //     // if (this.poProducts.length === parseInt(this.successCount)) {
                        //     //     await this.createProductVendor(res.data.id);
                        //     // }
                        // } else {
                            route.replace('/purchaseOrders/');
                        // }
                    } else {
                        store.state.home.snackbar = true;
                        store.state.home.snackbarText = res.message;
                        store.state.home.snackbarColor = 'red';
                    }
            }
        },

        async createProduct(id) {
            for (var i = 0; i < this.poProducts.length; i++) {
                let productData = new FormData();
                productData.append('product_id', parseInt(this.poProducts[i].product_id));
                productData.append('quantity', parseInt(this.poProducts[i].quantity));
                productData.append('quotation_id', parseInt(id));
                if ((this.poProducts[i].product_variant_id !== '') && (typeof (parseInt(this.poProducts[i].product_variant_id) === 'integer')) && (this.poProducts[i].product_variant_id !== null)) {
                    productData.append('product_variant_id', parseInt(this.poProducts[i].product_variant_id));
                }
                if ((this.poProducts[i].unit_id !== '') && (typeof (parseInt(this.poProducts[i].unit_id) === 'integer')) && (this.poProducts[i].unit_id !== null)) {
                    productData.append('unit_id', parseInt(this.poProducts[i].unit_id));
                }
                if (this.$route.query.create === 'po') {
                    if ((this.poProducts[i].quotation_product_id) && (this.poProducts[i].quotation_product_id !== '') && (typeof (parseInt(this.poProducts[i].quotation_product_id) === 'integer')) && (this.poProducts[i].quotation_product_id !== null)) {
                        productData.append('quotation_product_id', parseInt(this.poProducts[i].quotation_product_id));
                    }
                }
                let res = await ApiServices.purchaseOrderCreate(productData);
                if (res.success === true) {
                    this.successCount = parseInt(this.successCount) + 1;
                } else {
                    store.state.home.snackbar = true;
                    store.state.home.snackbarText = res.message;
                    store.state.home.snackbarColor = 'red';
                }
            }
            // route.replace('/quotations/');
        },

        // async createProductVendor(id) {
        //     let data = new FormData();
        //     data.append('quotation_id', parseInt(id));
        //     data.append('products', JSON.stringify(this.quoProducts));
        //     data.append('vendors', JSON.stringify(this.quoVendors));
        //     let res = await ApiServices.vendorQuotationCreate(data);
        //     if (res.success === true) {
        //         if(res.message !== null){
        //             store.state.home.snackbar = true;
        //             store.state.home.snackbarText = res.message;
        //             store.state.home.snackbarColor = 'red';
        //         }
        //         route.replace('/quotations/')
        //     } else {
        //         store.state.home.snackbar = true;
        //         store.state.home.snackbarText = res.message;
        //         store.state.home.snackbarColor = 'red';
        //     }
        // },

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
