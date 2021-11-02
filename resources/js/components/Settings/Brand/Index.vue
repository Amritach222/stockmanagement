<template>
    <div>
        <CRow>
            <CCol lg="12">
                <DataTable
                    fixed
                    border
                    caption="Brand List"
                />
            </CCol>
        </CRow>
    </div>
</template>
<script>
import DataTable from "./Table.vue";

export default {
    name: "BrandIndex",
    components: { DataTable },
}
</script>
