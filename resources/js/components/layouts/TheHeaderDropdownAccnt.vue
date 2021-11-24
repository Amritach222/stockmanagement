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
            <strong>{{ $t('account') }}</strong>
        </CDropdownHeader>
        <CDropdownItem>
            <CIcon name="cil-bell"/>
            {{ $t('profileDropdown.updates') }}
            <CBadge color="info" class="mfs-auto">{{ itemsCount }}</CBadge>
        </CDropdownItem>
        <CDropdownItem>
            <CIcon name="cil-envelope-open"/>
            {{ $t('profileDropdown.messages') }}
            <CBadge color="success" class="mfs-auto">{{ itemsCount }}</CBadge>
        </CDropdownItem>
        <CDropdownHeader
            tag="div"
            class="text-center"
            color="light"
        >
            <strong>{{ $t('settings') }}</strong>
        </CDropdownHeader>
        <CDropdownItem v-on:click="profileSetting">
            <CIcon name="cil-user"/>
            {{ $t('profile') }}
        </CDropdownItem>
        <CDropdownItem>
            <CIcon name="cil-settings"/>
            {{ $t('settings') }}
        </CDropdownItem>
        <CDropdownItem v-on:click="logoutUser">
            <CIcon name="cil-lock-locked"/>
            {{ $t('profileDropdown.logout') }}
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
            profileImageUrl: 'images/avatars/7.jpg'
        }
    },
    created() {
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
                // route.push('login');
                route.push({path: '/login'})
            }
        },
        async profileImage() {
            let profilePic = await ApiServices.getUserProfilePic();
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
