<template>
    <v-data-table
        v-model="selected"
        :headers="headers"
        :items="prProducts"
        sort-by="item_name"
        :loading=tableLoad
        show-select
        :hide-default-footer="true"
        loading-text="Loading... Please wait..."
    >
        <template v-slot:top>
            <v-dialog
                v-model="dialog"
                max-width="600px"
            >
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
                                            v-model="addPurchaseRequestProduct.product_id"
                                            label="Select Product"
                                            :items="products"
                                            item-text="name"
                                            item-value="id"
                                            required
                                            outlined
                                            :rules="rules"
                                            v-on:change="getVariants(addPurchaseRequestProduct.product_id)"
                                        ></v-select>
                                        <div v-if="hasVariants">
                                            <v-select
                                                v-model="addPurchaseRequestProduct.product_variant_id"
                                                label="Product Variant"
                                                :items="variants"
                                                item-value="id"
                                                item-text="name"
                                                outlined
                                            ></v-select>
                                        </div>
                                        <v-text-field
                                            v-model="addPurchaseRequestProduct.quantity"
                                            label="Quantity"
                                            type="number"
                                            outlined
                                        ></v-text-field>
                                        <v-select
                                            v-model="addPurchaseRequestProduct.unit"
                                            label="Unit"
                                            :items="units"
                                            item-text="name"
                                            item-value="id"
                                            required
                                            outlined
                                            return-object
                                            :rules="rules"
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
                                Cancel
                            </v-btn>
                            <v-btn
                                color="blue darken-1"
                                text
                                @click="addProduct"
                            >
                                Save
                            </v-btn>
                        </v-card-actions>
                    </v-form>
                </v-card>
            </v-dialog>
            <v-dialog v-model="dialogDelete" max-width="500px">
                <v-card>
                    <v-card-title class="text-h6">Are you sure you want to
                        delete this item?
                    </v-card-title>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="closeDelete">
                            Cancel
                        </v-btn>
                        <v-btn color="blue darken-1" text
                               @click="deleteItemConfirm">OK
                        </v-btn>
                        <v-spacer></v-spacer>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </template>
        <template v-slot:item.product_id="{ item }">
            {{ getProductName(item.product_id) }}
        </template>
        <template v-slot:item.product_variant_id="{ item }">
            {{ getVariantName(item.product_variant_id) }}
        </template>
        <template v-slot:item.unit_id="{ item }">
            {{ getUnitName(item.unit_id) }}
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
</template>

<script>
import route from "../../router";
import ApiServices from "../../services/ApiServices";
import config from "../../config";
import store from "../../store";

