<template>
    <div>
        <table class="table table-striped">
            <tbody>
            <tr>
                <td>
                    <button><b>#{{ item.reference_no }}</b></button>
                </td>
                <td>{{ item.details }}</td>
                <td>Approved By: {{ item.approved_by }}</td>
            </tr>
            <tr>
                <td>Line Items: {{ item.total_item }}</td>
                <td>Due Date: {{ item.due_date }}</td>
                <td>Status: <CButton size="sm" :color="getColor(item.status)">{{ item.status }}</CButton></td>
            </tr>
            <tr>
                <td>File link:
                    <button v-if="item.file_link !== 'Not Found'" v-on:click="openImage(item.file_link)">
                        Click to Open
                    </button>
                    <button v-else>No file</button>
                </td>
                <td>Department: {{ item.department_name }}</td>
                <td>Seen Status: {{ item.seen_status }}</td>
            </tr>
            </tbody>
        </table>
        <PurchaseRequestProductsDetails :details="item.purchase_products" :triggerSelectProduct="triggerSelectProduct"></PurchaseRequestProductsDetails>
    </div>
</template>

<script>
import config from "../../config";
import PurchaseRequestProductsDetails from "./PurchaseRequestProductsDetails";

export default {
    name: "PurchaseTableDetail",
    components: {PurchaseRequestProductsDetails},
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
