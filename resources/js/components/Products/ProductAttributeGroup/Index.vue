<template>
    <div>
        <CRow>
            <CCol lg="12">
                <DataTable
                    fixed
                    border
                    caption="Item Attribute Group List"
                />
            </CCol>
        </CRow>
    </div>
</template>

<script>
import DataTable from "./Table.vue"

export default {
    name: "ItemAttributeGroupIndex",
    components: {DataTable},
}
</script>
