/**
* Created by Samundra.
* Date: 15/09/2021
*/
<template>
    <div v-if="$is('Vendor')">
        <VendorDashboard/>
    </div>
    <div v-else>
 <div v-if="getCurrentTab()=='invoice'">
       <InvoiceDashboard/>

    </div>
    <div v-else>
        <WidgetsDropdown :settData=settings></WidgetsDropdown >
    </div>
    </div>
</template>

<script>
import ApiServices from "../../services/ApiServices";
import InvoiceDashboard from "../layouts/widgets/InvoiceDashboard";
import WidgetsDropdown from "../layouts/widgets/WidgetsDropdown";
import store from "../../store";
import VendorDashboard from "../layouts/widgets/VendorDashboard";

export default {
    name: "Home",
    components: {VendorDashboard, WidgetsDropdown,InvoiceDashboard},
    data: () => ({
        settings: {
            title: '',
            logo: '',
            currency: '',
            date_format: '',
            fiscal_year_id: '',
            time_zone: '',
            product_count:'',
            item_count:'',
            brand_count:'',
            category_count:'',
            unit_count:'',
        },
    }),
    async created(){
        this.getSettings();
    },
    methods:{
        getCurrentTab(){
            return store.state.home.dashboard_tab;
        },
        async getSettings() {
            let res = await ApiServices.allSettingInfo();
            if (res.success === true) {
                // console.log(res.data)
                this.settings = res.data;
            }
        },
    }
}
</script>

<style scoped>

</style>
