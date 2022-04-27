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

                                        <div class="noprint ml-auto">
                                            <CButton size="sm" color="success" @click="openInvoice">Register Payment
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

                                    </div><!--End Invoice Mid-->

                                    <div id="invoice-third">
                                        <div class="info">
                                            <h2>BILL TO</h2>
                                            <p>{{ vendor.name }}</p>
                                            <p>{{ vendor.company_name }}</p>
                                            <p>{{ vendor.address }}</p>
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

                                    </div><!--End Invoice Mid-->


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
                                </div><!--End Invoice-->
                            </div><!-- End Invoice Holder-->
                        </v-card>

                        <v-dialog
                            v-model="dialogRegPayment"
                            max-width="850px"
                            max-height="450px"
                        >
                            <v-card>
                                <v-card-title>
                                    Register Payment
                                    <v-spacer></v-spacer>
                                </v-card-title>

                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <v-col>
                                                <v-select
                                                    v-model="invoice.payment_type"
                                                    :label="$t('payment') + ' ' + $t('type')"
                                                    :items="['Cash','Online Payment']"
                                                    required
                                                    outlined
                                                ></v-select>
                                                <v-text-field
                                                    v-model="invoice.amount"
                                                    :label="$t('amount')"
                                                    type="number"
                                                    outlined
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-card-text>

                                <v-row class="m-4 d-flex justify-content-end">
                                    <v-card-actions>
                                        <v-btn
                                            color="blue darken-1"
                                            class="btn btn-danger card-btn"
                                            text
                                            @click="closeRegPayment"
                                        >
                                            {{ $t('button.cancel') }}
                                        </v-btn>
                                        <v-btn
                                            color="blue darken-1"
                                            class="btn btn-primary card-btn"
                                            text
                                            @click="createInvoice"
                                        >
                                            {{ $t('button.submit') }}
                                        </v-btn>
                                    </v-card-actions>
                                </v-row>
                            </v-card>
                        </v-dialog>
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

export default {
    name: "PurchaseOrderBill",
    data: () => ({
        cdnURL: config.cdnURL,
        dialogRegPayment: false,
        invoice: {
            amount: '',
            payment_type: '',
        },
        editedItem: {
            id: '',
        },
        poProducts: [],
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
        async loadData() {
            let res = await ApiServices.paymentShow(this.$route.params.id);
            if (res.success === true) {
                this.payment = res.data;
            }
            let rtn = await ApiServices.purchaseOrderShow(res.data.purchase_order_id);
            if (rtn.success === true) {
                this.editedItem = rtn.data;
                this.poProducts = rtn.data.purchase_order_products;
            }
            let ven = await ApiServices.vendorShow(rtn.data.vendor_id);
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

        async openInvoice() {
            this.dialogRegPayment = true;
            this.invoice.amount = this.payment.due_amount;
        },

        async closeRegPayment() {
            this.dialogRegPayment = false;
        },

        async createInvoice() {
            this.validate();
            if(this.validated === true){
                const data = new FormData();
                data.append('amount', this.invoice.amount);
                data.append('payment_type', this.invoice.payment_type);
                data.append('payment_id', this.$route.params.id);
                let res = await ApiServices.invoiceCreate();
                if (res.success === true) {
                    this.payment = res.data;
                    this.dialogRegPayment=false;
                }
            }
        },

        async validate() {
            if (this.invoice.amount > 0) {
                this.validated = true;
            } else {
                this.validated = false;
            }
            if (this.invoice.payment_type !== null) {
                this.validated = true;
            } else {
                this.validated = false;
            }
        }
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
