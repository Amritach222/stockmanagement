<script>
import Vue from "vue";
import ApiServices from "../services/ApiServices";

export default {
    methods: {
        async $can(permissionName) {
            if(Vue.prototype.$permissions !== []) {
                let isLoggedIn = localStorage.getItem('isLoggedIn');
                if (isLoggedIn === 'true') {
                    let res = await ApiServices.getUserPermissions();
                    if (res.success === true) {
                        Vue.prototype.$permissions = res.data;
                    } else {
                        Vue.prototype.$permissions = [];
                    }
                } else {
                    Vue.prototype.$permissions = [];
                }
            }
            let status = Vue.prototype.$permissions.indexOf(permissionName) !== -1;
            // let check = {"status":status,"return":'check'}
            // console.log(check)
            return status;
        },
    },
};
</script>
