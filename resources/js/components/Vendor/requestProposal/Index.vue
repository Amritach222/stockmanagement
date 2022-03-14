<template>
    <v-card>
        <v-card-title>
            {{ $t('request') + ' ' + $t('products') }}
            <v-spacer></v-spacer>
            <!--            <v-card-actions>-->
            <!--                <v-btn-->
            <!--                    class="btn-primary m-1 btn-back"-->
            <!--                    text-->
            <!--                    :to="'/vendor/add-product-list'"-->
            <!--                >-->
            <!--                    {{ $t('button.edit_product_list') }}-->
            <!--                </v-btn>-->
            <!--            </v-card-actions>-->
        </v-card-title>
        <v-data-table
            item-key="name"
            class="elevation-1"
            :headers="headers"
            :items="requestProposals"
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
                        <!--                        <v-col-->
                        <!--                            cols="12"-->
                        <!--                            sm="2"-->
                        <!--                            md="3"-->
                        <!--                            lg="4"-->
                        <!--                        >-->
                        <!--                        </v-col>-->
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
            <template v-slot:item.status="{ item }">
                <div v-if="item.vendor_quotation.status === 'On Progress'">
                    <CButton size="sm" color="warning" class="m-1">
                        On Progress
                    </CButton>
                </div>
                <div v-else-if="item.vendor_quotation.status === 'Pending'">
                    <CButton size="sm" color="secondary" class="m-1">
                        Pending
                    </CButton>
                </div>
                <div v-else-if="item.vendor_quotation.status === 'Rejected'">
                    <CButton size="sm" class="m-1" color="danger"
                    >
                        Rejected
                    </CButton>
                </div>
                <div v-else-if="item.vendor_quotation.status === 'Cancelled'">
                    <CButton size="sm" class="m-1" color="danger"
                    >
                        Cancelled
                    </CButton>
                </div>
                <div v-else-if="item.vendor_quotation.status === 'Approved'">
                    <CButton size="sm" class="m-1" color="success"
                    >
                        Approved
                    </CButton>
                </div>
                <div v-else-if="item.vendor_quotation.status === 'Accepted'">
                    <CButton size="sm" class="m-1" color="primary">
                        Accepted
                    </CButton>
                </div>
            </template>
            <template v-slot:item.actions="{ item }">
                <CRow>
                    <router-link
                        :to="'/vendor/product-request/'+item.id"
                    >
                        <v-icon
                            small
                        >
                            mdi-eye
                        </v-icon>
                    </router-link>
                    <router-link
                        :to="'/vendor/product-request/edit/'+item.id"
                    >
                        <v-icon
                            small
                            class="mr-2"
                        >
                            mdi-pencil
                        </v-icon>
                    </router-link>
                </CRow>
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
    name: "VendorProductRequests",
    data: () => ({
        search: '',
        cdnURL: config.cdnURL,
        baseURL: config.baseURL,
        validated: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        singleSelect: false,
        user: {
            id: null,
        },
        headers: [
            // {text: i18n.t('id'), align: 'start', sortable: true, value: 'id'},
            {text: i18n.t('reference'), value: 'reference_no'},
            {text: i18n.t('due') + ' ' + i18n.t('date'), value: 'due_date_format'},
            {text: i18n.t('desired') + ' ' + i18n.t('delivery') + ' ' + i18n.t('date'), value: 'desired_delivery_date_format'},
            {text: i18n.t('status'), value: 'status'},
            {text: i18n.t('actions'), value: 'actions', sortable: false},
        ],
        activePassive: [
            {text: 'Active', value: 1},
            {text: 'Inactive', value: 0},
        ],
        requestProposals: [],
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
            let res = await ApiServices.vendorQuotationList();
            if (res.success === true) {
                this.tableLoad = false;
                this.requestProposals = res.data;
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
