<template>
  <div class="minor_dashboard_container">
    <div v-if="getTab()=='request'">
    <PurchaseRequestDashboard/>
    </div>
    <div v-if="getTab()=='order'">
   <PurchaseOrderDashboard/>
    </div>
    <div v-if="getTab()=='quote'">
    <QuotationDashboard/>
    </div>
    <div v-else>
      <h1>No Data Found</h1>
    </div>

  </div>
</template>
<script>
import store from "../../store";
import PurchaseRequestDashboard from "./PurchaseRequestDashboard.vue";
import PurchaseOrderDashboard from "./PurchaseOrderDashboard.vue";
import QuotationDashboard from "./QuotationDashboard.vue";
export default {
    name: "MinorDashboard",
    components: { PurchaseRequestDashboard, PurchaseOrderDashboard,QuotationDashboard },
    data() {
        return {

        };
    },
    methods: {
        getTab() {
            return store.getters["home/getState"];
        },
    },
};
</script>
<style>
.actualtab {
  border: 1px solid transparent;
  padding: 5px 10px;
}
.actualtab:hover {
  cursor: pointer;
}
.tab_approved {
  color: rgb(25, 135, 84);
  border: 1px solid rgb(25, 135, 84);
}
.tab_received{
    color: rgb(144, 238, 144);
    border: 1px solid rgb(144, 238, 144);
}
.tab_pending{
    color: rgb(249,177,21);
    border: 1px solid rgb(249,177,21);
}
.tab_rejected{
    color: rgb(255, 0, 0);
    border: 1px solid rgb(255, 0, 0);
}
.tab_all{
    color: rgb(60 75 100);
    border: 1px solid rgb(60 75 100);
}
</style>
