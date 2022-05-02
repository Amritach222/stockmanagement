<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol lg="12">
                    <div v-for="invoiceData in invoices">
                        <v-card :id="'invoice-'+invoiceData.id"
                                :key='invoiceData._id' width="100%" class="mt-3 p-4">
                            <v-card-title>
                                Receipt No.: {{ invoiceData.reference_no }}
                                <v-spacer></v-spacer>
                                <div class="noprint ml-auto">
                                    <CButton size="sm" color="success" @click="printInvoice(invoiceData.id)">Print
                                        Invoice
                                    </CButton>
                                </div>
                            </v-card-title>
                            <div class="invoice-container">
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
                                </div><!--End InvoiceTop-->

                                <div id="invoice-mid">

                                    <div class="info">
                                        <h2>{{ payment.reference_no }}</h2>
                                        <p class="mt-1">Street-14</p>
                                        <p>Pokhara, Gandaki, 33700</p>
                                        <p>061-534232, rkdholdings@gmail.com</p>
                                    </div>

                                    <div id="project">
                                        <!-- <h2>SHIP TO</h2> -->
                                        <h2>{{ vendor.name }}</h2>
                                        <p>{{ vendor.company_name }}</p>
                                        <p>{{ vendor.address }}</p>
                                        <p>{{ vendor.mobile }}</p>
                                        <p>{{ vendor.vat_no }}</p>
                                    </div>
                                    <!-- ship -->
                                </div>
                                <table class="invoice">
                                    <thead>
                                    <tr><h2 style="text-align: left;">Invoice <span>{{
                                            invoiceData.reference_no
                                        }}</span></h2></tr>
                                    <tr>
                                        <th class="desc"><h2>Invoice Date</h2></th>
                                        <th class="id"><h2>Due Date</h2></th>
                                        <th class="qty"><h2>Source</h2></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="item">
                                        <td class="desc">{{ invoiceData.creation_date }}</td>
                                        <td class="id num">01/24/2022</td>
                                        <td class="qty">S000</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table style="margin-top: 35px;  border-collapse: initial !important;">
                                    <thead>
                                    <tr>
                                        <td class="desc"><h2> DESCRIPTION</h2></td>
                                        <td class="qty"><h2>QTY</h2></td>
                                        <td class="amt"><h2>UNIT </h2></td>
                                        <td class="amt"><h2>PRICE </h2></td>
                                        <td class="amt"><h2>SUB TOTAL</h2></td>
                                        <td class="amt"><h2>SHIPPING</h2></td>
                                        <td class="amt"><h2>TAX</h2></td>
                                        <td class="amt"><h2>DISCOUNT</h2></td>
                                        <td class="amt"><h2>TOTAL</h2></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="item" v-for="item in poProducts"
                                        :key='item._id'>
                                        <td class="desc">{{
                                            item.product.name
                                            }}
                                        </td>
                                        <td class="id num">{{
                                            item.received_quantity
                                            }}
                                        </td>
                                        <td class="qty" v-if="item.unit_id">
                                            {{ item.unit.name }}
                                        </td>
                                        <td class="qty" v-else>----</td>
                                        <td class="price">Rs. {{ item.price }}
                                        </td>
                                        <td class="tex">Rs. {{ item.total }}
                                        </td>
                                        <td class="amt">Rs. {{
                                            item.shipping_cost
                                            }}
                                        </td>
                                        <td class="amt" v-if="item.tax_id">
                                            {{ item.tax.value }}%
                                        </td>
                                        <td class="amt" v-else>---
                                        </td>
                                        <td class="amt">{{ item.discount }}%
                                        </td>
                                        <td class="amt">Rs. {{
                                            item.grand_total
                                            }}
                                        </td>
                                    </tr>

                                    <tr class="subtotal">
                                        <td colspan="7"></td>
                                        <td class="num">Subtotal</td>
                                        <td class="num">NPR. {{ payment.total }}</td>
                                    </tr>
                                    <tr class="total">
                                        <td colspan="7"></td>
                                        <td>Total</td>
                                        <td>NPR. {{ payment.grand_total }}</td>
                                    </tr>
                                    <tr class="fees" style="font-style: italic;">
                                        <td colspan="7"></td>
                                        <td><p>Paid on {{ invoiceData.creation_date }}</p></td>
                                        <td><p>NPR. {{ invoiceData.amount }}</p></td>
                                    </tr>
                                    <tr class="total" style="font-style: italic;">
                                        <td colspan="7"></td>
                                        <td>Amount Due</td>
                                        <td>NPR. {{ invoiceData.due_amount + '.00' }}</td>
                                    </tr>
                                    </tbody>
                                </table>

                                <section class="additional-info">
                                    <p>Please use the following communication for your payment:
                                        <span>{{ invoiceData.reference_no }}</span>
                                    </p>
                                </section>
                            </div>
                        </v-card>
                    </div>
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
            async loadData() {
                let res = await ApiServices.paymentShow(this.$route.params.id);
                if (res.success === true) {
                    this.payment = res.data;
                    this.invoices = res.data.invoices;
                    let due = await this.getInvoiceDueAmount();
                    let rtn = await ApiServices.purchaseOrderShow(res.data.purchase_order_id);
                    if (rtn.success === true) {
                        this.editedItem = rtn.data;
                        this.poProducts = rtn.data.purchase_order_products;
                        let ven = await ApiServices.vendorShow(rtn.data.vendor_id);
                        if (ven.success === true) {
                            this.vendor = ven.data;
                        }
                    }
                }
            },

            async getInvoiceDueAmount() {
                var due_amount = this.payment.grand_total;
                for (var i = 0; i < this.invoices.length; i++) {
                    this.invoices[i].due_amount = due_amount - this.invoices[i].amount;
                    due_amount = this.invoices[i].due_amount;
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

            async printInvoice(id) {
                var element = document.getElementById("invoice-" + id);
                element.classList.remove("noprint");
                for (var i = 0; i < this.invoices.length; i++) {
                    if (id !== this.invoices[i].id) {
                        var invoice = document.getElementById("invoice-" + this.invoices[i].id);
                        invoice.classList.add("noprint");
                    }
                }
                window.print();
            },
        }
    }
