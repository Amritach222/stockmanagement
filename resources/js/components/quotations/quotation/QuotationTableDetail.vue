<template>
    <div>
        <table class="table table-striped">
            <tbody>
            <tr>
                <td>
                    <button><b>#{{ item.reference_no }}</b></button>
                </td>
                <td>{{ item.details }}</td>
                <td v-if="item.approved_by">Approved By: {{ item.approver.name }}</td>
                <td v-else>Approved By: ---</td>
            </tr>
            <tr>
                <td>Line Items: {{ item.total_item }}</td>
                <td>Due Date: {{ item.due_date }}</td>
                <td>Desired Delivery Date: {{ item.desired_delivery_date }}</td>
            </tr>
            <tr>
                <td>File link:
                    <button v-if="item.link !== 'Not Found'" v-on:click="openImage(item.link)">
                        Click to Open
                    </button>
                    <button v-else>No file</button>
                </td>
                <td>Department: {{ item.department.name }}</td>
                <td>Status: <CButton size="sm" :color="getColor(item.status)">{{ item.status }}</CButton></td>
            </tr>
            </tbody>
        </table>
        <QuotationProductDetails :details="item.quotation_products" ref="quotationProductDetails"></QuotationProductDetails>
    </div>
</template>

<script>
    import config from "../../../config";
    import QuotationProductDetails from "./QuotationProductDetails";

    export default {
        name: "QuotationTableDetail",
        components: {QuotationProductDetails},
        props: ['item','triggerSelect'],
        data: () => ({
            cdnURL: config.cdnURL,
            triggerSelectProduct: false
        }),
        watch: {
            triggerSelect: function(newVal, oldVal) {
                this.triggerSelectProduct = !this.triggerSelectProduct;
            }
        },
        methods: {
            openImage(data) {
                window.open(this.cdnURL + data, `_blank`);
            },
            sendQP(){
              this.$refs.quotationProductDetails.sendQPtoPO();
            },
            getColor(status) {
                if (status === 'Pending') return 'warning'
                else if (status === 'Rejected') return 'danger'
                else return 'success'
            },
        }
    }
</script>

<style scoped>
</style>
