<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Edit</strong> Item
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
                                            description="Please enter item name."
                                            autocomplete=""
                                            label="Name"
                                            placeholder="Enter item name..."
                                            prepend-icon="mdi-apps-box"
                                            required
                                            @keyup="clearError('name')"
                                            @keyup.enter="edit"
                                            :rules="rules.name"
                                            solo
                                        />
                                        <v-select
                                            v-model="editedItem.product_id"
                                            name="product_id"
                                            :items="products"
                                            item-value="id"
                                            item-text="name"
                                            description="Please select a product."
                                            autocomplete=""
                                            label="Product"
                                            placeholder="Select product..."
                                            prepend-icon="mdi-alpha-p-circle"
                                            required
                                            @keyup="clearError('product_id')"
                                            @keyup.enter="edit"
                                            :rules="rules.product_id"
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
                                                        Image
                                                    </v-card-title>
                                                </v-card>
                                                <v-file-input
                                                    v-model="editedItem.image"
                                                    label="Image"
                                                    filled
                                                    outlined
                                                    prepend-icon="mdi-camera"
                                                    accept="image/png,image/jpeg,image/jpg"
                                                ></v-file-input>
                                            </v-col>
                                            <v-col v-else>
                                                <v-file-input
                                                    v-model="editedItem.image"
                                                    label="Image"
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
                                            item-value="id"
                                            item-text="name"
                                            description="Please select brand."
                                            autocomplete=""
                                            label="Brand"
                                            placeholder="Select brand ..."
                                            prepend-icon="mdi-alpha-b-circle"
                                            required
                                            @keyup="clearError('brand_id')"
                                            @keyup.enter="edit"
                                            :rules="rules.brand_id"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.cost_price"
                                            type="number"
                                            name="cost_price"
                                            description="Please enter cost price."
                                            prepend-icon="mdi-currency-usd"
                                            autocomplete=""
                                            label="Cost Price"
                                            placeholder="Enter cost price..."
                                            @keyup="clearError('cost_price')"
                                            @keyup.enter="edit"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.stock"
                                            type="number"
                                            name="stock"
                                            description="Please enter stock."
                                            autocomplete=""
                                            label="Stock"
                                            placeholder="Enter stock..."
                                            prepend-icon="mdi-chart-areaspline"
                                            @keyup="clearError('stock')"
                                            @keyup.enter="edit"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.alert_stock"
                                            type="number"
                                            name="alert_stock"
                                            description="Please enter alert stock."
                                            autocomplete=""
                                            label="Alert Stock"
                                            placeholder="Enter alert stock..."
                                            prepend-icon="mdi-chart-bell-curve"
                                            @keyup="clearError('alert_stock')"
                                            @keyup.enter="edit"
                                            solo
                                        />
                                        <v-select
                                            v-model="editedItem.unit_id"
                                            name="unit_id"
                                            :items="units"
                                            item-value="id"
                                            item-text="name"
                                            description="Please select a unit."
                                            autocomplete=""
                                            label="Unit"
                                            placeholder="Select a unit..."
                                            prepend-icon="mdi-google-circles-communities"
                                            required
                                            @keyup="clearError('unit_id')"
                                            @keyup.enter="edit"
                                            solo
                                        />
                                        <v-select
                                            v-model="editedItem.tax_id"
                                            name="tax_id"
                                            :items="taxes"
                                            item-value="id"
                                            item-text="name"
                                            description="Please select a tax."
                                            autocomplete=""
                                            label="Tax"
                                            placeholder="Select a tax..."
                                            prepend-icon="mdi-alpha-t-circle"
                                            @keyup="clearError('tax_id')"
                                            @keyup.enter="edit"
                                            solo
                                        />
                                        <v-select
                                            v-model="editedItem.tax_method"
                                            name="tax_method"
                                            :items="['Included','Excluded']"
                                            description="Please select a tax method."
                                            autocomplete=""
                                            label="Tax Method"
                                            placeholder="Select a method..."
                                            prepend-icon="mdi-chart-bubble"
                                            @keyup="clearError('tax_method')"
                                            @keyup.enter="edit"
                                            solo
                                        />
                                    </v-form>
                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="edit">
                                            <CIcon name="cil-check-circle"/>
                                            Submit
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/items'">
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
import route from "../../../../router";
import i18n from "../../../../i18n";
import ApiServices from "../../../../services/ApiServices";
import config from "../../../../config";

export default {
    name: "ItemEdit",

    props: {
        source: String,
    },
    data: () => ({
        cdnURL: config.cdnURL,
        editedItem: {
            id: null,
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
        },
        products: [],
        brands: [],
        units: [],
        taxes: [],
        changeProgress: false,
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
        },
    }),
    async created() {
        this.loadItems();
        this.loadProducts();
        this.loadBrands();
        this.loadUnits();
        this.loadTaxes();
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
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadItems() {
            let res = await ApiServices.itemShow(this.$route.params.id);
            if (res.success === true) {
                this.editedItem = res.data;
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
            if (name === 'image') {
                this.error.image = '';
            }
        },
        async edit() {
            this.changeProgress = true;
            const data = new FormData();
            data.append('name', this.editedItem.name);
            if (this.editedItem.brand_id !== null) {
                data.append('brand_id', this.editedItem.brand_id);
            }
            data.append('stock', this.editedItem.stock);
            data.append('alert_stock', this.editedItem.alert_stock);
            if (this.editedItem.product_id !== null) {
                data.append('product_id', this.editedItem.product_id);
            }
            data.append('cost_price', this.editedItem.cost_price);
            if (this.editedItem.unit_id !== null) {
                data.append('unit_id', this.editedItem.unit_id);
            }
            if (this.editedItem.tax_id !== null) {
                data.append('tax_id', this.editedItem.tax_id);
            }
            if (this.editedItem.tax_method !== null) {
                data.append('tax_method', this.editedItem.tax_method);
            }

            if ('image' in this.editedItem) {
                if (typeof this.editedItem.image.name == 'string') {
                    data.append('image', this.editedItem.image);
                }
            }

            let res = await ApiServices.itemEdit(this.editedItem.id, data);
            this.changeProgress = false;
            if (res.success === true) {
                route.replace('/items/');
            }
        },
    }
}
</script>
