<template>
    <v-card>
        <v-data-table
            :headers="headers"
            :items="purchaseHistory"
            sort-by="id"
            show-expand
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
                                :to="'/new-purchase-request'"
                            >
                                Add New Purchase Request
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
                                                <v-text-field
                                                    v-model="editedItem.name"
                                                    label="Brand Name"
                                                    required
                                                    outlined
                                                    :rules="rules"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
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
                                                        Logo
                                                    </v-card-title>
                                                </v-card>
                                                <v-file-input
                                                    v-model="editedItem.image"
                                                    label="Logo"
                                                    filled
                                                    outlined
                                                    prepend-icon="mdi-camera"
                                                    accept="image/png,image/jpeg,image/jpg"
                                                ></v-file-input>
                                            </v-col>
                                            <v-col v-else>
                                                <v-file-input
                                                    v-model="editedItem.image"
                                                    label="Logo"
                                                    filled
                                                    outlined
                                                    prepend-icon="mdi-camera"
                                                    accept="image/png,image/jpeg,image/jpg"
                                                ></v-file-input>
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
                                        @click="save"
                                    >
                                        Save
                                    </v-btn>
                                </v-card-actions>
                            </v-form>
                        </v-card>
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
            <template #expanded-item="{headers,item}">
               <PurchaseTableDetail :item="item"></PurchaseTableDetail>
            </template>
            <template v-slot:no-data>
                <div>No Data</div>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import config from "../../config";
import ApiServices from "../../services/ApiServices";
import PurchaseTableDetail from "./PurchaseTableDetail";

export default {
    name: "PurchaseRequestHistory",
    components: {PurchaseTableDetail},
    data: () => ({
        cdnURL: config.cdnURL,
        search: '',
        validated: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        headers: [
            {text: 'Reference No', align: 'start', sortable: false, value: 'reference_no'},
            {text: 'Total Items', value: 'total_item'},
            {text: 'Status', value: 'status'},
            {text: 'Due Date', value: 'due_date'},
            {text: 'Actions', value: 'actions', sortable: false},
        ],
        purchaseHistory: [],
        editedIndex: -1,
        editedItem: {
            id: null,
            name: '',
            image: [],
        },
        defaultItem: {
            id: null,
            name: '',
            image: [],
        },
        rules: [
            value => !!value || 'Required.',
        ],
        tableLoad: true
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Add Brand' : 'Edit Brand'
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
            let res = await ApiServices.getUserPurchaseProductRequestHistory();
            if (res.success === true) {
                this.tableLoad = false;
                this.purchaseHistory = res.data;
            }
        },
        editItem(item) {
            this.editedIndex = this.purchaseHistory.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.purchaseHistory.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.brandDelete(this.editedItem.id);
            if (res.success === true) {
                this.purchaseHistory.splice(this.editedIndex, 1)
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
                let res = await ApiServices.brandEdit(this.editedItem.id, data);
                if (res.success === true) {
                    Object.assign(this.purchaseHistory[this.editedIndex], this.editedItem)
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
                    let res = await ApiServices.brandCreate(data);
                    if (res.success === true) {
                        this.purchaseHistory.push(this.editedItem);
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
