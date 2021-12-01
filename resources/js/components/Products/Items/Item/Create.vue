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

    async created() {
        this.loadProducts();
        this.loadBrands();
        this.loadUnits();
        this.loadTaxes();
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
                    route.replace('/items/');
            }
        },
    }
}
</script>
