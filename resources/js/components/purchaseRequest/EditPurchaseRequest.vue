<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <v-progress-circular
                                    v-if="createProgress"
                                    indeterminate
                                    color="white"
                                    size="30"
                                ></v-progress-circular>
                            </CCardHeader>
                            <CCardBody>
                                <CForm>
                                    <v-card>
                                        <v-card-title>
                                            Products
                                            <v-spacer></v-spacer>
                                        </v-card-title>
                                        <v-data-table
                                            :headers="headers"
                                            :items="quoProducts"
                                            sort-by="item_name"
                                            :loading=tableLoad
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
                                                                label="Search"
                                                                solo
                                                                hide-details
                                                                max-width="100px"
                                                            ></v-text-field>
                                                        </v-col>
                                                    </v-row>
                                                    <v-dialog
                                                        v-model="dialog"
                                                        max-width="600px"
                                                    >
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-btn
                                                                color="green"
                                                                dark
                                                                class="mb-2"
                                                                v-bind="attrs"
                                                                v-on="on"
                                                            >
                                                                Add New Product
                                                            </v-btn>
                                                        </template>
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
                                                                                    v-model="addQuoProduct.item_id"
                                                                                    label="Item"
                                                                                    :items="items"
                                                                                    item-text="name"
                                                                                    item-value="id"
                                                                                    required
                                                                                    outlined
                                                                                    :rules="rules"
                                                                                    v-on:change="getVariants(addQuoProduct.item_id)"
                                                                                ></v-select>
                                                                                <div v-if="hasVariants">
                                                                                    <v-select
                                                                                        v-model="addQuoProduct.item_variant_id"
                                                                                        label="Item Variant"
                                                                                        :items="variants"
                                                                                        item-value="id"
                                                                                        item-text="name"
                                                                                        outlined
                                                                                    ></v-select>
                                                                                </div>
                                                                                <v-text-field
                                                                                    v-model="addQuoProduct.quantity"
                                                                                    label="Quantity"
                                                                                    type="number"
                                                                                    outlined
                                                                                ></v-text-field>
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
                                                </v-toolbar>
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
                                    </v-card>
                                    <v-form class="mt-5">
                                        <v-select
                                            v-if="admin"
                                            v-model="department_id"
                                            :items="departments"
                                            item-value="id"
                                            item-text="name"
                                            prepend-icon="mdi-alpha-d-circle"
                                            label="Department"
                                            placeholder="Select department ..."
                                            required
                                            :rules="rules"
                                            solo
                                        />

                                        <v-textarea
                                            v-model="note"
                                            type="text"
                                            label="Note"
                                            placeholder="Enter quotation note..."
                                            solo
                                        />
                                        <v-menu
                                            ref="menu1"
                                            v-model="menu1"
                                            :close-on-content-click="false"
                                            transition="scale-transition"
                                            offset-y
                                            max-width="290px"
                                            min-width="auto"
                                        >
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-text-field
                                                    v-model="due_date"
                                                    label="Due Date"
                                                    persistent-hint
                                                    prepend-icon="mdi-calendar"
                                                    v-bind="attrs"
                                                    v-on="on"
                                                ></v-text-field>
                                            </template>
                                            <v-date-picker
                                                v-model="due_date"
                                                no-title
                                                @input="menu1 = false"
                                            ></v-date-picker>
                                        </v-menu>
                                        <v-file-input
                                            v-model="file"
                                            label="File"
                                            filled
                                            outlined
                                            prepend-icon="mdi-camera"
                                            accept="*/application"
                                        ></v-file-input>
                                    </v-form>
                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="create">
                                            <CIcon name="cil-check-circle"/>
                                            Submit
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/quotations/'">
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
import route from "../../router";
import ApiServices from "../../services/ApiServices";
import config from "../../config";
import store from "../../store";

