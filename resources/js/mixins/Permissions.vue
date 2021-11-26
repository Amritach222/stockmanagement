<script>
import Vue from "vue";
import ApiServices from "../services/ApiServices";

export default {
    methods: {
        $can(permissionName) {
            let permissions = localStorage.getItem('permissions')
            let status = permissions.indexOf(permissionName) !== -1;
            // let check = {"status":status,"return":'check'}
            console.log("permission",status)
            return status;
        },
    },
};
</script>
