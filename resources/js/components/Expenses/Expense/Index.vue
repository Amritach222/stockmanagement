<template>
    <div>
        <CRow>
            <CCol lg="12">
                <DataTable
                    fixed
                    border
                    caption="Expense Category List"
                />
            </CCol>
        </CRow>
    </div>
</template>

<script>
import DataTable from "./Table.vue"

export default {
    name: "ExpenseCategoryIndex",
    components: { DataTable },
}
</script>
