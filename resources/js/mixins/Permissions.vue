<script>
export default {
    methods: {
        $can(permissionName) {

            let permissions = localStorage.getItem('permissions')
            let permissionStatus = permissions.indexOf(permissionName) !== -1;
            return permissionStatus;
        },
        $is(roleName) {
            let roles = localStorage.getItem('roles');
            let roleStatus = roles.indexOf(roleName) !== -1;
            return roleStatus;
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
