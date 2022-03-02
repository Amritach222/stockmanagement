<template>
    <div>
        <v-tabs
            v-model="tab"
            background-color="deep-purple accent-4"
            centered
            dark
            icons-and-text
        >
            <v-tabs-slider></v-tabs-slider>

            <v-tab href="#tab-1">
                Pending Requests
            </v-tab>

            <v-tab href="#tab-2">
                Approval List
            </v-tab>

            <v-tab href="#tab-3">
                Approved List
            </v-tab>

            <v-tab href="#tab-4">
                Rejected List
            </v-tab>

        </v-tabs>
        <v-tabs-items v-model="tab">
            <v-tab-item
                value="tab-1"
            >
                <AdminPending></AdminPending>
            </v-tab-item>
            <v-tab-item
                value="tab-2"
            >
                <approval-list ref="callForUpdate"></approval-list>
            </v-tab-item>
            <v-tab-item
                value="tab-3"
            >
                <AdminAccepted></AdminAccepted>
            </v-tab-item>
            <v-tab-item
                value="tab-4"
            >
                <approval-list ref="callForUpdate"></approval-list>
            </v-tab-item>
        </v-tabs-items>
    </div>
</template>

<script>

import ApprovalList from "./adminStore/ApprovalList";
import AdminPending from "./adminStore/AdminPending";
import AdminAccepted from "./adminStore/AdminAccepted";

export default {
    name: "PurchaseRequestProductsDetailsAdmin",
    components: {AdminAccepted, AdminPending, ApprovalList},
    data: () => ({
        tab: null,
    })
}
</script>

<style scoped>

</style>
