<template>
    <CHeader fixed with-subheader light>
        <CToggler
            in-header
            class="ml-3 d-lg-none"
            @click="$store.commit('toggleSidebarMobile')"
        />
        <CToggler
            in-header
            class="ml-3 d-md-down-none"
            @click="$store.commit('toggleSidebarDesktop')"
        />
        <CHeaderBrand class="mx-auto d-lg-none" to="/">
            <h3>{{ this.settings.title }}</h3>
        </CHeaderBrand>
        <CHeaderNav class="d-md-down-none mr-auto">
            <CHeaderNavItem class="px-3">
                <CHeaderNavLink to="/dashboard">
                    {{ $t('dashboard') }}
                </CHeaderNavLink>
            </CHeaderNavItem>
        </CHeaderNav>
        <CHeaderNav class="mr-4">
            <CHeaderNavItem class="d-md-down-none mx-2">
                <CHeaderNavLink>
                    <CIcon name="cil-bell"/>
                </CHeaderNavLink>
            </CHeaderNavItem>
            <CHeaderNavItem>
                <v-icon
                    color="blue darken-2"
                    @click="openLang"
                    class="mr-2"
                >
                    mdi-web
                </v-icon>
            </CHeaderNavItem>
            <TheHeaderDropdownAccnt/>
        </CHeaderNav>
        <CSubheader class="px-3">
            <CBreadcrumbRouter class="border-0 mb-0"/>
        </CSubheader>
        <v-dialog
            v-model="lang"
            max-width="300px"
        >
            <v-card>
                    <language></language>
            </v-card>
        </v-dialog>
    </CHeader>
</template>

<script>
import TheHeaderDropdownAccnt from './TheHeaderDropdownAccnt'
import ApiServices from "../../services/ApiServices";
import Language from "./Language";

export default {
    name: 'TheHeader',
    components: {
        Language,
        TheHeaderDropdownAccnt
    },

    data: () => ({
        lang:false,
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
    methods: {
        openLang(){
            console.log('i am called');
            this.lang = true;
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
