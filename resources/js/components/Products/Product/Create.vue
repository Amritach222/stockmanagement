<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Add</strong> Product
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
                                            description="Please enter product name."
                                            prepend-icon="mdi-apps-box"
                                            autocomplete=""
                                            :label="$t('name')"
                                            placeholder="Enter product name..."
                                            required
                                            @keyup="clearError('name')"
                                            @keyup.enter="create"
                                            :rules="rules.name"
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
                                            item-value="id"
                                            item-text="name"
                                            description="Please select brand."
                                            prepend-icon="mdi-alpha-b-circle"
                                            autocomplete=""
                                            :label="$t('brand')"
                                            placeholder="Select brand ..."
                                            required
                                            @keyup="clearError('brand_id')"
                                            @keyup.enter="create"
                                            :rules="rules.brand_id"
                                            solo
                                        />
                                        <v-select
                                            v-model="category_id"
                                            :items="categories"
                                            item-value="id"
                                            item-text="name"
                                            name="category_id"
                                            prepend-icon="mdi-shape"
                                            description="Please select category."
                                            autocomplete=""
                                            :label="$t('category')"
                                            placeholder="Select category..."
                                            required
                                            @keyup="clearError('category_id')"
                                            @keyup.enter="create"
                                            :rules="rules.category_id"
                                            solo
                                        />
                                        <v-checkbox
                                            v-model="is_active"
                                            type="checkbox"
                                            name="is_active"
                                            id="is_active"
                                            description="Please check the box if it is active."
                                            autocomplete=""
                                            :label="$t('active')"
                                            @keyup="clearError('details')"
                                            @keyup.enter="create"
                                            ref="activeCheck"
                                            solo
                                        />
                                        <v-textarea
                                            v-model="details"
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
                                        <CButton type="submit" size="sm" color="primary" @click="create">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.submit') }}
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/products'">
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
    name: "ProductCreate",

    props: {
        source: String,
    },
    data: () => ({
        cdnURL: config.cdnURL,
        brands: [],
        categories: [],
        createProgress: false,
        name: '',
        brand_id: '',
        category_id: '',
        details: '',
        is_active: '',
        image: [],
        error: {
            name: '',
            brand_id: '',
            category_id: '',
            details: '',
            is_active: '',
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
    async created() {
        this.loadBrands();
        this.loadCategories();
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
        },
        async create() {
            this.createProgress = true;
            const data = new FormData();
            data.append('name', this.name);
            data.append('brand_id', this.brand_id);
            data.append('category_id', this.category_id);
            data.append('details', this.details);

            if (typeof this.image.name == 'string') {
                data.append('image', this.image);
            }

            var checkbox = document.getElementById('is_active');
            if (checkbox.checked) {
                data.append('is_active', 1);
            } else {
                data.append('is_active', 0);
            }

            let res = await ApiServices.productCreate(data);
            this.createProgress = false;
            if (res.success === true) {
                route.replace('/products/');
            }
        },
    }
}
</script>
