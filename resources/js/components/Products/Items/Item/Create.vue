<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>{{ $t('card_title.add_item') }}</strong>
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
                                        <v-text-field
                                            v-model="name"
                                            type="text"
                                            name="name"
                                            description="Please enter item name."
                                            autocomplete=""
                                            :label="$t('name')"
                                            placeholder="Enter item name..."
                                            required
                                            @keyup="clearError('name')"
                                            prepend-icon="mdi-apps-box"
                                            @keyup.enter="create"
                                            :rules="rules.name"
                                            solo
                                        />
                                        <v-select
                                            v-model="product_id"
                                            name="product_id"
                                            :items="products"
                                            item-text="name"
                                            item-value="id"
                                            description="Please select a product."
                                            autocomplete=""
                                            :label="$t('product')"
                                            placeholder="Select product..."
                                            required
                                            @keyup="clearError('product_id')"
                                            prepend-icon="mdi-alpha-p-circle"
                                            @keyup.enter="create"
                                            :rules="rules.product_id"
                                            solo
                                        />
                                        <v-file-input
                                            v-model="image"
                                            :label="$t('image')"
                                            filled
                                            outlined
                                            prepend-icon="mdi-camera"
                                            accept="image/png,image/jpeg,image/jpg"
                                        ></v-file-input>
                                        <v-select
                                            v-model="brand_id"
                                            name="brand_id"
                                            :items="brands"
                                            item-text="name"
                                            item-value="id"
                                            description="Please select brand."
                                            autocomplete=""
                                            :label="$t('brand')"
                                            placeholder="Select brand ..."
                                            required
                                            @keyup="clearError('brand_id')"
                                            prepend-icon="mdi-alpha-b-circle"
                                            @keyup.enter="create"
                                            :rules="rules.brand_id"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="cost_price"
                                            type="number"
                                            name="cost_price"
                                            description="Please enter cost price."
                                            autocomplete=""
                                            :label="$t('cost_price')"
                                            placeholder="Enter cost price..."
                                            prepend-icon="mdi-currency-usd"
                                            @keyup="clearError('cost_price')"
                                            @keyup.enter="create"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="stock"
                                            type="number"
                                            name="stock"
                                            description="Please enter stock."
                                            autocomplete=""
                                            :label="$t('stock')"
                                            placeholder="Enter stock..."
                                            prepend-icon="mdi-chart-areaspline"
                                            @keyup="clearError('stock')"
                                            @keyup.enter="create"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="alert_stock"
                                            type="number"
                                            name="alert_stock"
                                            description="Please enter alert stock."
                                            autocomplete=""
                                            :label="$t('alert_stock')"
                                            placeholder="Enter alert stock..."
                                            prepend-icon="mdi-chart-bell-curve"
                                            @keyup="clearError('alert_stock')"
                                            @keyup.enter="create"
                                            solo
                                        />
                                        <v-select
                                            v-model="unit_id"
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
                                            @keyup="clearError('unit_id')"
                                            @keyup.enter="create"
                                            solo
                                        />
                                        <v-select
                                            v-model="tax_id"
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
                                            @keyup.enter="create"
                                            solo
                                        />
                                        <v-select
                                            v-model="tax_method"
                                            name="tax_method"
                                            :items="['Included','Excluded']"
                                            description="Please select a tax method."
                                            autocomplete=""
                                            :label="$t('tax_method')"
                                            placeholder="Select a method..."
                                            prepend-icon="mdi-chart-bubble"
                                            @keyup="clearError('tax_method')"
                                            @keyup.enter="create"
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
                                            sort-by="name"
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
                                                                {{ $t('card_title.add_item_variant') }}
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
                                                                                    :items="itemAttributeGroups"
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
                                                                                    :items="itemAttributes"
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
                                                                                    :items="itemAttributeGroups"
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
                                                                                    :items="itemAttributes"
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
                                        <CButton size="sm" color="danger" :to="'/items'">
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
import store from "../../../../store";
import route from "../../../../router";
import i18n from "../../../../i18n";
import ApiServices from "../../../../services/ApiServices";
import cityList from "../../../../services/lib/city.json";

