<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>{{ $t('card_title.edit_user') }}</strong>
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
                                        <v-select
                                            v-model="editedItem.type"
                                            :items="['Consumable','Stockable','Serviceable']"
                                            description="Please select a product type."
                                            autocomplete=""
                                            :label="$t('type')"
                                            placeholder="Select a type..."
                                            prepend-icon="mdi-arrange-bring-to-front"
                                            @keyup="clearError('type')"
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
    name: "UserEdit",

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
        quoProducts: [],
        productAttributeGroups: [],
        productAttributes: [],
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
            type: '',
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
            type: '',
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
                if (res.data.unit_id !== null && res.data.unit_id !== '') {
                    console.log('check-------',res.data.unit_id)
                    let unit = await this.getSubUnits(res.data.unit_id);
                }
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
            if (name === 'type') {
                this.error.type = '';
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

            if (this.editedItem.type !== null) {
                data.append('type', this.editedItem.type);
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
