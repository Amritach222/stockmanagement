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
                Pending List
            </v-tab>
            <v-tab href="#tab-2">
                Approved List
            </v-tab>
            <v-tab href="#tab-3">
                Rejected List
            </v-tab>
        </v-tabs>
        <v-tabs-items v-model="tab">
            <v-tab-item
                value="tab-1"
            >
                <DhPending></DhPending>
            </v-tab-item>
            <v-tab-item
                value="tab-2"
            >
                <DhApproved></DhApproved>
            </v-tab-item>
            <v-tab-item
                value="tab-3"
            >
                <DhRejected></DhRejected>
            </v-tab-item>
        </v-tabs-items>
    </div>
</template>

<script>
import DhApproved from "./departmentHead/DhApproved";
import DhPending from "./departmentHead/DhPending";
import DhRejected from "./departmentHead/DhRejected";

export default {
    name: "PurchaseRequestProductsDetailsDh",
    components: {DhRejected, DhPending, DhApproved},
    data: () => ({
        tab: null,
    }),
}
</script>

<style scoped>

</style>
