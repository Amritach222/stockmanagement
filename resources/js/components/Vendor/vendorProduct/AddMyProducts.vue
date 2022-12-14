<template>
    <v-card>
        <v-card-title>
            {{ $t('products') }}
            <v-spacer></v-spacer>
            <v-card-actions>
                <v-btn
                    class="btn-danger m-1 btn-back"
                    text
                    :to="'/vendor/my-products'"
                >
                    {{ $t('button.cancel') }}
                </v-btn>
                <v-btn
                    class="btn-primary btn-submit"
                    text
                    @click="save"
                >
                    {{ $t('button.submit') }}
                </v-btn>
            </v-card-actions>
        </v-card-title>
        <v-data-table
            v-model="selected"
            :single-select="singleSelect"
            item-key="name"
            show-select
            class="elevation-1"
            :headers="headers"
            :items="products"
            sort-by="id"
            :loading="tableLoad"
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
            <template v-slot:item.brand="{ item }">
                {{ item.brand.name }}
            </template>
            <template v-slot:item.category="{ item }">
                {{ item.category.name }}
            </template>
            <template v-slot:item.status="{ item }">
                <div v-if="item.status === 'Unverified'">
                    <CButton size="sm" color="danger" class="m-1">
                        {{ item.status }}
                    </CButton>
                </div>
                <div v-else-if="item.status === 'Pending'">
                    <CButton size="sm" class="m-1" color="secondary">
                        {{ item.status }}
                    </CButton>
                </div>
                <div v-else-if="item.status === 'Verified'">
                    <CButton size="sm" class="m-1" color="success">
                        {{ item.status }}
                    </CButton>
                </div>
                <div v-else>
                   ----
                </div>
            </template>
            <template v-slot:no-data>
                <div>No Data</div>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import store from "../../../store";
import ApiServices from "../../../services/ApiServices";
import i18n from "../../../i18n";
import config from "../../../config";
import route from "../../../router";


export default {
    name: "AddMyProducts",
    data: () => ({
        search: '',
        cdnURL: config.cdnURL,
        baseURL: config.baseURL,
        validated: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        singleSelect: false,
        user:{
            id:null,
        },
        selected: [],
        headers: [
            {text: i18n.t('id'), align: 'start', sortable: true, value: 'id'},
            {text: i18n.t('name'), value: 'name'},
            {text: i18n.t('image'), value: 'link', sortable: false},
            {text: i18n.t('brand'), value: 'brand', sortable: false},
            {text: i18n.t('category'), value: 'category', sortable: false},
            {text: i18n.t('status'), value: 'status', sortable: false},
        ],
        activePassive: [
            {text: 'Active', value: 1},
            {text: 'Inactive', value: 0},
        ],
        products: [],
        product_ids: [],
        tableLoad: true,
    }),

    async created() {
        this.loadItems();
    },

    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadItems() {
            let res = await ApiServices.allProductsVendor();
            if (res.success === true) {
                this.tableLoad = false;
                this.products = res.data;
                let ids = await this.loadVendorProductIds();
            }
        },
        async loadVendorProductIds() {
            this.user = JSON.parse(localStorage.getItem('userData'));
            let res = await ApiServices.vendorProductIds('product', this.user.id);
            if (res.success === true) {
                this.tableLoad = false;
                this.vendor_products = res.data;
                for (let i = 0; i < this.vendor_products.length; i++) {
                    for (let j = 0; j < this.products.length; j++) {
                        if (this.products[j].id === this.vendor_products[i].product_id) {
                            this.products[j].status = this.vendor_products[i].status;
                            this.selected.push(this.products[j]);
                        }
                    }
                }
            }
        },

        async save() {
            this.product_ids = [];
            if (this.selected.length >= 0) {
                for (let i = 0; i < this.selected.length; i++) {
                    this.product_ids.push(this.selected[i].id);
                }
                const data = new FormData();
                data.append('id', this.user.id);
                data.append('product_ids', JSON.stringify(this.product_ids));
                let res = await ApiServices.vendorProductCreate(data);
                if (res.success === true) {
                    route.replace('/vendor/my-products')
                }
            }
        },
    },
}
</script>


<style scoped>
.btn-back {
    color: #fff !important;
    font-weight: 500;
}

.btn-submit {
    color: #fff !important;
    font-weight: 500;
}
</style>
