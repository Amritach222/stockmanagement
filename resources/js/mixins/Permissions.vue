<script>
export default {
    methods: {
        $can(permissionName) {
            let permissions = localStorage.getItem('permissions');
            let userPermissions = permissions.split(",");
            let permissionStatus = userPermissions.indexOf(permissionName) !== -1;
            // if (permissionName === 'vendors') {
            //     for (var i = 0; i < userPermissions.length; i++) {
            //         console.log(typeof(userPermissions))
            //     }
            //     console.log(permissionStatus)
            // }
            return permissionStatus;
        },
        $is(roleName) {
            let roles = localStorage.getItem('roles');
            let userRoles = roles.split(",");
            let roleStatus = userRoles.indexOf(roleName) !== -1;
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
