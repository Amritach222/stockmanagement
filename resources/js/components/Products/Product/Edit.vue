<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Edit</strong> Product
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
                                            label="Name"
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
                                            item-text="name"
                                            item-value="id"
                                            description="Please select brand."
                                            prepend-icon="mdi-alpha-b-circle"
                                            autocomplete=""
                                            label="Brand"
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
                                            label="Category"
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
                                            label="Active"
                                            @keyup="clearError('is_active')"
                                            @keyup.enter="edit"
                                            ref="activeCheck"
                                            solo
                                        />
                                        <v-textarea
                                            v-model="editedItem.details"
                                            type="text"
                                            name="details"
                                            description="Please enter product details."
                                            autocomplete=""
                                            label="Details"
                                            placeholder="Enter product details..."
                                            @keyup="clearError('details')"
                                            solo
                                        />
                                    </v-form>
                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="edit">
                                            <CIcon name="cil-check-circle"/>
                                            Submit
                                        </CButton>
                                        <CButton :to="'/products'" size="sm" color="danger">
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
    name: "ProductEdit",

    props: {
        source: String,
    },
    data: () => ({
        cdnURL: config.cdnURL,
        brands: [],
        categories: [],
        changeProgress: false,
        editedItem: {
            id: null,
            name: '',
            brand_id: '',
            category_id: '',
            details: '',
            is_active: '',
            image: [],
        },
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
        this.loadData();
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
        async loadData() {
            let res = await ApiServices.productShow(this.$route.params.id);
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
            if (name === 'category_id') {
                this.error.category_id = '';
            }
            if (name === 'details') {
                this.error.details = '';
            }
        },
        async edit() {
            this.changeProgress = true;
            const data = new FormData();
            data.append('name', this.editedItem.name);
            data.append('brand_id', this.editedItem.brand_id);
            data.append('category_id', this.editedItem.category_id);
            data.append('details', this.editedItem.details);

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
    }
}
</script>
