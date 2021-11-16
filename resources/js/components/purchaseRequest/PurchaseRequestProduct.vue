<template>
    <v-card>
        <v-card-title>
            Products
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="products"
            sort-by="id"
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
                                :to="'/products/create'"
                            >
                                Add New Product
                            </v-btn>
                        </template>
                    </v-dialog>
                    <v-dialog v-model="dialogDelete" max-width="500px">
                        <v-card>
                            <v-card-title class="text-h6">Are you sure you want to delete this item?</v-card-title>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                                <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
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
            <template v-slot:item.actions="{ item }">
                <router-link
                    :to="'/products/edit/'+item.id"
                >
                    <v-icon
                        small
                    >
                        mdi-pencil
                    </v-icon>
                </router-link>
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
</template>

<script>
import config from "../../../config";
import ApiServices from "../../../services/ApiServices";

export default {
    name: "PurchaseRequestProduct",
    data: () => ({
        cdnURL: config.cdnURL,
        baseURL: config.baseURL,
        search: '',
        validated: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        headers: [
            {text: 'Id', align: 'start', sortable: true, value: 'id'},
            {text: 'Name', value: 'name'},
            {text: 'Image', value: 'link', sortable: false},
            {text: 'Brand', value: 'brand', sortable: false},
            {text: 'Category', value: 'category', sortable: false},
            {text: 'Actions', value: 'actions', sortable: false},
        ],
        products: [],
        editedIndex: -1,
        editedItem: {
            id: null,
            name: '',
            brand_id: '',
            category_id: '',
            details: '',
            is_active: '',
            image: [],
        },
        defaultItem: {
            id: null,
            name: '',
            brand_id: '',
            category_id: '',
            details: '',
            is_active: '',
            image: [],
        },
        rules: [
            value => !!value || 'Required.',
        ],
        tableLoad: true
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Add Product' : 'Edit Product'
        },
    },

    watch: {
        dialog(val) {
            val || this.close()
        },
        dialogDelete(val) {
            val || this.closeDelete()
        },
    },

    async created() {
        this.loadItems();
    },

    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadItems() {
            let res = await ApiServices.productIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.products = res.data;
            }
        },
        editItem(item) {
            this.editedIndex = this.products.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.products.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.productDelete(this.editedItem.id);
            if (res.success === true) {
                this.products.splice(this.editedIndex, 1)
            }
            this.closeDelete()
        },

        close() {
            this.progressL = false;
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            });
            this.loadItems();
        },

        closeDelete() {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        async save() {
            if (this.editedIndex > -1) {
                //edit goes here
                this.progressL = true;
                const data = new FormData();
                data.append('name', this.editedItem.name);
                console.log('edit', this.editedItem.image, this.editedItem)
                if ('image' in this.editedItem) {
                    if (typeof this.editedItem.image.name == 'string') {
                        data.append('image', this.editedItem.image);
                    }
                }
                let res = await ApiServices.productEdit(this.editedItem.id, data);
                if (res.success === true) {
                    Object.assign(this.brands[this.editedIndex], this.editedItem)
                    this.$refs.form.reset();
                    this.close();
                }
            } else {
                //add new
                this.validateData();
                if (this.validated) {
                    this.progressL = true;
                    const data = new FormData();
                    data.append('name', this.editedItem.name);
                    if (typeof this.editedItem.image.name == 'string') {
                        data.append('image', this.editedItem.image);
                    }
                    let res = await ApiServices.productCreate(data);
                    if (res.success === true) {
                        this.brands.push(this.editedItem);
                        this.$refs.form.reset();
                        this.close()
                    }
                }
            }
        },
        validateData() {
            this.$refs.form.validate();
            if (this.editedItem.name === null) {
                this.validated = false
            } else {
                this.validated = true
            }
        }
    },
}
</script>


<style scoped>

</style>
