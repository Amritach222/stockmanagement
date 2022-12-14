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
        <template v-slot:item.product_id="{ item }">
            {{ getProductName(item.product_id) }}
        </template>
        <template v-slot:item.product_variant_id="{ item }">

            {{ getVariantName(item.product_variant_id) }}
        </template>
        <template v-slot:item.quantity="{ item }">
            <v-edit-dialog
                :return-value.sync="item.quantity"
                @save="saveDat(item)"
                @cancel="cancel"
            >
                {{ item.quantity }}
                <template v-slot:input>
                    <v-text-field
                        v-model="item.quantity"
                        label="Edit"
                        single-line
                    ></v-text-field>
                </template>
            </v-edit-dialog>
        </template>
        <template v-slot:item.unit_id="{ item }">
            {{ getUnitName(item.unit_id) }}
        </template>
        <template v-slot:no-data>
            <div>No Data</div>
        </template>
    </v-data-table>
</template>

<script>
    import route from "../../../router";
    import ApiServices from "../../../services/ApiServices";
    import config from "../../../config";
    import store from "../../../store";

    export default {
        name: "QuotationProductDetails",

        props: {
            source: String,
            details: [],
            triggerSelectProduct: Boolean
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
            prVariants: [],
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
        watch: {

        },
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Add Quotation Product' : 'Edit Quotation Product'
            },
        },
        async created() {
            this.loadItems();
            this.loadUnits();
            this.loadVariants();
            this.prProducts = this.details;
        },
        methods: {
            getColor(status) {
                if (status === 'Pending') return 'warning'
                else if (status === 'Rejected') return 'danger'
                else return 'success'
            },
            async sendQPtoPO () {
                let res = await store.dispatch('purchase/addSelectedProducts', this.selected);
                route.replace('/purchaseOrders/create?create=po');
            },
            async saveDat(item) {
                let productData = new FormData();
                productData.append('quantity', parseInt(item.quantity));
                let res = await ApiServices.editPurchaseRequestProduct(item.id, productData);
                if (res.success === true) {
                    store.state.home.snackbar = true;
                    store.state.home.snackbarText = "Quantity Edited";
                    store.state.home.snackbarColor = 'green';
                } else {
                    store.state.home.snackbar = true;
                    store.state.home.snackbarText = "Could not edit";
                    store.state.home.snackbarColor = 'red';
                }
            },
            cancel() {
                this.snack = true
                this.snackColor = 'error'
                this.snackText = 'Canceled'
            },

            getProductName(item) {
                if (item === null || item === undefined) {
                    return "---"
                }
                let result = this.products.filter(obj => {
                    return obj.id === item;
                });
                if (result[0] === null || result[0] === undefined) {
                    return "---"
                }
                return result[0].name;
            },

            getUnitName(item) {
                if (item === null || item === undefined) {
                    return "---"
                }
                let result = this.units.filter(obj => {
                    return obj.id === item;
                })
                if (result[0] === null || result[0] === undefined) {
                    return "---"
                }
                return result[0].name;
            },

            getVariantName(item) {
                if (item === null || item === undefined) {
                    return "---"
                } else {
                    let result = this.prVariants.filter(obj => {
                        return obj.id === item;
                    })
                    return result[0].name;
                }
            },

            loadVariants() {
                this.details.forEach(async (singleData) => {
                    if (singleData.product_variant_id !== null) {
                        let rtn = await ApiServices.productVariantShow(singleData.product_variant_id);
                        rtn = rtn.data.name;
                        let data = {'name': rtn, 'id': singleData.product_variant_id};
                        this.prVariants.push(data);
                    }
                });
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

            async denyProduct(item) {
                let productData = new FormData();
                productData.append('department_status', 'Rejected');
                let res = await ApiServices.changePurchaseProductStatusRequest(item.id, productData);
                if (res.success === true) {
                    this.editedIndex = this.prProducts.indexOf(item);
                    Object.assign(this.prProducts[this.editedIndex], res.data)
                    store.state.home.snackbar = true;
                    store.state.home.snackbarText = "Changed status";
                    store.state.home.snackbarColor = 'green';
                } else {
                    store.state.home.snackbar = true;
                    store.state.home.snackbarText = "Could not change status";
                    store.state.home.snackbarColor = 'red';
                }
            },

            async approveProduct(item) {
                let productData = new FormData();
                productData.append('department_status', 'Approved');
                let res = await ApiServices.changePurchaseProductStatusRequest(item.id, productData);
                if (res.success === true) {
                    this.editedIndex = this.prProducts.indexOf(item);
                    Object.assign(this.prProducts[this.editedIndex], res.data)
                    store.state.home.snackbar = true;
                    store.state.home.snackbarText = "Changed status";
                    store.state.home.snackbarColor = 'green';
                } else {
                    store.state.home.snackbar = true;
                    store.state.home.snackbarText = "Could not change status";
                    store.state.home.snackbarColor = 'red';
                }
            },

            async addToApproveList(item) {
                let res = await store.dispatch('purchase/addSelectedProducts', [item]);
                if (res === true) {
                    store.state.home.snackbar = true;
                    store.state.home.snackbarText = "Added to list";
                    store.state.home.snackbarColor = 'green';
                } else {
                    store.state.home.snackbar = true;
                    store.state.home.snackbarText = "Could not add to list";
                    store.state.home.snackbarColor = 'red';
                }
            },

            async removeFromApproveList(item) {
                let res = await store.dispatch('purchase/removeSelectedProduct', item);
                if (res === true) {
                    store.state.home.snackbar = true;
                    store.state.home.snackbarText = "Removed from list";
                    store.state.home.snackbarColor = 'green';
                } else {
                    store.state.home.snackbar = true;
                    store.state.home.snackbarText = "Could not remove from list";
                    store.state.home.snackbarColor = 'red';
                }
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
