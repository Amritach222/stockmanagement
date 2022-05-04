<template>
    <CDropdown
        inNav
        class="c-header-nav-items"
        placement="bottom-end"
        add-menu-classes="pt-0"
    >
        <template #toggler>
            <CHeaderNavLink>
                <div class="c-avatar">
                    <img
                        :src=profileImageUrl
                        class="c-avatar-img "
                    />
                </div>
            </CHeaderNavLink>
        </template>
        <CDropdownHeader tag="div" class="text-center" color="light">
            <strong>{{username}}</strong>
        </CDropdownHeader>
        <CDropdownItem>
            <CIcon name="cil-bell"/>
            Updates
            <CBadge color="info" class="mfs-auto">{{ itemsCount }}</CBadge>
        </CDropdownItem>
        <CDropdownItem>
            <CIcon name="cil-envelope-open"/>
            Messages
            <CBadge color="success" class="mfs-auto">{{ itemsCount }}</CBadge>
        </CDropdownItem>
        <CDropdownHeader
            tag="div"
            class="text-center"
            color="light"
        >
            <strong>Settings</strong>
        </CDropdownHeader>
        <CDropdownItem v-on:click="profileSetting">
            <CIcon name="cil-user"/>
            Profile
        </CDropdownItem>
        <CDropdownItem>
            <CIcon name="cil-settings"/>
            Settings
        </CDropdownItem>
        <CDropdownItem v-on:click="logoutUser">
            <CIcon name="cil-lock-locked"/>
            Logout
        </CDropdownItem>
    </CDropdown>
</template>

<script>
import store from "../../store";
import route from "../../router";
import ApiServices from "../../services/ApiServices";
import config from "../../config";

export default {
    name: 'TheHeaderDropdownAccnt',
    data() {
        return {
            itemsCount: 42,
            profileImageUrl: 'images/avatars/7.jpg',
            username: 'Username'
        }
    },
    created() {
        let userData = localStorage.getItem('userData');
        if(userData !== ''){
            userData = JSON.parse(userData);
            this.username = userData.name;
        }
        this.profileImage()
    },
    methods: {
        async profileSetting() {
            route.push({path: '/profile-setting'})
        },
        async logoutUser() {
            store.state.auth.username = '';
            store.state.auth.password = '';
            let res = await store.dispatch('auth/logoutUser');
            if (res) {
                route.push({path: '/login'})
            }
        },
        async profileImage() {
            let profilePic = false;
            if(store.state.auth.isLoggedIn){
                profilePic = await ApiServices.getUserProfilePic();
            }
            if (profilePic.success === true) {
                let link = profilePic.data;
                this.profileImageUrl = config.cdnURL + link;
            }
        }
    }
}
</script>

<style scoped>
.c-icon {
    margin-right: 0.3rem;
}
</style>
