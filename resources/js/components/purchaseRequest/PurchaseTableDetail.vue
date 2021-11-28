<template>
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
            <td>Delivery Status: {{ item.delivery_status }}</td>
            <td>Due Date: {{ item.due_date }}</td>

        </tr>
        <tr>
            <td>File link: <button v-on="openImage(item.file_link)">Open File</button></td>
            <td>Department: {{ item.department_name }}</td>
            <td>Status: {{ item.status }}</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
import config from "../../config";

export default {
    name: "PurchaseTableDetail",
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
