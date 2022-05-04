<template>
    <v-card>
        <v-card-title>
            {{ $t('invoices') }}
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="invoices"
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
                                :label="$t('search')"
                                solo
                                hide-details
                                max-width="100px"
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-dialog v-model="dialogDelete" max-width="500px">
                        <v-card>
                            <v-card-title class="text-h6">{{ $t('message.delete') }}</v-card-title>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="closeDelete">{{ $t('button.cancel') }}</v-btn>
                                <v-btn color="blue darken-1" text @click="deleteItemConfirm">{{
                                        $t('button.confirm')
                                    }}
                                </v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>
            <template v-slot:item.payment_id="{ item }">
                <p v-if="item.payment_id" class="mt-3">{{ item.payment_reference }}</p>
                <p v-else class="mt-3">----</p>
            </template>
            <template v-slot:item.issued_by="{ item }">
                <p v-if="item.issued_by" class="mt-3">{{ item.issuer.name }}</p>
                <p v-else class="mt-3">----</p>
            </template>
            <template v-slot:item.paid_to="{ item }">
                <p v-if="item.paid_to" class="mt-3">{{ item.vendor.name }}</p>
                <p v-else class="mt-3">----</p>
            </template>
            <template v-slot:item.actions="{ item }">
                <router-link
                    :to="'/products/'+item.id"
                    v-if="$can('products.show')"
                >
                    <v-icon
                        small
                    >
                        mdi-eye
                    </v-icon>
                </router-link>
                <v-icon
                    small
                    @click="deleteItem(item)"
                    v-if="$can('products.delete')"
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
import store from "../../../store";
import i18n from "../../../i18n";
import ApiServices from "../../../services/ApiServices";

export default {
    name: "TableWrapper",
    data: () => ({
        cdnURL: config.cdnURL,
        baseURL: config.baseURL,
        search: '',
        validated: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        headers: [
            {text: i18n.t('id'), align: 'start', sortable: true, value: 'id'},
            {text: i18n.t('reference') + ' ' + i18n.t('no.'), value: 'reference_no'},
            {text: i18n.t('payment') + ' ' + i18n.t('reference'), value: 'payment_id'},
            {text: i18n.t('amount'), value: 'amount'},
            {text: i18n.t('issued_by'), value: 'issued_by', sortable: false},
            {text: i18n.t('paid_to'), value: 'paid_to', sortable: false},
            {text: i18n.t('payment_type'), value: 'payment_type'},
            {text: i18n.t('actions'), value: 'actions', sortable: false},
        ],
        invoices: [],
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
        tableLoad: true
    }),

    watch: {
        dialogDelete(val) {
            val || this.closeDelete()
        },
    },

    async created() {
        this.loadItems();
    },

    methods: {
        async loadItems() {
            let res = await ApiServices.invoiceIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.invoices = res.data;
            }
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

        closeDelete() {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },
    },
}
</script>


<style scoped>

</style>