export default {
    name: "ItemCreate",

    props: {
        source: String,
    },
    data: () => ({
        name: '',
        brand_id: '',
        product_id: '',
        stock: '',
        alert_stock: '',
        cost_price: '',
        unit_id: '',
        tax_id: '',
        tax_method: '',
        image: [],
        brands: [],
        products: [],
        units: [],
        taxes: [],
        createProgress: false,
        search: '',
        progressL: false,
        dialog: false,
        editDialog: false,
        dialogDelete: false,
        headers: [
            {text: 'Attributes', value: 'name'},
            {text: 'Quantity', value: 'quantity'},
            {text: 'Price', value: 'price'},
            {text: 'Actions', value: 'actions', sortable: false},
        ],
        tableLoad: false,
        productCount: 0,
        editedIndex: -1,
        validated: false,
        quoProducts: [],
        itemAttributeGroups: [],
        itemAttributes: [],
        addVariant: {
            attribute_group_ids: [],
            attribute_ids: [],
            quantity: '',
            price: '',
        },
        variants: [],
        error: {
            name: '',
            product_id: '',
            stock: '',
            alert_stock: '',
            cost_price: '',
            unit_id: '',
            tax_id: '',
            tax_method: '',
            image: [],
        },
        rules: {
            name: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            brand_id: [
                val => val > 0 || i18n.t('validation.required'),
            ],
            product_id: [
                val => val > 0 || i18n.t('validation.required'),
            ],
            attribute_group_ids: [
                val => val > 0 || i18n.t('validation.required'),
            ],
            attribute_ids: [
                val => val > 0 || i18n.t('validation.required'),
            ],
        },
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? i18n.t('card_title.add_item_variant') : i18n.t('card_title.edit_item_variant')
        },
    },

    async created() {
        this.loadProducts();
        this.loadBrands();
        this.loadUnits();
        this.loadTaxes();
        this.loadItemAttributeGroups();
        // this.loadItemAttributes();
    },
    methods: {
        async loadProducts() {
            let res = await ApiServices.productIndex();
            if (res.success === true) {
                this.products = res.data;
            }
        },
        async loadBrands() {
            let res = await ApiServices.brandIndex();
            if (res.success === true) {
                this.brands = res.data;
            }
        },
        async loadUnits() {
            let res = await ApiServices.unitIndex();
            if (res.success === true) {
                this.units = res.data;
            }
        },
        async loadTaxes() {
            let res = await ApiServices.taxIndex();
            if (res.success === true) {
                this.taxes = res.data;
            }
        },
        async loadItemAttributeGroups() {
            let res = await ApiServices.itemAttributeGroupIndex();
            if (res.success === true) {
                this.itemAttributeGroups = res.data;
            }
        },
        async getAttributes(attributeGroup) {
            this.itemAttributes = [];
            let res = await ApiServices.itemAttributeIndex();
            for (var i = 0; i < res.data.length; i++) {
                for (var j = 0; j < attributeGroup.length; j++) {
                    if (res.data[i].attribute_group_id === attributeGroup[j].id) {
                        this.itemAttributes.push(res.data[i]);
                    }
                }
            }
        },

        editItem(item) {
            this.editedIndex = this.variants.indexOf(item)
            this.addVariant = Object.assign({}, item)
            this.editDialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.variants.indexOf(item)
            this.addVariant = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            this.variants.splice(this.editedIndex, 1)
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
            if (name === 'product_id') {
                this.error.product_id = '';
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
            if (name === 'tax_id') {
                this.error.tax_id = '';
            }
            if (name === 'tax_method') {
                this.error.tax_method = '';
            }
        },

        async variantAdd() {
            this.validate();
            if (this.validated === true) {
                if (this.editedIndex > -1) {
                    Object.assign(this.variants[this.editedIndex], {
                        'quantity': this.addVariant.quantity,
                        'price': this.addVariant.price
                    })
                    this.$refs.editForm.reset();
                    this.editClose()
                } else {
                    const data = new FormData();
                    data.append('attribute_ids', JSON.stringify(this.addVariant.attribute_ids));
                    let res = await ApiServices.createVariant(data);
                    if (res.success === true) {
                        for (var i = 0; i < res.data.length; i++) {
                            this.variants.push(res.data[i]);
                        }
                    }
                    this.$refs.form.reset();
                    this.close()
                }
            }
        },


        async create() {
            this.createProgress = true;
            const data = new FormData();
            data.append('name', this.name);
            data.append('brand_id', this.brand_id);
            data.append('stock', this.stock);
            data.append('alert_stock', this.alert_stock);
            data.append('product_id', this.product_id);
            data.append('cost_price', this.cost_price);
            data.append('unit_id', this.unit_id);
            data.append('tax_id', this.tax_id);
            data.append('tax_method', this.tax_method);

            if (typeof this.image.name == 'string') {
                data.append('image', this.image);
            }

            console.log(this.variants.length)

            let res = await ApiServices.itemCreate(data);
            this.createProgress = false;
            if (res.success === true) {
                if (this.variants.length > 0) {
                    let rtn = this.createVariant(res.data.id);
                } else {
                    route.replace('/items/');
                }
            }
        },

        async createVariant(id) {
            this.createProgress = true;
            const data = new FormData();
            for (var i = 0; i < this.variants.length; i++) {
                data.append('attribute_ids', JSON.stringify(this.variants[i].attribute_ids));
                data.append('price', parseInt(this.variants[i].price));
                data.append('quantity', parseInt(this.variants[i].quantity));
                data.append('item_id', id);

                let res = await ApiServices.itemVariantCreate(data);
            }
            route.replace('/items/');
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
        }
    }
}
</script>
