<template>
    <div>
        <CRow>
            <CCol lg="12">
                <DataTable
                    fixed
                    border
                    caption="Category List"
                />
            </CCol>
        </CRow>
    </div>
</template>

<script>
import DataTable from "./Table.vue"

export default {
    name: "CategoryIndex",
    components: { DataTable },
}
</script>
