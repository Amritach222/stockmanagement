<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <div id="invoiceholder">
                            <div id="invoice">
                                <div id="invoice-top">
                                    <div class="logo">
                                        <img src="http://michaeltruong.ca/images/logo1.png" width="100%" alt="">
                                    </div>
                                    <div class="info" style="margin-left: .8em;">
                                        <h2>RKD Holdings</h2>
                                    </div><!--End Info-->

                                </div><!--End InvoiceTop-->


                                <div id="invoice-mid">
                                    <div class="info">
                                        <h2>Your Company Name</h2>
                                        <p>Street Address
                                        <p>City, State, Zip/Post Code</p>
                                        <p>Phone Number, Email</p>
                                    </div>

                                </div><!--End Invoice Mid-->

                                <div id="invoice-third">
                                    <div class="info">
                                        <h2>BILL TO</h2>
                                        <p>Contact Name </p>
                                        <p>Client Company Name</p>
                                        <p>Address</p>
                                        <p>Phone</p>
                                    </div>

                                    <div id="project">
                                        <h2>SHIP TO</h2>
                                        <p>Name/ Dept</p>
                                        <p>Client Company Name</p>
                                        <p>Address</p>
                                        <p>Phone</p>

                                    </div>
                                    <!-- ship -->

                                </div><!--End Invoice Mid-->


                                <div id="invoice-bot" style="margin-top: 1.5em;">

                                    <div id="table">
                                        <table>
                                            <tr class="tabletitle">
                                                <th class="item"><h2> DESCRIPTION</h2></th>
                                                <th class="qty"><h2>QTY</h2></th>
                                                <th class="Rate"><h2>UNIT </h2></th>
                                                <th class="Rate"><h2>PRICE </h2></th>
                                                <th class="subtotal"><h2>TOTAL</h2></th>
                                            </tr>

                                            <tr class="service" v-for="item in poProducts"
                                                :key='item._id'>
                                                <td class="tableitem"><p class="itemtext">{{ item.product.name }}</p></td>
                                                <td class="tableitem"><p class="itemtext">{{ item.received_quantity }}</p></td>
                                                <td class="tableitem" v-if="item.unit_id"><p class="itemtext">{{ item.unit.name }}</p></td>
                                                <td class="tableitem" v-else><p class="itemtext">----</p></td>
                                                <td class="tableitem"><p class="itemtext">Rs. {{ item.price }}</p></td>
                                                <td class="tableitem"><p class="itemtext">Rs. {{ item.total }}</p></td>
                                            </tr>

                                            <tr class="service">
                                                <td class="tableitem"><p class="itemtext"></p></td>
                                                <td class="tableitem"><p class="itemtext"></p></td>
                                                <td class="tableitem"><p class="itemtext"></p></td>
                                                <td class="tableitem"><p class="itemtext"></p></td>
                                                <td class="tableitem"><p class="itemtext"></p></td>
                                            </tr>


                                            <tr class="total">
                                                <td colspan="3"></td>
                                                <td>SUBTOTAL:</td>
                                                <td>{{ editedItem.total }}</td>
                                            </tr>
                                            <tr class="total">
                                                <td colspan="3"></td>
                                                <td>DISCOUNT:</td>
                                                <td>{{ editedItem.discount }}</td>
                                            </tr>
                                            <tr class="total">
                                                <td colspan="3"></td>
                                                <td>TAX RATE:</td>
                                                <td v-if="editedItem.tax_id">{{ editedItem.tax.value }}%</td>
                                                <td v-else>---</td>
                                            </tr>
                                            <tr class="total">
                                                <td colspan="3"></td>
                                                <td>TOTAL TAX:</td>
                                                <td></td>
                                            </tr>
                                            <tr class="total">
                                                <td colspan="3"></td>
                                                <td>SHIPPING/HANDLING</td>
                                                <td></td>
                                            </tr>
                                            <tr class="total">
                                                <td colspan="3"></td>
                                                <td>BALANCE DUE</td>
                                                <td>NPR. {{ payment.due_amount }}</td>
                                            </tr>
                                        </table>
                                    </div><!--End Table-->


                                </div><!--End InvoiceBot-->
                            </div><!--End Invoice-->
                        </div><!-- End Invoice Holder-->
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
            editedItem: [],
            poProducts: [],
            editPoProducts: [],
            payment: [],
        }),
        async created() {
            let data = await this.loadData();
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
                    this.payment = rtn.data;
                    this.poProducts = rtn.data.purchase_order_products;
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
        width: 50%;
    }

    .itemtext {
        font-size: .9em;
    }

    @media print and (color) {
        * {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>
