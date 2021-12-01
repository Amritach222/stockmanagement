<template>
    <div>
        <CRow>
            <CCol lg="12">
                <DataTable
                    fixed
                    border
                    caption="Item Attribute List"
                />
            </CCol>
        </CRow>
    </div>
</template>

<script>
import DataTable from "./Table.vue"

export default {
    name: "ItemAttributeIndex",
    components: {DataTable},
}
</script>