export default {
    name: "EditPurchaseRequest",

    props: {
        source: String,
    },
    data: () => ({
        cdnURL: config.cdnURL,
        admin: false,
        createProgress: false,
        search: '',
        progressL: false,
        dialog: false,
        dialogDelete: false,
        headers: [
            {text: 'Item', value: 'item_name'},
            {text: 'Item Variant', value: 'item_variant'},
            {text: 'Quantity', value: 'quantity'},
            {text: 'Price', value: 'price'},
            {text: 'Shipping Cost', value: 'shipping_cost'},
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
        quoProducts: [],
        items: [],
        variants: [],
        menu1: false,
        dateFormatted: '',
        addQuoProduct: {
            item_id: '',
            item_variant_id: '',
            quantity: '',
        },
        productQuo: {
            item_id: '',
            item_variant_id: '',
            quantity: '',
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
        this.loadDepartments();
        this.loadItems();
    },
    methods: {
        async loadDepartments() {
            let res = await ApiServices.departmentIndex();
            if (res.success === true) {
                this.departments = res.data;
            }
        },

        async loadItems() {
            let res = await ApiServices.itemIndex();
            if (res.success === true) {
                this.items = res.data;
            }
            this.tableLoad = false;
            let item = store.state.purchase.editItem;
            this.quoProducts = item.purchase_products;
            this.note = item.note;
            this.due_date = item.due_date_formal;
            console.log('data loaded on edit item', item)
        },

        async getVariants(item) {
            let res = await ApiServices.itemShow(item);
            if (res.success === true) {
                if (res.data.item_variants.length > 0) {
                    this.hasVariants = true;
                } else {
                    this.hasVariants = false;
                }
                this.variants = res.data.item_variants;
            }
        },

        editItem(item) {
            this.editedIndex = this.quoProducts.indexOf(item)
            this.addQuoProduct = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.quoProducts.indexOf(item)
            this.addQuoProduct = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            this.quoProducts.splice(this.editedIndex, 1)
            this.closeDelete()
        },

        close() {
            this.progressL = false;
            this.dialog = false;
            this.$nextTick(() => {
                this.addQuoProduct = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            });
            this.loadItems();
        },

        closeDelete() {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.addQuoProduct = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        async addProduct() {
            var varName = '---';
            var price = '';
            let res = await ApiServices.itemShow(this.addQuoProduct.item_id);
            price = res.data.cost_price;
            if (this.addQuoProduct.item_variant_id) {
                let rtn = await ApiServices.itemVariantShow(this.addQuoProduct.item_variant_id);
                varName = rtn.data.name;
                price = rtn.data.price;
            }
            if (this.editedIndex > -1) {
                Object.assign(this.quoProducts[this.editedIndex], {
                    'item_id': this.addQuoProduct.item_id,
                    'item_name': res.data.name,
                    'product_id': res.data.product_id,
                    'item_variant': varName,
                    'item_variant_id': this.addQuoProduct.item_variant_id,
                    'price': price,
                    'quantity': this.addQuoProduct.quantity,
                    'shipping_cost': this.addQuoProduct.shipping_cost,
                })
            } else {
                this.quoProducts.push({
                    'item_id': this.addQuoProduct.item_id,
                    'item_name': res.data.name,
                    'product_id': res.data.product_id,
                    'item_variant_id': this.addQuoProduct.item_variant_id,
                    'item_variant': varName,
                    'price': price,
                    'quantity': this.addQuoProduct.quantity,
                    'shipping_cost': this.addQuoProduct.shipping_cost,
                });
            }
            this.$refs.form.reset();
            this.close()
        },

        async create() {
            this.createProgress = true;
            const data = new FormData();
            data.append('note', this.note);
            if(this.due_date){
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
                if (this.quoProducts.length > 0) {
                    await this.createProduct(res.data.id);
                } else {
                    route.replace('/purchase-request-history/');
                }
                route.replace('/purchase-request-history');
            }
        },

        async createProduct(id) {
            for (var i = 0; i < this.quoProducts.length; i++) {
                let productData = new FormData();
                productData.append('item_id', parseInt(this.quoProducts[i].item_id));
                productData.append('quantity', parseInt(this.quoProducts[i].quantity));
                productData.append('product_id', parseInt(this.quoProducts[i].product_id));
                productData.append('purchase_id', parseInt(id));
                if (this.quoProducts[i].item_variant_id !== '') {
                    productData.append('item_variant_id', parseInt(this.quoProducts[i].item_variant_id));
                }
                let res = await ApiServices.addPurchaseProductRequest(productData);
            }
        },
    }
}
</script>
