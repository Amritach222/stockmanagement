<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol lg="12">
                    <CCardGroup>
                        <v-card width="100%" class="p-3">
                            <div id="invoiceholder">
                                <div id="invoice">
                                    <div id="invoice-top">
                                        <div class="logo">
                                            <img :src=cdnURL+settings.link width="100%" v-if="settings.link !== null"
                                                 alt="">
                                            <img src="http://michaeltruong.ca/images/logo1.png" v-else width="100%"
                                                 alt="">
                                        </div>
                                        <div class="info" style="margin-left: .8em;">
                                            <h2>{{ settings.title }}</h2>
                                        </div><!--End Info-->

                                        <div class="noprint ml-auto" v-if="payment.status === 'Pending'">
                                            <CButton size="sm" color="primary" @click="statusUpdate('Accepted')">Accept
                                            </CButton>
                                            <CButton size="sm" color="danger" @click="statusUpdate('Rejected')">Reject
                                            </CButton>
                                        </div><!--End Info-->

                                    </div><!--End InvoiceTop-->

                                    <div id="invoice-mid">
                                        <div class="info">
                                            <h2>{{ payment.reference_no }}</h2>
                                            <p>Street-14</p>
                                            <p>Pokhara, Gandaki, 33700</p>
                                            <p>061-534232, rkdholdings@gmail.com</p>
                                        </div>

                                    </div><!--End invoice Mid-->

                                    <div id="invoice-third">
                                        <div class="info">
                                            <h2>BILL TO</h2>
                                            <p>{{ vendor.name }}</p>
                                            <p>{{ vendor.company_name }}</p>
                                            <p>{{ getCityName(vendor) }}</p>
                                            <p>{{ vendor.mobile }}</p>
                                        </div>

                                        <div id="project">
                                            <!--                                            <h2>SHIP TO</h2>-->
                                            <!--                                            <p>Name/ Dept</p>-->
                                            <!--                                            <p>Client Company Name</p>-->
                                            <!--                                            <p>Address</p>-->
                                            <!--                                            <p>Phone</p>-->

                                        </div>
                                        <!-- ship -->

                                    </div><!--End invoice Mid-->


                                    <div id="invoice-bot" style="margin-top: 1.5em;">

                                        <div id="table">
                                            <table>
                                                <thead class="tabletitle">
                                                <td class="item"><h2> DESCRIPTION</h2></td>
                                                <td class="qty"><h2>QTY</h2></td>
                                                <td class="Rate"><h2>UNIT </h2></td>
                                                <td class="Rate"><h2>PRICE </h2></td>
                                                <td class="subtotal"><h2>SUB TOTAL</h2></td>
                                                <td class="subtotal"><h2>SHIPPING</h2></td>
                                                <td class="subtotal"><h2>TAX</h2></td>
                                                <td class="subtotal"><h2>DISCOUNT</h2></td>
                                                <td class="subtotal"><h2>TOTAL</h2></td>
                                                </thead>

                                                <tr class="service" v-for="item in poProducts"
                                                    :key='item._id'>
                                                    <td class="tableitem"><p class="itemtext">{{
                                                            item.product.name
                                                        }}</p></td>
                                                    <td class="tableitem"><p class="itemtext">{{
                                                            item.received_quantity
                                                        }}</p></td>
                                                    <td class="tableitem" v-if="item.unit_id"><p class="itemtext">
                                                        {{ item.unit.name }}</p></td>
                                                    <td class="tableitem" v-else><p class="itemtext">----</p></td>
                                                    <td class="tableitem"><p class="itemtext">Rs. {{ item.price }}</p>
                                                    </td>
                                                    <td class="tableitem"><p class="itemtext">Rs. {{ item.total }}</p>
                                                    </td>
                                                    <td class="tableitem"><p class="itemtext">Rs. {{
                                                            item.shipping_cost
                                                        }}</p>
                                                    </td>
                                                    <td class="tableitem" v-if="item.tax_id"><p class="itemtext">
                                                        {{ item.tax.value }}%</p>
                                                    </td>
                                                    <td class="tableitem" v-else><p class="itemtext">---</p>
                                                    </td>
                                                    <td class="tableitem"><p class="itemtext">{{ item.discount }}%</p>
                                                    </td>
                                                    <td class="tableitem"><p class="itemtext">Rs. {{
                                                            item.grand_total
                                                        }}</p>
                                                    </td>
                                                </tr>

                                                <tr class="service">
                                                    <td class="tableitem"><p class="itemtext"></p></td>
                                                    <td class="tableitem"><p class="itemtext"></p></td>
                                                    <td class="tableitem"><p class="itemtext"></p></td>
                                                    <td class="tableitem"><p class="itemtext"></p></td>
                                                    <td class="tableitem"><p class="itemtext"></p></td>
                                                    <td class="tableitem"><p class="itemtext"></p></td>
                                                    <td class="tableitem"><p class="itemtext"></p></td>
                                                    <td class="tableitem"><p class="itemtext"></p></td>
                                                </tr>


                                                <tr class="total">
                                                    <td colspan="7"></td>
                                                    <td>SUBTOTAL:</td>
                                                    <td>NPR. {{ payment.total }}</td>
                                                </tr>
                                                <tr class="total">
                                                    <td colspan="7"></td>
                                                    <td>DISCOUNT:</td>
                                                    <td v-if="payment.discount">{{ editedItem.discount }}%</td>
                                                    <td v-else>---</td>
                                                </tr>
                                                <tr class="total">
                                                    <td colspan="7"></td>
                                                    <td>TAX RATE:</td>
                                                    <td v-if="payment.tax_id">{{ editedItem.tax.value }}%</td>
                                                    <td v-else>---</td>
                                                </tr>
                                                <tr class="total">
                                                    <td colspan="7"></td>
                                                    <td>TOTAL TAX:</td>
                                                    <td></td>
                                                </tr>
                                                <tr class="total">
                                                    <td colspan="7"></td>
                                                    <td>GRAND TOTAL</td>
                                                    <td>NPR. {{ payment.grand_total }}</td>
                                                </tr>
                                                <tr class="total">
                                                    <td colspan="7"></td>
                                                    <td>BALANCE DUE</td>
                                                    <td>NPR. {{ payment.due_amount }}</td>
                                                </tr>
                                            </table>
                                        </div><!--End Table-->


                                    </div><!--End InvoiceBot-->
                                </div><!--End invoice-->
                            </div><!-- End invoice Holder-->
                        </v-card>

                    </CCardGroup>
                </CCol>
            </CRow>
        </CContainer>
    </div>
