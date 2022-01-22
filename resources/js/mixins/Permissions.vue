<script>
export default {
    methods: {
        $can(permissionName) {
            let permissions = localStorage.getItem('permissions');
            if(permissions === null){
                return false;
            }
            return permissions.indexOf(permissionName) !== -1;
        },
        $is(roleName) {
            let roles = localStorage.getItem('roles');
            if(roles === null){
                return false;
            }
            return roles.indexOf(roleName) !== -1;
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
