<template>
    <div>
        <CRow>
            <CCol lg="12">
                <DataTable
                    fixed
                    border
                    caption="Department List"
                />
            </CCol>
        </CRow>
    </div>
</template>
<script>
import DataTable from "./Table.vue";

export default {
    name: "DepartmentIndex",
    components: { DataTable },
}
</script>
