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

        <CRenderFunction flat :content-to-render="$options.nav"/>
        <CSidebarMinimizer
            class="d-md-down-none"
            @click.native="$store.commit('set', ['sidebarMinimize', !minimize])"
        />
    </CSidebar>
</template>

<script>
import nav from './_nav'
import store from "../../store";
import ApiServices from "../../services/ApiServices";
import config from "../../config";

export default {
    name: 'Sidebar',
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
    }),
    async created() {
        this.getSettings();
    },
    mounted() {
        this.$root.$on('sidebarComponent', () => {
            this.getSettings()
        })
    },
    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async getSettings() {
            let isLoggedIn = localStorage.getItem('isLoggedIn');
            if (isLoggedIn === 'true') {
                let res = await ApiServices.settingShow(1);
                if (res.success === true) {
                    this.settings = res.data;
                }
            }
        },
    }
}
</script>
