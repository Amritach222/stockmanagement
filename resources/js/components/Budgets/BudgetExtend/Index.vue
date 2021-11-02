<template>
    <div>
        <CRow>
            <CCol lg="12">
                <DataTable
                    fixed
                    border
                    caption="Budget Extend List"
                />
            </CCol>
        </CRow>
    </div>
</template>
<script>
import DataTable from "./Table.vue";

export default {
    name: "BudgetExtendIndex",
    components: { DataTable },
}
</script>
