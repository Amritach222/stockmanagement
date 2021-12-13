<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>{{ $t('card_title.edit_product') }}</strong>
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
                                        <v-text-field
                                            v-model="editedItem.name"
                                            type="text"
                                            name="name"
                                            description="Please enter product name."
                                            autocomplete=""
                                            prepend-icon="mdi-apps-box"
                                            :label="$t('name')"
                                            placeholder="Enter product name..."
                                            required
                                            @keyup="clearError('name')"
                                            @keyup.enter="edit"
                                            :rules="rules.name"
                                            solo
                                        />
                                        <v-row>
                                            <v-col v-if="typeof(editedItem.link) === 'string'">
                                                <v-card width="200"
                                                        v-on:click="openImage(editedItem.link)">
                                                    <v-img
                                                        :src="cdnURL+editedItem.link"
                                                        height="125"
                                                        class="grey darken-4"
                                                    ></v-img>
                                                    <v-card-title class="title">
                                                        {{ $t('image') }}
                                                    </v-card-title>
                                                </v-card>
                                                <v-file-input
                                                    v-model="editedItem.image"
                                                    :label="$t('image')"
                                                    filled
                                                    outlined
                                                    prepend-icon="mdi-camera"
                                                    accept="image/png,image/jpeg,image/jpg"
                                                ></v-file-input>
                                            </v-col>
                                            <v-col v-else>
                                                <v-file-input
                                                    v-model="editedItem.image"
                                                    :label="$t('image')"
                                                    filled
                                                    outlined
                                                    prepend-icon="mdi-camera"
                                                    accept="image/png,image/jpeg,image/jpg"
                                                ></v-file-input>
                                            </v-col>
                                        </v-row>
                                        <v-select
                                            v-model="editedItem.brand_id"
                                            name="brand_id"
                                            :items="brands"
                                            item-text="name"
                                            item-value="id"
                                            description="Please select brand."
                                            prepend-icon="mdi-alpha-b-circle"
                                            autocomplete=""
                                            :label="$t('brand')"
                                            placeholder="Select brand ..."
                                            required
                                            @keyup="clearError('brand_id')"
                                            @keyup.enter="edit"
                                            :rules="rules.brand_id"
                                            solo
                                        />
                                        <v-select
                                            v-model="editedItem.category_id"
                                            :items="categories"
                                            item-text="name"
                                            item-value="id"
                                            name="category_id"
                                            description="Please select category."
                                            prepend-icon="mdi-shape"
                                            autocomplete=""
                                            :label="$t('category')"
                                            placeholder="Select category..."
                                            required
                                            @keyup="clearError('category_id')"
                                            @keyup.enter="edit"
                                            :rules="rules.category_id"
                                            solo
                                        />
                                        <v-checkbox
                                            v-model="editedItem.is_active"
                                            type="checkbox"
                                            name="is_active"
                                            id="is_active"
                                            description="Please check the box if it is active."
                                            autocomplete=""
                                            :label="$t('active')"
                                            @keyup="clearError('is_active')"
                                            @keyup.enter="edit"
                                            ref="activeCheck"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.cost_price"
                                            type="number"
                                            name="cost_price"
                                            description="Please enter cost price."
                                            autocomplete=""
                                            :label="$t('cost_price')"
                                            placeholder="Enter cost price..."
                                            prepend-icon="mdi-currency-usd"
                                            @keyup="clearError('cost_price')"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.stock"
                                            type="number"
                                            name="stock"
                                            description="Please enter stock."
                                            autocomplete=""
                                            :label="$t('stock')"
                                            placeholder="Enter stock..."
                                            prepend-icon="mdi-chart-areaspline"
                                            @keyup="clearError('stock')"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.alert_stock"
                                            type="number"
                                            name="alert_stock"
                                            description="Please enter alert stock."
                                            autocomplete=""
                                            :label="$t('alert_stock')"
                                            placeholder="Enter alert stock..."
                                            prepend-icon="mdi-chart-bell-curve"
                                            @keyup="clearError('alert_stock')"
                                            solo
                                        />
                                        <v-select
                                            v-model="editedItem.unit_id"
                                            name="unit_id"
                                            :items="units"
                                            item-text="name"
                                            item-value="id"
                                            description="Please select a unit."
                                            autocomplete=""
                                            :label="$t('unit')"
                                            placeholder="Select a unit..."
                                            prepend-icon="mdi-google-circles-communities"
                                            required
                                            v-on:change="getSubUnits(editedItem.unit_id)"
                                            @keyup="clearError('unit_id')"
                                            solo
                                        />
                                        <v-select
                                            v-model="editedItem.distribute_unit_id"
                                            :items="subUnits"
                                            item-text="name"
                                            item-value="id"
                                            description="Please select distribute unit."
                                            autocomplete=""
                                            :label="$t('distribute') +' '+ $t('unit')"
                                            placeholder="Select distribute unit..."
                                            prepend-icon="mdi-google-circles-communities"
                                            required
                                            @keyup="clearError('distribute_unit_id')"
                                            solo
                                        />
                                        <v-select
                                            v-model="editedItem.tax_id"
                                            name="tax_id"
                                            :items="taxes"
                                            item-text="name"
                                            item-value="id"
                                            description="Please select a tax."
                                            autocomplete=""
                                            :label="$t('tax')"
                                            placeholder="Select a tax..."
                                            prepend-icon="mdi-alpha-t-circle"
                                            @keyup="clearError('tax_id')"
                                            solo
                                        />
                                        <v-select
                                            v-model="editedItem.tax_method"
                                            name="tax_method"
                                            :items="['Included','Excluded']"
                                            description="Please select a tax method."
                                            autocomplete=""
                                            :label="$t('tax_method')"
                                            placeholder="Select a method..."
                                            prepend-icon="mdi-chart-bubble"
                                            @keyup="clearError('tax_method')"
                                            solo
                                        />
                                        <v-textarea
                                            v-model="editedItem.details"
                                            type="text"
                                            name="details"
                                            description="Please enter product details."
                                            autocomplete=""
                                            :label="$t('details')"
                                            placeholder="Enter product details..."
                                            @keyup="clearError('details')"
                                            solo
                                        />
                                    </v-form>
                                    <hr>
                                    <v-card>
                                        <v-card-title>
                                            {{ $t('variants') }}
                                            <v-spacer></v-spacer>
                                        </v-card-title>
                                        <v-data-table
                                            :headers="headers"
                                            :items="variants"
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
                                                                {{ $t('card_title.add_product_variant') }}
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
                                                                                    v-model="addVariant.attribute_group_ids"
                                                                                    :label="$t('attribute_groups')"
                                                                                    :items="productAttributeGroups"
                                                                                    item-text="name"
                                                                                    item-value="id"
                                                                                    multiple
                                                                                    required
                                                                                    outlined
                                                                                    return-object
                                                                                    v-on:change=getAttributes(addVariant.attribute_group_ids)
                                                                                ></v-select>
                                                                                <v-select
                                                                                    v-model="addVariant.attribute_ids"
                                                                                    :label="$t('attributes')"
                                                                                    :items="productAttributes"
                                                                                    item-text="name"
                                                                                    item-value="id"
                                                                                    multiple
                                                                                    required
                                                                                    outlined
                                                                                ></v-select>
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
                                                                        @click="variantAdd"
                                                                    >
                                                                        {{ $t('button.submit') }}
                                                                    </v-btn>
                                                                </v-card-actions>
                                                            </v-form>
                                                        </v-card>
                                                    </v-dialog>
                                                    <v-dialog
                                                        v-model="editDialog"
                                                        max-width="600px"
                                                    >
                                                        <v-card>
                                                            <v-form ref="editForm">
                                                                <v-card-title>
                                                                    <span class="headline">{{ formTitle }}</span>
                                                                </v-card-title>

                                                                <v-card-text>
                                                                    <v-container>
                                                                        <v-row>
                                                                            <v-col>
                                                                                <v-select
                                                                                    v-model="addVariant.attribute_group_ids"
                                                                                    :label="$t('attribute_groups')"
                                                                                    :items="productAttributeGroups"
                                                                                    item-text="name"
                                                                                    item-value="id"
                                                                                    disabled
                                                                                    multiple
                                                                                    required
                                                                                    outlined
                                                                                ></v-select>
                                                                                <v-select
                                                                                    v-model="addVariant.attribute_ids"
                                                                                    :label="$t('attributes')"
                                                                                    :items="productAttributes"
                                                                                    item-text="name"
                                                                                    item-value="id"
                                                                                    disabled
                                                                                    multiple
                                                                                    required
                                                                                    outlined
                                                                                ></v-select>
                                                                                <v-text-field
                                                                                    v-model="addVariant.quantity"
                                                                                    :label="$t('quantity')"
                                                                                    type="number"
                                                                                    outlined
                                                                                ></v-text-field>
                                                                                <v-text-field
                                                                                    v-model="addVariant.price"
                                                                                    :label="$t('price')"
                                                                                    type="number"
                                                                                    outlined
                                                                                ></v-text-field>
                                                                                <v-row>
                                                                                    <v-col
                                                                                        v-if="typeof(addVariant.link) === 'string'">
                                                                                        <v-card width="200"
                                                                                                v-on:click="openImage(addVariant.link)">
                                                                                            <v-img
                                                                                                :src="cdnURL+addVariant.link"
                                                                                                height="125"
                                                                                                class="grey darken-4"
                                                                                            ></v-img>
                                                                                            <v-card-title class="title">
                                                                                                {{ $t('image') }}
                                                                                            </v-card-title>
                                                                                        </v-card>
                                                                                        <v-file-input
                                                                                            v-model="addVariant.image"
                                                                                            :label="$t('image')"
                                                                                            filled
                                                                                            outlined
                                                                                            prepend-icon="mdi-camera"
                                                                                            accept="image/png,image/jpeg,image/jpg"
                                                                                        ></v-file-input>
                                                                                    </v-col>
                                                                                    <v-col v-else>
                                                                                        <v-file-input
                                                                                            v-model="addVariant.image"
                                                                                            :label="$t('image')"
                                                                                            filled
                                                                                            outlined
                                                                                            prepend-icon="mdi-camera"
                                                                                            accept="image/png,image/jpeg,image/jpg"
                                                                                        ></v-file-input>
                                                                                    </v-col>
                                                                                </v-row>
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
                                                                        @click="editClose"
                                                                    >
                                                                        {{ $t('button.cancel') }}
                                                                    </v-btn>
                                                                    <v-btn
                                                                        color="blue darken-1"
                                                                        text
                                                                        @click="variantAdd"
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
                                                                    {{ $t('button.confirm') }}
                                                                </v-btn>
                                                                <v-spacer></v-spacer>
                                                            </v-card-actions>
                                                        </v-card>
                                                    </v-dialog>
                                                </v-toolbar>
                                            </template>
                                            <template v-slot:item.link="{ item }">
                                                <img :src=cdnURL+item.link
                                                     v-if="item.link"
                                                     style="width: 50px; height: 50px; object-fit: cover;"
                                                     v-on:click="openImage(item.link)"/>

                                                <img :src="baseURL+'images/placeholder.jpg'"
                                                     v-else
                                                     style="width: 50px; height: 50px; object-fit: cover"
                                                />
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
                                            {{ $t('button.submit') }}
                                        </CButton>
                                        <CButton :to="'/products'" size="sm" color="danger">
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
    name: "ProductEdit",

    props: {
        source: String,
    },
    data: () => ({
        cdnURL: config.cdnURL,
        brands: [],
        categories: [],
        changeProgress: false,
        search: '',
        progressL: false,
        dialog: false,
        editDialog: false,
        dialogDelete: false,
        headers: [
            {text: i18n.t('id'), value: 'id'},
            {text: i18n.t('attributes'), value: 'name'},
            {text: i18n.t('image'), value: 'link'},
            {text: i18n.t('quantity'), value: 'quantity'},
            {text: i18n.t('price'), value: 'price'},
            {text: i18n.t('actions'), value: 'actions', sortable: false},
        ],
        tableLoad: false,
        productCount: 0,
        editedIndex: -1,
        quoProducts: [],
        productAttributeGroups: [],
        productAttributes: [],
        addVariant: {
            attribute_group_ids: [],
            attribute_ids: [],
            quantity: '',
            price: '',
            image: [],
        },
        variants: [],
        units: [],
        subUnits: [],
        taxes: [],
        editedItem: {
            id: null,
            name: '',
            brand_id: '',
            category_id: '',
            details: '',
            is_active: '',
            stock: '',
            alert_stock: '',
            cost_price: '',
            unit_id: '',
            distribute_unit_id: '',
            tax_id: '',
            tax_method: '',
            image: [],
        },
        error: {
            name: '',
            brand_id: '',
            category_id: '',
            details: '',
            is_active: '',
            stock: '',
            alert_stock: '',
            cost_price: '',
            unit_id: '',
            distribute_unit_id: '',
            tax_id: '',
            tax_method: '',
        },
        rules: {
            name: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            brand_id: [
                val => val > 0 || i18n.t('validation.required'),
            ],
            category_id: [
                val => val > 0 || i18n.t('validation.required'),
            ],
        },
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? i18n.t('card_title.add_product_variant') : i18n.t('card_title.edit_product_variant')
        },
    },
    async created() {
        this.loadBrands();
        this.loadCategories();
        this.loadData();
        this.loadProductAttributeGroups();
        this.loadUnits();
        this.loadTaxes();
    },
    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadBrands() {
            let res = await ApiServices.brandIndex();
            if (res.success === true) {
                this.brands = res.data;
            }
        },
        async loadCategories() {
            let res = await ApiServices.categoryIndex();
            if (res.success === true) {
                this.categories = res.data;
            }
        },
        async loadUnits() {
            let res = await ApiServices.unitIndex();
            if (res.success === true) {
                this.units = res.data;
            }
        },
        async getSubUnits(unit) {
            this.subUnits = [];
            let res = await ApiServices.unitShow(unit);
            for (var i = 0; i < this.units.length; i++) {
                if (this.units[i].category_id === res.data.category_id) {
                    this.subUnits.push(this.units[i]);
                }
            }
        },
        async loadTaxes() {
            let res = await ApiServices.taxIndex();
            if (res.success === true) {
                this.taxes = res.data;
            }
        },
        async loadData() {
            let res = await ApiServices.productShow(this.$route.params.id);
            if (res.success === true) {
                this.editedItem = res.data;
                this.variants = res.data.product_variants;
                let unit = await this.getSubUnits(res.data.unit_id);
            }
        },
        async loadProductAttributeGroups() {
            let res = await ApiServices.productAttributeGroupIndex();
            if (res.success === true) {
                this.productAttributeGroups = res.data;
            }
        },
        async getAttributes(attributeGroup) {
            this.productAttributes = [];
            let res = await ApiServices.productAttributeIndex();
            for (var i = 0; i < res.data.length; i++) {
                for (var j = 0; j < attributeGroup.length; j++) {
                    if (res.data[i].attribute_group_id === attributeGroup[j].id) {
                        this.productAttributes.push(res.data[i]);
                    }
                }
            }
        },
        async editItem(item) {
            this.editedIndex = this.variants.indexOf(item)
            this.addVariant = Object.assign({}, item)
            this.productAttributes = [];
            let res = await ApiServices.productAttributeIndex();
            for (var i = 0; i < res.data.length; i++) {
                for (var j = 0; j < this.addVariant.attribute_group_ids.length; j++) {
                    if (res.data[i].attribute_group_id === this.addVariant.attribute_group_ids[j]) {
                        this.productAttributes.push(res.data[i]);
                    }
                }
            }
            this.editDialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.variants.indexOf(item)
            this.addVariant = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.productVariantDelete(this.addVariant.id);
            if (res.success === true) {
                this.variants.splice(this.editedIndex, 1)
            }
            this.closeDelete()
        },

        close() {
            this.progressL = false;
            this.dialog = false;
            this.$nextTick(() => {
                this.addVariant = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            });
        },

        editClose() {
            this.progressL = false;
            this.editDialog = false;
            this.$nextTick(() => {
                this.addVariant = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            });
        },

        closeDelete() {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.addVariant = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },
        clearError(name) {
            if (name === 'name') {
                this.error.name = '';
            }
            if (name === 'brand_id') {
                this.error.brand_id = '';
            }
            if (name === 'category_id') {
                this.error.category_id = '';
            }
            if (name === 'details') {
                this.error.details = '';
            }
            if (name === 'stock') {
                this.error.stock = '';
            }
            if (name === 'alert_stock') {
                this.error.alert_stock = '';
            }
            if (name === 'cost_price') {
                this.error.cost_price = '';
            }
            if (name === 'unit_id') {
                this.error.unit_id = '';
            }
            if (name === 'distribute_unit_id') {
                this.error.distribute_unit_id = '';
            }
            if (name === 'tax_id') {
                this.error.tax_id = '';
            }
            if (name === 'tax_method') {
                this.error.tax_method = '';
            }
        },

        async variantAdd() {
            this.validate();
            if (this.validated) {
                if (this.editedIndex > -1) {
                    const data = new FormData();
                    data.append('quantity', parseInt(this.addVariant.quantity));
                    data.append('price', parseInt(this.addVariant.price));
                    if ('image' in this.addVariant) {
                        if (typeof this.addVariant.image.name == 'string') {
                            data.append('image', this.addVariant.image);
                        }
                    }
                    let res = await ApiServices.productVariantEdit(this.addVariant.id, data);
                    Object.assign(this.variants[this.editedIndex], res.data);
                    this.$refs.editForm.reset();
                    this.editClose()
                } else {
                    const data = new FormData();
                    data.append('attribute_ids', JSON.stringify(this.addVariant.attribute_ids));
                    let res = await ApiServices.createVariant(data);
                    if (res.success === true) {
                        for (var i = 0; i < res.data.length; i++) {
                            data.append('attribute_ids', JSON.stringify(res.data[i].attribute_ids));
                            data.append('product_id', this.editedItem.id);

                            let rtn = await ApiServices.productVariantCreate(data);
                            if (rtn.success === true) {
                                this.variants.push(rtn.data);
                            }
                        }
                    }
                    this.$refs.form.reset();
                    this.close()
                }
            }
        },

        async edit() {
            this.changeProgress = true;
            const data = new FormData();
            if (this.editedItem.name !== null && this.editedItem.name !== '') {
                data.append('name', this.editedItem.name);
            }

            if (this.editedItem.brand_id !== null && this.editedItem.brand_id !== '') {
                data.append('brand_id', this.editedItem.brand_id);
            }

            if (this.editedItem.category_id !== null && this.editedItem.category_id !== '') {
                data.append('category_id', this.editedItem.category_id);
            }

            if (this.editedItem.stock !== null && this.editedItem.stock !== '') {
                data.append('stock', this.editedItem.stock);
            }

            if (this.editedItem.alert_stock !== null && this.editedItem.alert_stock !== '') {
                data.append('alert_stock', this.editedItem.alert_stock);
            }

            if ((this.editedItem.cost_price !== null && this.editedItem.cost_price !== '') && this.editedItem.cost_price !== undefined) {
                data.append('cost_price', this.editedItem.cost_price);
            }

            if (this.editedItem.unit_id !== null && this.editedItem.unit_id !== '') {
                data.append('unit_id', this.editedItem.unit_id);
            }

            if ((this.editedItem.distribute_unit_id !== null && this.editedItem.distribute_unit_id !== '') && this.editedItem.distribute_unit_id !== undefined) {
                data.append('distribute_unit_id', this.editedItem.distribute_unit_id);
            }

            if (this.editedItem.tax_id !== null && this.editedItem.tax_id !== '') {
                data.append('tax_id', this.editedItem.tax_id);
            }
            if (this.editedItem.tax_method !== null && this.editedItem.tax_method !== '') {
                data.append('tax_method', this.editedItem.tax_method);
            }

            if (this.editedItem.details !== null) {
                data.append('details', this.editedItem.details);
            }

            if ('image' in this.editedItem) {
                if (typeof this.editedItem.image.name == 'string') {
                    data.append('image', this.editedItem.image);
                }
            }

            var checkbox = document.getElementById('is_active');
            if (checkbox.checked) {
                data.append('is_active', 1);
            } else {
                data.append('is_active', 0);
            }

            let res = await ApiServices.productEdit(this.editedItem.id, data);
            this.changeProgress = false;
            if (res.success === true) {
                route.replace('/products');
            }
        },
        validate() {
            this.validated = true;
            if (this.addVariant.attribute_group_ids.length === 0) {
                this.validated = false;
            } else if (this.addVariant.attribute_ids.length === 0) {
                this.validated = false;
            } else {
                this.validated = true;
            }
        },
    }
}
</script>