</script>
<style scoped>

    .card-btn {
        color: #fff !important;
        margin-left: 3px !important;
    }

    body {
        font-family: 'Roboto', sans-serif;
        font-weight: 400;
        color: #322d28;
    }

    .invoice-container {
        background: #fff;
        width: 100%;
        /* margin: 30px auto; */
        /* padding: 0.5rem 1.5rem 0 1.5rem; */
    }

    [id*='invoice-'] {
        border-bottom: 1px solid #EEE;
    }

    .info {
        display: block;
        float: left;
    }

    #invoice-top {
        min-height: 85px;
        display: flex;
        align-items: center;
    }

    /* #invoice-mid {
        min-height: 120px;
    } */
    #project {
        margin-left: 77%;
    }

    header.top-bar h1 {
        font-family: "Montserrat", sans-serif;
    }

    .logo {
        width: 66px;
    }

    table {
        background: #fff;
        width: 100%;
        border-collapse: initial !important;
    }

    table.invoice .num {
        font-weight: 200;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 0.8em;
    }

    table.invoice tr, table.invoice td {
        background: #fff;
        text-align: left;
        font-weight: 400;
        color: #322d28;
        width: 345px;
    }

    table.invoice tr.header td img {
        max-width: 300px;
    }

    table.invoice tr.header td h2 {
        text-align: right;
        font-family: "Montserrat", sans-serif;
        font-weight: 200;
        font-size: 2rem;
        color: #1779ba;
    }

    table.invoice tr.intro td:nth-child(2) {
        text-align: left;
    }

    table.invoice tr.details > td {
        padding-top: 1rem;
        padding-bottom: 0;
    }

    table.invoice tr.details td:last-child, table.invoice tr.details th:last-child {
        text-align: right;
    }

    table.invoice tr.details table thead, table.invoice tr.details table tbody {
        position: relative;
    }

    table.invoice tr.details table thead:after, table.invoice tr.details table tbody:after {
        content: "";
        height: 1px;
        position: absolute;
        width: 100%;
        left: 0;
        margin-top: -1px;
        background: #c8c3be;
    }

    table.invoice tr.totals td {
        padding-top: 0;
    }

    table.invoice tr.totals table tr td {
        padding-top: 0;
        padding-bottom: 0.5EM;
    }

    table.invoice tr.totals table tr td:nth-child(1) {
        font-weight: 500;
    }

    table.invoice tr.totals table tr td:nth-child(2) {
        text-align: right;
        font-weight: 200;
    }

    table.invoice tr.totals table tr:nth-last-child(2) td {
        padding-bottom: 0.5em;
    }

    table.invoice tr.totals table tr:nth-last-child(2) td:last-child {
        position: relative;
    }

    table.invoice tr.totals table tr:nth-last-child(2) td:last-child:after {
        content: "";
        height: 4px;
        width: 100%;
        border-top: 1px solid #1779ba;
        border-bottom: 1px solid #1779ba;
        position: relative;
        right: 0;
        bottom: -0.575rem;
        display: block;
    }

    table.invoice tr.totals table tr.total td {
        font-size: 1em;
        padding-top: 0.5em;
        font-weight: 700;
    }

    table.invoice tr.totals table tr.total td:last-child {
        font-weight: 700;
    }

    .additional-info h5 {
        font-size: 0.8em;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #1779ba;
    }

    h2 {
        font-size: .9em;
        margin-bottom: .3em;
    }

    p {
        font-size: .8em;
        color: #666;
        line-height: 1em;
    }

    span {
        color: #1413115e;
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
</style>