</template>
<script>
import config from "../../../config";
import ApiServices from "../../../services/ApiServices";
import i18n from "../../../i18n";
import store from "../../../store";

export default {
    name: "PurchaseOrderBill",
    data: () => ({
        cdnURL: config.cdnURL,
        dialogRegPayment: false,
        invoice: {
            amount: '',
            payment_type: '',
            description: '',
        },
        editedItem: {
            id: '',
        },
        poProducts: [],
        invoices: [],
        editPoProducts: [],
        validated: false,
        payment: {
            id: '',
            reference_no: '',
            purchase_order_id: '',
            due_date: '',
            created_by: '',
            total: '',
            tax_id: '',
            discount: '',
            grand_total: '',
            due_amount: '',
        },
        vendor: [],
        settings: {
            title: '',
            logo: '',
            currency: '',
            date_format: '',
            fiscal_year_id: '',
            time_zone: '',
        },
    }),
    async created() {
        let data = await this.loadData();
        let settings = await this.getSettings();
        // this.loadQuoProducts();
    },
    methods: {
        getCityName(item) {
            if (item.city !== null) return JSON.parse(item.city).name;
        },
        async loadData() {
            let res = await ApiServices.vendorPaymentShow(this.$route.params.id);
            if (res.success === true) {
                this.payment = res.data;
                this.invoices = res.data.invoices;
            }
            let rtn = await ApiServices.vendorPurchaseOrderShow(res.data.purchase_order_id);
            if (rtn.success === true) {
                this.editedItem = rtn.data;
                this.poProducts = rtn.data.purchase_order_products;
            }
            let ven = await ApiServices.getVendorData();
            if (ven.success === true) {
                this.vendor = ven.data;
            }
        },

        async getSettings() {
            let isLoggedIn = localStorage.getItem('isLoggedIn');
            if (isLoggedIn === 'true') {
                let res = await ApiServices.settingIndex();
                if (res.success === true) {
                    this.settings = res.data;
                }
            }
        },

        async statusUpdate(status) {
            const data = new FormData();
            data.append('status', status);

            let res = await ApiServices.vendorPaymentStatusUpdate(this.payment.id, data);
            this.changeProgress = false;
            if (res.success === true) {
                this.payment = res.data;
                store.state.home.snackbar = true;
                store.state.home.snackbarText = res.message;
                store.state.home.snackbarColor = 'green';
            } else {
                store.state.home.snackbar = true;
                store.state.home.snackbarText = res.message;
                store.state.home.snackbarColor = 'red';
            }
        },
    }
}
</script>
<style scoped>
body {
    /* background: #E0E0E0; */
    font-family: 'Roboto', sans-serif;
    background-size: 100%;
}

h2 {
    font-size: .9em;
    margin-bottom: .3em;
}

h3 {
    font-size: 1.2em;
    font-weight: 300;
    line-height: 2em;
}

p {
    font-size: .8em;
    color: #666;
    line-height: 1.4em;
}

#invoiceholder {
    width: 100%;
    height: 100%;
}

.logo {
    width: 66px;
}

#invoice {
    position: relative;
    /* margin: 30px auto; */
    width: 100%;
    /* padding: 0.5rem 1.5rem 0 1.5rem; */
}

[id*='invoice-'] { /* Targets all id with 'col-' */
    border-bottom: 1px solid #EEE;
}

#invoice-top {
    min-height: 96px;
    display: flex;
    align-items: center;
}

#invoice-mid {
    min-height: 136px;
}

#invoice-third {
    min-height: 160px;
}

#invoice-bot {
    min-height: 250px;
}

.info {
    display: block;
    float: left;
}

.title {
    float: right;
}

.title p {
    text-align: right;
}

#project {
    margin-left: 77%;
}

table {
    width: 100%;
    border-collapse: collapse;
}

td {
    padding: 5px 15px 5px 15px;
    border: 1px solid #EEE;
}

.service {
    border: 1px solid #EEE;
    height: 35px;
}

.item {
    width: 30%;
}

.itemtext {
    font-size: .9em;
}

@media print and (color) {
    * {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .noprint {
        visibility: hidden;
    }
}

.card-btn {
    color: #fff !important;
    margin-left: 3px !important;
}
</style>
