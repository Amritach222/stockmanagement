<template>
    <CSidebar
        fixed
        :minimize="minimize"
        :show="show"
        @update:show="(value) => $store.commit('set', ['sidebarShow', value])"
    >
        <CSidebarBrand class="d-md-down-none" to="/">
            <img
                class="c-sidebar-brand-full"
                :src=cdnURL+settings.link
                v-if="settings.link"
                style="width: auto; height: 35px"
                v-on:click="openImage(settings.link)"/>
            <img
                class="c-sidebar-brand-minimized"
                :src=cdnURL+settings.link
                v-if="settings.link"
                style="width: auto; height: 35px"
                v-on:click="openImage(settings.link)"/>
        </CSidebarBrand>

        <SidebarNavItem></SidebarNavItem>

<!--        <CRenderFunction flat :content-to-render="navData"/>-->
        <CSidebarMinimizer
            class="d-md-down-none"
            @click.native="$store.commit('set', ['sidebarMinimize', !minimize])"
        />
    </CSidebar>
</template>

<script>
import nav from './_nav'
import ApiServices from "../../services/ApiServices";
import config from "../../config";
import SidebarNavItem from "./SidebarNavItem";
import permissions from "../../permissions";

export default {
    name: 'Sidebar',
    components:{SidebarNavItem},
    nav,
    computed: {
        show() {
            return this.$store.state.sidebarShow
        },
        minimize() {
            return this.$store.state.sidebarMinimize
        }
    },
    data: () => ({
        cdnURL: config.cdnURL,
        settings: {
            title: '',
            logo: '',
            currency: '',
            date_format: '',
            fiscal_year_id: '',
            time_zone: '',
        },
        navData: [],
        navKey: 0,
    }),
    async created() {
        this.getSettings();
        this.loadNavData();
    },
    mounted() {
        this.$root.$on('sidebarComponent', () => {
            this.getSettings()
        })
        this.$root.$on('navComponent', () => {
            this.loadNavData();
        })
    },
    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadNavData() {
            // console.log(nav)
            // console.log(i18n.t('vendors'))
            this.$root.$emit('navData')
                this.navData = nav.data;
        },
        async getSettings() {
            let isLoggedIn = localStorage.getItem('isLoggedIn');
            if (isLoggedIn === 'true') {
                    let res = await ApiServices.settingIndex();
                    if (res.success === true) {
                        this.settings = res.data;
                    }
            }
        },
    }
}
</script>
