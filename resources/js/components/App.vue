/**
* Created by Samundra.
* Date: 15/09/2021
*/
<template>
    <div class="c-app" id="app" data-app>
        <Snackbar></Snackbar>
        <Sidebar v-if="!noHeaders.includes($route.path)"/>
        <CWrapper>
            <div class="language-bar" v-if="noHeaders.includes($route.path)">
                <Language></Language>
            </div>
            <Header v-if="!noHeaders.includes($route.path)"/>
            <div class="c-body">
                <main class="c-main">
                    <CContainer fluid>
                        <transition name="fade" mode="out-in">
                            <router-view :key="$route.path"></router-view>
                        </transition>
                    </CContainer>
                </main>
            </div>
            <Footers/>
        </CWrapper>
    </div>
</template>

<script>
    import store from "../store";
    import route from "../router";
    import Language from "./layouts/Language";
    import Header from "./layouts/TheHeader";
    import Sidebar from "./layouts/Sidebar";
    import Snackbar from "./layouts/Snackbar";
    import Footers from "./layouts/TheFooter";

    export default {
        name: "Default",
        components: {Footers, Snackbar, Header, Sidebar, Language},
        data: function () {
            return {
                loginState: false,
                noHeaders: ['/login', '/register', '/forgot-password', '/reset-password-confirm', '/reset-password'],
            }
        },
        mounted() {
            let isLoggedIn = localStorage.getItem('isLoggedIn');
            let accessToken = localStorage.getItem('access_token');
            if (isLoggedIn === 'true' || isLoggedIn === true) {
                this.loginState = true;
                store.state.auth.isLoggedIn = true;
                store.state.auth.auth_token = accessToken;
            }
        },
        watch: {
            loginState() {
                store.watch(state => store.state.auth.isLoggedIn, () => {
                    this.loginState = store.state.auth.isLoggedIn
                });
            },
        },
        created() {
            let accessToken = localStorage.getItem('access_token');
            let isLoggedIn = localStorage.getItem('isLoggedIn');
            if (isLoggedIn === 'true') {
                store.state.auth.isLoggedIn = true;
                store.state.auth.auth_token = accessToken;
            }
        },
        methods: {
            async logoutUser() {
                store.state.auth.username = '';
                store.state.auth.password = '';
                let res = await store.dispatch('auth/logoutUser');
                if (res) {
                    route.replace('login');
                }
            },
        }
    }
</script>

<style lang="scss">
    // Import Main styles for this application
    @import 'resources/js/assets/scss/style';
</style>
<style scoped>
    .language-bar{
        margin-top: 9px;
        margin-left: auto;
        width: 150px;
        margin-right: 65px;
    }

    .file-link{
        cursor: pointer;
        text-decoration: underline;
    }

    .c-app {
        display: flex;
        flex-direction: row;
        max-height: 100vh !important;
    }

</style>
