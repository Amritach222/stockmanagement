<template>
    <div>
        <CRow>
            <CCol lg="12">
                <DataTable
                    fixed
                    border
                    caption="Fiscal Year List"
                />
            </CCol>
        </CRow>
    </div>
</template>
<script>
import DataTable from "./Table.vue";

export default {
    name: "FiscalYearIndex",
    components: { DataTable },
}
</script>
