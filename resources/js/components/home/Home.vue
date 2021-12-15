/**
* Created by Samundra.
* Date: 15/09/2021
*/
<template>
    <div>
        <WidgetsDropdown :settData=settings></WidgetsDropdown>
    </div>
</template>

<script>
import ApiServices from "../../services/ApiServices";
import WidgetsDropdown from "../layouts/widgets/WidgetsDropdown";

export default {
    name: "Home",
    components: {WidgetsDropdown},
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
