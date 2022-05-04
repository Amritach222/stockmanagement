<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>{{ $t('card_title.edit_item') }}</strong>
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
                                            :label="$t('name')"
                                            placeholder="Enter item name..."
                                            prepend-icon="mdi-apps-box"
                                            required
                                            @keyup="clearError('name')"
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
                                            :label="$t('product')"
                                            placeholder="Select product..."
                                            prepend-icon="mdi-alpha-p-circle"
                                            required
                                            @keyup="clearError('product_id')"
                                            :rules="rules.product_id"
                                            v-on:change="getVariants(editedItem.product_id)"
                                            solo
                                        />
                                        <div v-if="hasVariants">
                                            <v-select
                                                v-model="editedItem.product_variant_id"
                                                name="product_variant_id"
                                                :items="variants"
                                                item-value="id"
                                                item-text="name"
                                                description="Please select a variant."
                                                autocomplete=""
                                                :label="$t('variant')"
                                                placeholder="Select variant..."
                                                prepend-icon="mdi-alpha-v-circle"
                                                @keyup="clearError('product_variant_id')"
                                                solo
                                            />
                                        </div>
                                        <v-select
                                            v-model="editedItem.user_id"
                                            :items="users"
                                            item-value="id"
                                            item-text="name"
                                            description="Please select a users."
                                            autocomplete=""
                                            :label="$t('user')"
                                            placeholder="Select user..."
                                            prepend-icon="mdi-alpha-v-circle"
                                            :rules="rules.user_id"
                                            @keyup="clearError('user_id')"
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
                                            item-value="id"
                                            item-text="name"
                                            description="Please select brand."
                                            autocomplete=""
                                            :label="$t('brand')"
                                            placeholder="Select brand ..."
                                            prepend-icon="mdi-alpha-b-circle"
                                            required
                                            @keyup="clearError('brand_id')"
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
                                            :label="$t('cost_price')"
                                            placeholder="Enter cost price..."
                                            @keyup="clearError('cost_price')"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.quantity"
                                            type="number"
                                            description="Please enter quantity."
                                            autocomplete=""
                                            :label="$t('quantity')"
                                            placeholder="Enter quantity..."
                                            prepend-icon="mdi-chart-areaspline"
                                            @keyup="clearError('quantity')"
                                            solo
                                        />
                                        <p v-if="unitType">Please enter quantity on the measurement of {{ unit }}</p>
                                        <!--                                        <v-select-->
                                        <!--                                            v-model="editedItem.unit_id"-->
                                        <!--                                            name="unit_id"-->
                                        <!--                                            :items="units"-->
                                        <!--                                            item-value="id"-->
                                        <!--                                            item-text="name"-->
                                        <!--                                            description="Please select a unit."-->
                                        <!--                                            autocomplete=""-->
                                        <!--                                            :label="$t('unit')"-->
                                        <!--                                            placeholder="Select a unit..."-->
                                        <!--                                            prepend-icon="mdi-google-circles-communities"-->
                                        <!--                                            required-->
                                        <!--                                            @keyup="clearError('unit_id')"-->
                                        <!--                                            solo-->
                                        <!--                                        />-->
                                    </v-form>

                                    <hr>
                                    <v-card>
                                        <v-card-title>
                                            {{ $t('users') }}
                                            <v-spacer></v-spacer>
                                        </v-card-title>
                                        <v-data-table
                                            :headers="headers"
                                            :items="itemUsers"
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
                                                </v-toolbar>
                                            </template>
                                            <template v-slot:item.user="{ item }">
                                                <p v-if="item.user" class="mt-3">{{ item.user.name }}</p>
                                                <p v-else class="mt-3">---</p>
                                            </template>
                                            <template v-slot:item.department="{ item }">
                                                <p v-if="item.department" class="mt-3">{{ item.department.name }}</p>
                                                <p v-else class="mt-3">---</p>
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
        baseURL: config.baseURL,
        editedItem: {
            id: null,
            name: '',
            brand_id: '',
            product_id: '',
            product_variant_id: '',
            quantity: '',
            cost_price: '',
            unit_id: '',
            user_id: '',
            image: [],
        },
        products: [],
        brands: [],
        users: [],
        units: [],
        variants: [],
        itemUsers: [],
        changeProgress: false,
        search: '',
        progressL: false,
        dialog: false,
        editDialog: false,
        dialogDelete: false,
        unitType: false,
        unit: '',
        headers: [
            {text: i18n.t('user'), value: 'user'},
            {text: i18n.t('department'), value: 'department'},
            {text: i18n.t('time_span'), value: 'time_span'},
        ],
        tableLoad: false,
        productCount: 0,
        editedIndex: -1,
        hasVariants: false,
        error: {
            name: '',
            product_id: '',
            product_variant_id: '',
            quantity: '',
            cost_price: '',
            unit_id: '',
            user_id: '',
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
        },
    }),

    async created() {
        this.loadItems();
        this.loadProducts();
        this.loadBrands();
        this.loadUsers();
        this.loadUnits();
    },
    methods: {
        async loadProducts() {
            let res = await ApiServices.productList();
            if (res.success === true) {
                this.products = res.data;
            }
        },
        async loadBrands() {
            let res = await ApiServices.brandList();
            if (res.success === true) {
                this.brands = res.data;
            }
        },
        async loadUsers() {
            let res = await ApiServices.userList();
            if (res.success === true) {
                this.users = res.data;
            }
        },
        async loadUnits() {
            let res = await ApiServices.unitList();
            if (res.success === true) {
                this.units = res.data;
            }
        },
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadItems() {
            let res = await ApiServices.itemShow(this.$route.params.id);
            if (res.success === true) {
                this.editedItem = res.data;
                let rtn = await this.loadItemUsers(res.data.id);
                if (res.data.product_id !== null) {
                    this.getVariants(res.data.product_id);
                }
            }
        },
        async loadItemUsers(id) {
            let res = await ApiServices.itemUsers(id);
            if (res.success === true) {
                this.itemUsers = res.data;
            }
        },
        async getVariants(product) {
            let res = await ApiServices.productShow(product);
            if (res.success === true) {
                if (res.data.distribute_unit_id) {
                    if (res.data.distribute_unit_id !== null) {
                        let unit = await this.getUnit(res.data.distribute_unit_id);
                    } else {
                        let unit = await this.getUnit(res.data.unit_id);
                    }
                } else {
                    let unit = await this.getUnit(res.data.unit_id);
                }
                if (res.data.product_variants.length > 0) {
                    this.hasVariants = true;
                    this.variants = res.data.product_variants;
                } else {
                    this.hasVariants = false;
                }
            }
        },
        async getUnit(id) {
            let res = await ApiServices.unitShow(id);
            if (res.success === true) {
                this.unitType = true;
                this.unit = res.data.name;
                this.editedItem.unit_id = res.data.id;
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
            if (name === 'product_variant_id') {
                this.error.product_variant_id = '';
            }
            if (name === 'quantity') {
                this.error.quantity = '';
            }
            if (name === 'cost_price') {
                this.error.cost_price = '';
            }
            if (name === 'user_id') {
                this.error.user_id = '';
            }
            if (name === 'unit_id') {
                this.error.unit_id = '';
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
            if (this.editedItem.quantity !== null && this.editedItem.quantity !== undefined) {
                data.append('quantity', this.editedItem.quantity);
            }
            if (this.editedItem.product_id !== null) {
                data.append('product_id', this.editedItem.product_id);
            }
            if (this.editedItem.product_variant_id !== null && this.editedItem.product_variant_id !== undefined) {
                data.append('product_variant_id', this.editedItem.product_id);
            }
            if (this.editedItem.cost_price !== null && this.editedItem.cost_price !== undefined) {
                data.append('cost_price', this.editedItem.cost_price);
            }
            if (this.editedItem.user_id !== null) {
                data.append('user_id', this.editedItem.user_id);
            }
            if (this.editedItem.unit_id !== null) {
                data.append('unit_id', this.editedItem.unit_id);
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
