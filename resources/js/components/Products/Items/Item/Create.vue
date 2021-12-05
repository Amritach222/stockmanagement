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
                                            :rules="rules.product_id"
                                            solo
                                        />
                                        <v-select
                                            v-model="product_variant_id"
                                            :items="variants"
                                            item-text="name"
                                            item-value="id"
                                            description="Please select a variant."
                                            autocomplete=""
                                            :label="$t('variants')"
                                            placeholder="Select variant..."
                                            prepend-icon="mdi-alpha-v-circle"
                                            solo
                                        />
                                        <v-select
                                            v-model="user_id"
                                            :items="users"
                                            item-text="name"
                                            item-value="id"
                                            description="Please select a user."
                                            autocomplete=""
                                            :label="$t('user')"
                                            placeholder="Select user..."
                                            :rules="rules.user_id"
                                            required
                                            prepend-icon="mdi-account"
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
                                            solo
                                        />
                                        <v-text-field
                                            v-model="quantity"
                                            type="number"
                                            description="Please enter quantity."
                                            autocomplete=""
                                            :label="$t('quantity')"
                                            placeholder="Enter quantity..."
                                            prepend-icon="mdi-chart-areaspline"
                                            @keyup="clearError('quantity')"
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
        product_variant_id: '',
        user_id: '',
        quantity: '',
        cost_price: '',
        unit_id: '',
        image: [],
        brands: [],
        products: [],
        units: [],
        variants: [],
        users: [],
        createProgress: false,
        error: {
            name: '',
            product_id: '',
            cost_price: '',
            unit_id: '',
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
            user_id: [
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
        this.loadUsers();
        this.loadDepartments();
        // this.loadItemAttributes();
    },
    methods: {
        async loadProducts() {
            let res = await ApiServices.productIndex();
            if (res.success === true) {
                this.products = res.data;
            }
        },
        async loadUsers() {
            let res = await ApiServices.userIndex();
            if (res.success === true) {
                this.users = res.data;
            }
        },
        async loadDepartments() {
            let res = await ApiServices.userIndex();
            if (res.success === true) {
                this.departments = res.data;
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
            if (name === 'quantity') {
                this.error.quantity = '';
            }
            if (name === 'cost_price') {
                this.error.cost_price = '';
            }
            if (name === 'unit_id') {
                this.error.unit_id = '';
            }
        },


        async create() {
            this.createProgress = true;
            const data = new FormData();
            data.append('name', this.name);
            data.append('brand_id', this.brand_id);
            data.append('product_id', this.product_id);
            data.append('product_variant_id', this.product_variant_id);
            data.append('quantity', this.quantity);
            data.append('cost_price', this.cost_price);
            data.append('unit_id', this.unit_id);
            data.append('user_id', this.user_id);

            if (typeof this.image.name == 'string') {
                data.append('image', this.image);
            }

            let res = await ApiServices.itemCreate(data);
            this.createProgress = false;
            if (res.success === true) {
                    route.replace('/items/');
            }
        },
    }
}
</script>
