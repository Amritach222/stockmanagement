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
            let roles = localStorage.getItem('roles');
            let status = roles.indexOf(roleName) !== -1;
            return status;
        },
        $isAny(rolesName) {
            let roles = localStorage.getItem('roles');
            let count = 0;
            let names = rolesName.split(',');
            for (let i = 0; i < names.length; i++) {
                if (roles.indexOf(names[i]) !== -1) {
                    count = 1;
                }
            }
            let status = false;
            if (count === 1) {
                status = true;
            }
            return status;
        },
    },
};
</script>
