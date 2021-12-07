<template>
<div class="detail-table">
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
        </tr>
        <tr>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
        </tr>
        <tr>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
        </tr>
        </tbody>
    </table>
</div>
</template>

<script>
export default {
    name: "PurchaseTableDetail",
    props: ['item'],
}
</script>

<style scoped>
.detail-table{
    margin-left: 1em;
    width: 75vw;
}
</style>
