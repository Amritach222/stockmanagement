<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Add</strong> Quotations
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
                                        <v-select
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

                                        <v-file-input
                                            v-model="file"
                                            label="File"
                                            filled
                                            outlined
                                            prepend-icon="mdi-camera"
                                            accept="*/application"
                                        ></v-file-input>


                                        <v-textarea
                                            v-model="note"
                                            type="text"
                                            label="Note"
                                            placeholder="Enter quotation note..."
                                            solo
                                        />
                                    </v-form>

                                    <hr>
                                    <v-card>
                                        <v-card-title>
                                            Products
                                            <v-spacer></v-spacer>
                                        </v-card-title>
                                        <v-data-table
                                            :headers="headers"
                                            :items="quoProducts"
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
                                                                                ></v-select>
                                                                                <!--                                                                                <v-select-->
                                                                                <!--                                                                                    v-model="addQuoProduct.item_variant_id"-->
                                                                                <!--                                                                                    label="Item Variant"-->
                                                                                <!--                                                                                    outlined-->
                                                                                <!--                                                                                ></v-select>-->
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
import store from "../../../store";
import route from "../../../router";
import i18n from "../../../i18n";
import ApiServices from "../../../services/ApiServices";
import config from "../../../config";

export default {
    name: "QuotationCreate",

    props: {
        source: String,
    },
    data: () => ({
        cdnURL: config.cdnURL,
        createProgress: false,
        search: '',
        progressL: false,
        dialog: false,
        dialogDelete: false,
        headers: [
            {text: 'Item', value: 'item_name'},
            // {text: 'Item Variant', value: 'item_variant_id'},
            {text: 'Quantity', value: 'quantity', sortable: false},
            {text: 'Actions', value: 'actions', sortable: false},
        ],
        quotations: [],
        tableLoad: false,
        department_id: '',
        file: [],
        note: '',
        departments: [],
        productCount: 0,
        editedIndex: -1,
        quoProducts: [],
        items: [],
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
            if (this.editedIndex > -1) {
                let res = await ApiServices.itemShow(this.addQuoProduct.item_id);
                Object.assign(this.quoProducts[this.editedIndex], {
                    'item_id': this.addQuoProduct.item_id,
                    'item_name': res.data.name,
                    'item_variant_id': this.addQuoProduct.item_variant_id,
                    'quantity': this.addQuoProduct.quantity
                })
            } else {
                let res = await ApiServices.itemShow(this.addQuoProduct.item_id);
                this.quoProducts.push({
                    'item_id': this.addQuoProduct.item_id,
                    'item_name': res.data.name,
                    'item_variant_id': this.addQuoProduct.item_variant_id,
                    'quantity': this.addQuoProduct.quantity
                });
            }
            let f = await this.clearValue();
            this.close()
        },

        async clearValue() {
            this.addQuoProduct.item_id = '';
            this.addQuoProduct.item_variant_id = '';
            this.addQuoProduct.quantity = '';
        },

        async create() {
            this.validate();
            if (this.validated) {
                this.createProgress = true;
                const data = new FormData();
                data.append('note', this.note);
                data.append('department_id', this.department_id);

                if (typeof this.file.name == 'string') {
                    data.append('file', this.file);
                }

                let res = await ApiServices.quotationCreate(data);
                this.createProgress = false;
                if (res.success === true) {
                    if (this.quoProducts.length > 0) {
                        await this.createProduct(res.data.id);
                    } else {
                        route.replace('/quotations/');
                    }
                }
            }
        },

        async createProduct(id) {
            for (var i = 0; i < this.quoProducts.length; i++) {
                let productData = new FormData();
                productData.append('item_id', parseInt(this.quoProducts[i].item_id));
                productData.append('quantity', parseInt(this.quoProducts[i].quantity));
                productData.append('quotation_id', parseInt(id));
                let res = await ApiServices.quotationProductCreate(productData);
            }
            route.replace('/quotations/');
        },

        validate() {
            if (this.department_id === '') {
                this.validated = false;
            } else {
                this.validated = true;
            }
        },
    }
}
</script>
