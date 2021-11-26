<script>
import Vue from "vue";
import ApiServices from "../services/ApiServices";

export default {
    methods: {
        $can(permissionName) {
            let permissions = localStorage.getItem('permissions')
            let status = permissions.indexOf(permissionName) !== -1;
            return status;
        },
        $is(roleName) {
            let roles = localStorage.getItem('roles')
            let status = roles.indexOf(roleName) !== -1;
            return status;
        },
    },
};
</script>
