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
                    <CIcon name="cil-bell"/>
                    <!--                    <img-->
                    <!--                        :src=profileImageUrl-->
                    <!--                        class="c-avatar-img "-->
                    <!--                    />-->
                </div>
            </CHeaderNavLink>
        </template>
        <CDropdownHeader tag="div" class="text-center" color="light">
            <strong>Notifications</strong>
        </CDropdownHeader>
        <CDropdownItem>
            <router-link
                :to="'/notification/quotation'"
                v-if="$can('quotations.edit')"
                class="notify-items"
            >
                <CIcon name="cil-bell"/>
                Quotations
                <CBadge color="info" class="mfs-auto">{{ itemsCount }}</CBadge>
            </router-link>
        </CDropdownItem>
        <CDropdownItem>
            <router-link
                :to="'/notification/purchase'"
                v-if="$can('quotations.edit')"
                class="notify-items"
            >
                <CIcon name="cil-bell"/>
                Purchase Order
                <CBadge color="success" class="mfs-auto">{{ itemsCount }}</CBadge>
            </router-link>
        </CDropdownItem>
    </CDropdown>
</template>

<script>
import store from "../../store";
import route from "../../router";
import ApiServices from "../../services/ApiServices";
import config from "../../config";

export default {
    name: 'TheHeaderDropdownNotify',
    data() {
        return {
            itemsCount: 42,
            profileImageUrl: 'images/avatars/7.jpg',
            username: 'Username'
        }
    },
    created() {
        let userData = localStorage.getItem('userData');
        if (userData !== '') {
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
            if (store.state.auth.isLoggedIn) {
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

.notify-items {
    display: flex !important;
    align-items: center !important;
    width: 100% !important;
    /*padding: 0.5rem 1.25rem !important;*/
    clear: both !important;
    font-weight: 400 !important;
    text-align: inherit !important;
    white-space: nowrap !important;
    background-color: transparent !important;
    border: 0 !important;
    color: #4f5d73 !important;
}
</style>
