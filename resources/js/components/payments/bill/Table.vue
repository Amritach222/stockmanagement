<template>
    <v-card>
        <v-card-title>
            {{ $t('bills') }}
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="bills"
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
                    <v-dialog
                        v-model="dialog"
                        max-width="600px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <!--                            <v-btn-->
                            <!--                                color="green"-->
                            <!--                                dark-->
                            <!--                                class="mb-2"-->
                            <!--                                v-bind="attrs"-->
                            <!--                                v-on="on"-->
                            <!--                                :to="'/products/create'"-->
                            <!--                                v-if="$can('products.create')"-->
                            <!--                            >-->
                            <!--                                {{ $t('button.add_new_product') }}-->
                            <!--                            </v-btn>-->
                        </template>
                    </v-dialog>
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
            <template v-slot:item.purchase_order_id="{ item }">
                <p v-if="item.purchase_order_id">{{ item.purchase_order.reference }}</p>
                <p v-else>---</p>
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
            {text: i18n.t('purchase') + ' ' + i18n.t('order'), value: 'purchase_order_id'},
            {text: i18n.t('due_date'), value: 'due_date'},
            {text: i18n.t('grand_total'), value: 'grand_total'},
            {text: i18n.t('due_amount'), value: 'due_amount'},
            {text: i18n.t('status'), value: 'status'},
            {text: i18n.t('actions'), value: 'actions', sortable: false},
        ],
        bills: [],
        editedItem: {
            id: null,
            name: '',
            brand_id: '',
            category_id: '',
            details: '',
            is_active: '',
            image: [],
        },
        editedIndex: -1,
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
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadItems() {
            let res = await ApiServices.paymentIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.bills = res.data;
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