export default {
    name: "NewPurchaseRequest",

    props: {
        source: String,
        details: [],
        triggerSelectProduct: Boolean
    },

    watch: {
        triggerSelectProduct: async function(newVal, oldVal) {
            let res = await store.dispatch('purchase/addSelectedProducts', this.selected);
            console.log("selected rows hahha", res);
        }
    },

    data: () => ({
        cdnURL: config.cdnURL,
        admin: false,
        createProgress: false,
        search: '',
        progressL: false,
        selected: [],
        dialog: false,
        dialogDelete: false,
        headers: [
            {text: 'Product', value: 'product_id'},
            {text: 'Product Variant', value: 'product_variant_id'},
            {text: 'Quantity', value: 'quantity'},
            {text: 'Unit', value: 'unit_id'},
            {text: 'Status', value: 'status'},
            {text: 'Actions', value: 'actions', sortable: false},
        ],
        quotations: [],
        tableLoad: true,
        hasVariants: false,
        department_id: '',
        file: [],
        note: '',
        due_date: '',
        departments: [],
        productCount: 0,
        editedIndex: -1,
        prProducts: [],
        products: [],
        units: [],
        variants: [],
        menu1: false,
        dateFormatted: '',
        addPurchaseRequestProduct: {
            product_id: '',
            product_variant_id: '',
            quantity: '',
            unit_id: '',
        },
        productQuo: {
            product_id: '',
            product_variant_id: '',
            quantity: '',
            unit_id: '',
        },
        error: {
            department_id: '',
            file: [],
            note: '',
        },
        rules: [
            value => !!value || 'Required.',
        ]
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Add Quotation Product' : 'Edit Quotation Product'
        },
    },
    async created() {
        this.loadItems();
        this.loadUnits();
        this.prProducts = this.details;
    },
    methods: {
        getProductName(item) {
            if (item === null || item === undefined) {
                return "------"
            }
            let result = this.products.filter(obj => {
                return obj.id === item;
            });
            if (result[0] === null || result[0] === undefined) {
                return "------"
            }
            return result[0].name;
        },

        getUnitName(item) {
            if (item === null || item === undefined) {
                return "------"
            }
            let result = this.units.filter(obj => {
                return obj.id === item;
            })
            if (result[0] === null || result[0] === undefined) {
                return "------"
            }
            return result[0].name;
        },

        getVariantName(item) {
            if (item === null || item === undefined) {
                return "------"
            }
        },

        async loadItems() {
            let res = await ApiServices.productIndex();
            if (res.success === true) {
                this.products = res.data;
            }
        },
        async loadUnits() {
            let res = await ApiServices.unitIndex();
            if (res.success === true) {
                this.units = res.data;
            }
            this.tableLoad = false;
        },

        async getVariants(item) {
            let res = await ApiServices.productShow(item);
            console.log('we get here', res);
            if (res.success === true) {
                if (res.data.product_variants.length > 0) {
                    this.hasVariants = true;
                } else {
                    this.hasVariants = false;
                }
                this.variants = res.data.product_variants;
            }
        },

        editItem(item) {
            this.editedIndex = this.prProducts.indexOf(item);
            let result = this.units.filter(obj => {
                return obj.id === item.unit_id;
            })
            this.addPurchaseRequestProduct = Object.assign({}, item);
            this.addPurchaseRequestProduct.unit = result[0];
            this.dialog = true;
        },

        deleteItem(item) {
            this.editedIndex = this.prProducts.indexOf(item)
            this.addPurchaseRequestProduct = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            this.prProducts.splice(this.editedIndex, 1)
            this.closeDelete()
        },

        close() {
            this.progressL = false;
            this.dialog = false;
            this.$nextTick(() => {
                this.addPurchaseRequestProduct = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            });
            this.loadItems();
        },

        closeDelete() {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.addPurchaseRequestProduct = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        async addProduct() {
            let varName = '---';
            let res = await ApiServices.productShow(this.addPurchaseRequestProduct.product_id);
            if (this.addPurchaseRequestProduct.product_variant_id) {
                let rtn = await ApiServices.productVariantShow(this.addPurchaseRequestProduct.product_variant_id);
                varName = rtn.data.name;
            }

            if (this.editedIndex > -1) {
                Object.assign(this.prProducts[this.editedIndex], {
                    'product_id': this.addPurchaseRequestProduct.product_id,
                    'product_name': res.data.name,
                    'product_variant': varName,
                    'product_variant_id': this.addPurchaseRequestProduct.product_variant_id,
                    'quantity': this.addPurchaseRequestProduct.quantity,
                    'unit_name': this.addPurchaseRequestProduct.unit.name,
                    'unit_id': this.addPurchaseRequestProduct.unit.id,
                })
            } else {
                this.prProducts.push({
                    'product_id': this.addPurchaseRequestProduct.product_id,
                    'product_name': res.data.name,
                    'product_variant_id': this.addPurchaseRequestProduct.product_variant_id,
                    'product_variant': varName,
                    'quantity': this.addPurchaseRequestProduct.quantity,
                    'unit_name': this.addPurchaseRequestProduct.unit.name,
                    'unit_id': this.addPurchaseRequestProduct.unit.id,
                });
            }
            this.$refs.form.reset();
            this.close();
            this.hasVariants = false;
        },

        async create() {
            this.createProgress = true;
            const data = new FormData();
            data.append('note', this.note);
            if (this.due_date) {
                data.append('due_date', this.due_date);
            }
            if (this.admin) {
                data.append('department_id', this.department_id);

            }
            if (typeof this.file.name == 'string') {
                data.append('file', this.file);
            }

            let res = await ApiServices.addPurchaseRequest(data);
            this.createProgress = false;
            if (res.success === true) {
                let dat = false;
                if (this.prProducts.length > 0) {
                    dat = await this.createProduct(res.data.id);
                    console.log("result from the purchase request", dat);
                    if (dat) {
                        route.replace('/purchase/purchase-request-history/');
                        store.state.home.snackbar = true;
                        store.state.home.snackbarText = this.$i18n.t('successToSave');
                        store.state.home.snackbarColor = 'green';
                    } else {
                        store.state.home.snackbar = true;
                        store.state.home.snackbarText = this.$i18n.t('failedToSaveProduct');
                        store.state.home.snackbarColor = 'red';
                    }
                }
            } else {
                // send error message here
            }
        },

        async createProduct(id) {
            let returnValue = true;
            for (var i = 0; i < this.prProducts.length; i++) {
                let productData = new FormData();
                productData.append('quantity', parseInt(this.prProducts[i].quantity));
                productData.append('product_id', parseInt(this.prProducts[i].product_id));
                productData.append('purchase_id', parseInt(id));
                productData.append('unit_id', parseInt(this.prProducts[i].unit_id));
                if (this.prProducts[i].product_variant_id !== '' && this.prProducts[i].product_variant_id !== undefined) {
                    productData.append('product_variant_id', parseInt(this.prProducts[i].product_variant_id));
                }
                let res = await ApiServices.addPurchaseProductRequest(productData);
                if (res.success === false) {
                    returnValue = false;
                }
            }
            return returnValue;
        },
    }
}
</script>
