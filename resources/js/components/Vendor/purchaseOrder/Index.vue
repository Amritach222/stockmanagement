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
                            class="d-flex flex-row justify-content-between align-items-center"
                        >
                            <v-text-field
                                v-model="search"
                                append-icon="mdi-magnify"
                                :label="$t('search')"
                                solo
                                hide-details
                                max-width="100px"
                            ></v-text-field>
                            <v-btn class="px-2 ml-2 cursor-pointer" @click="openFilter"
                            ><v-icon>mdi-filter-outline</v-icon>{{dialogFilter?'Hide Filter':'Show Filter'}}</v-btn
                            >
                        </v-col>
                    </v-row>
                </v-toolbar>
                <v-expand-transition>
                    <div v-if="dialogFilter==true"
                         :style="{background:'#ebedef', width:'100%'}"
                         transition="scroll-y-transition">
                        <v-card-title class="text-h6">Filters</v-card-title>
                        <v-card-text>
                            <v-form>
                                <v-row>
                                    <v-col
                                        lg="2"
                                        xl="2"
                                        md="2"
                                        sm="2"
                                        xs="10"
                                    >
                                        <b>Choose Status</b>
                                        <v-row>

                                            <v-col >
                                                <v-checkbox
                                                    v-model="status"
                                                    :label="$t('Approved')"
                                                    color="red"
                                                    value="Approved"
                                                    hide-details
                                                    :style="{width: 'fit-content'}"
                                                >Approved</v-checkbox>
                                                <v-checkbox
                                                    v-model="status"
                                                    :label="$t('Received')"
                                                    color="red"
                                                    value="Reviewed"
                                                    hide-details
                                                    :style="{width: 'fit-content'}"
                                                >Reviewed</v-checkbox>
                                                <v-checkbox
                                                    v-model="status"

                                                    :label="$t('Pending')"
                                                    color="red"
                                                    value="Pending"
                                                    hide-details
                                                    :style="{width: 'fit-content'}"
                                                >Pending</v-checkbox>
                                                <v-checkbox
                                                    v-model="status"
                                                    :label="$t('Rejected')"
                                                    color="red"
                                                    value="Cancelled"
                                                    hide-details
                                                    :style="{width: 'fit-content'}"
                                                >Rejected</v-checkbox>
                                            </v-col>
                                        </v-row>
                                    </v-col>
                                    <v-spacer></v-spacer>
                                    <!--                                   Other filter here-->
                                </v-row>
                                <v-row>

                                    <v-col md="4"
                                           lg="4"
                                           xl="4"
                                           sm="4"
                                           xs="10"
                                    >
                                        <div class="delivery_title">
                                            <b>Date of order</b>
                                        </div>
                                        <div class="order_content">
                                            <v-menu class="date_container"
                                                    :close-on-content-click="true"
                                                    transition="scale-transition"
                                                    offset-y
                                                    max-width="290px"
                                                    min-width="auto"
                                            >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field
                                                        v-model="order_from"
                                                        placeholder="From"
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        solo
                                                    ></v-text-field>
                                                </template>
                                                <v-date-picker
                                                    v-model="order_from"
                                                    no-title
                                                ></v-date-picker>
                                            </v-menu>
                                            <v-menu
                                                :close-on-content-click="true"
                                                transition="scale-transition"
                                                offset-y
                                                max-width="290px"
                                                min-width="auto"
                                            >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field
                                                        v-model="order_to"
                                                        placeholder="To"
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        solo
                                                    ></v-text-field>
                                                </template>
                                                <v-date-picker
                                                    v-model="order_to"
                                                    no-title
                                                ></v-date-picker>
                                            </v-menu>
                                            <CButton
                                                size="sm"
                                                color="danger"
                                                :style="{float:'right'}"
                                                v-on:click="resetDate('delivery')"
                                            >
                                                Reset
                                            </CButton>
                                        </div>

                                    </v-col>
                                    <v-spacer></v-spacer>
                                    <v-col md="4"
                                           lg="4"
                                           xl="4"
                                           sm="4"
                                           xs="10">
                                        <div class="create_title">
                                            <b>Created Date</b>
                                        </div>
                                        <div class="create_content">
                                            <v-menu
                                                :close-on-content-click="true"
                                                transition="scale-transition"
                                                offset-y
                                                max-width="290px"
                                                min-width="auto"
                                            >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field
                                                        v-model="created_from"
                                                        placeholder="From"
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        solo
                                                    ></v-text-field>
                                                </template>
                                                <v-date-picker
                                                    v-model="created_from"
                                                    no-title
                                                ></v-date-picker>
                                            </v-menu>

                                            <v-menu
                                                :close-on-content-click="true"
                                                transition="scale-transition"
                                                offset-y
                                                max-width="290px"
                                                min-width="auto"
                                            >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field
                                                        v-model="created_to"
                                                        placeholder="From"
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        solo
                                                    ></v-text-field>
                                                </template>
                                                <v-date-picker
                                                    v-model="created_to"
                                                    no-title
                                                ></v-date-picker>
                                            </v-menu>
                                            <CButton
                                                size="sm"
                                                color="danger"
                                                :style="{float:'right'}"
                                                v-on:click="resetDate('created')"
                                            >
                                                Reset
                                            </CButton>
                                        </div>
                                    </v-col>
                                </v-row>

                            </v-form>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <button type="button" class="btn btn-outline-danger " @click="closeFilter">Cancel</button>
                            <button type="button" class="btn btn-outline-success ml-2 " @click="">Apply</button>
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </div>
                </v-expand-transition>
            </template>
            <template v-slot:item.status="{ item }">
                <div v-if="item.status === 'On Progress'">
                    <CButton size="sm" color="warning" class="m-1">
                        On Progress
                    </CButton>
                </div>
                <div v-else-if="item.status === 'Pending'">
                    <CButton size="sm" color="secondary" class="m-1">
                        Pending
                    </CButton>
                </div>
                <div v-else-if="item.status === 'Rejected'">
                    <CButton size="sm" class="m-1" color="danger"
                    >
                        Rejected
                    </CButton>
                </div>
                <div v-else-if="item.status === 'Cancelled'">
                    <CButton size="sm" class="m-1" color="danger"
                    >
                        Cancelled
                    </CButton>
                </div>
                <div v-else-if="item.status === 'Approved'">
                    <CButton size="sm" class="m-1" color="success"
                    >
                        Approved
                    </CButton>
                </div>
                <div v-else-if="item.status === 'Accepted'">
                    <CButton size="sm" class="m-1" color="primary">
                        Accepted
                    </CButton>
                </div>
                <div v-else>
                    <CButton size="sm" class="m-1" color="warning">
                        {{ item.status }}
                    </CButton>
                </div>
            </template>
            <template v-slot:item.actions="{ item }">
                <CRow>
                    <router-link
                        :to="'/vendor/purchase-order/show/'+item.id"
                    >
                        <v-icon
                            small
                        >
                            mdi-eye
                        </v-icon>
                    </router-link>
                    <router-link
                        :to="'/vendor/purchase-order/edit/'+item.id"
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
        status:[],
        cdnURL: config.cdnURL,
        baseURL: config.baseURL,
        validated: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        singleSelect: false,
        dialogFilter: false,
        order_from: "",
        order_to: "",
        created_from: "",
        created_to: "",
        user: {
            id: null,
        },
        headers: [
            // {text: i18n.t('id'), align: 'start', sortable: true, value: 'id'},
            {text: i18n.t('reference'), value: 'reference'},
            {text: i18n.t('date') + ' ' + i18n.t('of') + ' ' + i18n.t('order'), value: 'date_of_order'},
            {text: i18n.t('location'), value: 'location'},
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
            let res = await ApiServices.vendorPurchaseOrderList();
            if (res.success === true) {
                this.tableLoad = false;
                this.requestProposals = res.data;
            }
        },
        // open filter method here which toggle the filter button
        openFilter() {
            this.dialogFilter = !this.dialogFilter;
        },
        //This method for closing filter on clicking cancel button
        closeFilter() {
            this.dialogFilter = false;
        },
        //  This method for applying filter to the datatable
        async filterItemConfirm() {
            const data = new FormData();
            if (this.status !== null && this.status !== []) {
                data.append("status", JSON.stringify(this.status));
            }
            if (this.department_ids !== null && this.department_ids !== []) {
                data.append("department_ids", JSON.stringify(this.department_ids));
            }
            if (this.vendor_ids !== null && this.vendor_id !== "") {
                data.append("vendor_id", this.vendor_id);
            }
            if (this.delivery_from !== null && this.delivery_from !== "") {
                data.append("delivery_from", this.delivery_from);
            }
            if (this.delivery_to !== null && this.delivery_to !== "") {
                data.append("delivery_to", this.delivery_to);
            }
            if (this.created_from !== null && this.created_from !== "") {
                data.append("created_from", this.created_from);
            }
            if (this.created_to !== null && this.created_to !== "") {
                data.append("created_to", this.created_to);
            }

            let res = await ApiServices.quotationFilter(data);
            if (res.success === true) {
                this.quotations = res.data;
            } else {
                store.state.home.snackbar = true;
                store.state.home.snackbarText = res.message;
                store.state.home.snackbarColor = "red";
            }
            this.closeFilter();
        },
        // Reset date function
        async resetDate(type) {
            if (type === "delivery") {
                this.order_from = "";
                this.order_to = "";
            } else {
                this.created_from = "";
                this.created_to = "";
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
