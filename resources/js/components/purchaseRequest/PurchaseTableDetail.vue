<template>
    <div>
        <table class="table table-striped">
            <tbody>
            <tr>
                <td>
                    <button><b>#{{ item.reference_no }}</b></button>
                </td>
                <td>{{ item.note }}</td>
                <td>Approved By: {{ item.approved_by }}</td>
            </tr>
            <tr>
                <td>Line Items: {{ item.total_item }}</td>
                <td>Due Date: {{ item.due_date }}</td>
                <td>Status: {{ item.status }}</td>
            </tr>
            <tr>
                <td>File link:
                    <button v-if="item.file_link !== 'Not Found'" v-on:click="openImage(item.file_link)">
                        Click to Open
                    </button>
                    <button v-else>No file</button>
                </td>
                <td>Department: {{ item.department_name }}</td>
                <td>Delivery Status: {{ item.delivery_status }}</td>
            </tr>
            </tbody>
        </table>
        <PurchaseRequestProductsDetails :details="item.purchase_products"></PurchaseRequestProductsDetails>
    </div>
</template>

<script>
import config from "../../config";
import PurchaseRequestProductsDetails from "./PurchaseRequestProductsDetails";

export default {
    name: "PurchaseTableDetail",
    components: {PurchaseRequestProductsDetails},
    props: ['item'],
    data: () => ({
        cdnURL: config.cdnURL,
    }),
    methods: {
        openImage(data) {
            window.open(this.cdnURL + data, `_blank`);
        },
    }
}
</script>

<style scoped>
</style>
