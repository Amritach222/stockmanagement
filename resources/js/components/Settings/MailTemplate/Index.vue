<template>
    <div>
        <CRow>
            <CCol lg="12">
                <DataTable
                    fixed
                    border
                    caption="Mail Template List"
                />
            </CCol>
        </CRow>
    </div>
</template>
<script>
import DataTable from "./Table.vue";

export default {
    name: "MailTemplateIndex",
    components: {DataTable},
}
</script>
