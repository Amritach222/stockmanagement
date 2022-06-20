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
        <CHeaderNavLink to="/dashboard"> Dashboard </CHeaderNavLink>
      </CHeaderNavItem>
    </CHeaderNav>
    <CHeaderNav class="mr-4">
      <!--            <CHeaderNavItem class="d-md-down-none mx-2">-->
      <!--                <CHeaderNavLink>-->
      <!--                    <CIcon name="cil-bell"/>-->
      <!--                </CHeaderNavLink>-->
      <!--            </CHeaderNavItem>-->
      <TheHeaderDropdownNotify />
      <CHeaderNavItem>
        <v-icon color="blue darken-2" @click="openLang" class="mr-2">
          mdi-web
        </v-icon>
      </CHeaderNavItem>
      <TheHeaderDropdownAccnt />
    </CHeaderNav>
    <CSubheader class="px-3">
      <CBreadcrumbRouter
        class="border-0 mb-0 "
        v-if="!dashboardTab.includes($route.path ) ||$is('Vendor')"
      />
      <div class="d-flex align-items-center dashboard_tabs text-dark" v-else>
        <div
          :class="
            getCurrentTab() === 'request'
              ? 'purchasing_request b_tab text-bold selected_tab'
              : 'purchasing_request b_tab text-bold'
          "
          @click="changeTab('request')"
        >
          Purchasing Request
        </div>
        <div
          :class="
            getCurrentTab() === 'order'
              ? 'purchasing_order b_tab text-bold ml-4 text-dark selected_tab'
              : 'purchasing_order b_tab text-bold ml-4 text-dark'
          "
          @click="changeTab('order')"
        >
          Purchasing Order
        </div>
        <div
          :class="
            getCurrentTab() === 'quote'
              ? 'quotations b_tab text-bold ml-4 text-dark selected_tab'
              : 'quotations b_tab text-bold ml-4 text-dark'
          "
          @click="changeTab('quote')"
        >
          Quotations
        </div>
        <div
          :class="
            getCurrentTab() === 'invoice'
              ? 'invoices b_tab text-bold ml-4 text-dark selected_tab'
              : 'invoices b_tab text-bold ml-4 text-dark'
          "
          @click="changeTab('invoice')"
        >
          Invoices
        </div>
      </div>
    </CSubheader>
    <v-dialog v-model="lang" max-width="300px">
      <v-card>
        <language></language>
      </v-card>
    </v-dialog>
  </CHeader>
</template>

<script>
import TheHeaderDropdownAccnt from "./TheHeaderDropdownAccnt";
import TheHeaderDropdownNotify from "./TheHeaderDropdownNotify";
import ApiServices from "../../services/ApiServices";
import Language from "./Language";
import store from "../../store";
import permissions from "../../permissions";

export default {
  name: "TheHeader",
  components: {
    Language,
    TheHeaderDropdownAccnt,
    TheHeaderDropdownNotify,
  },

  data: () => ({
    lang: false,
    dashboardTab: ["/home/","/home","/"],
    settings: {
      title: "",
      logo: "",
      currency: "",
      date_format: "",
      fiscal_year_id: "",
      time_zone: "",
    },
  }),
  created() {
    this.getCurrentTab();
    this.getSettings();
    this.setCurrentTab();
  },
  methods: {
    setCurrentTab() {
      store.commit("home/changeTab", "request");
    },
    getCurrentTab() {
      return store.state.home.dashboard_tab;
    },
    changeTab(value) {
      store.commit("home/changeTab", value);
    },
    openLang() {
      console.log("i am called");
      this.lang = true;
    },
    async getSettings() {
      let isLoggedIn = localStorage.getItem("isLoggedIn");
      if (isLoggedIn === "true") {
        let res = await ApiServices.settingIndex();
        if (res.success === true) {
          this.settings = res.data;
        }
      }
    },
  },
};
</script>
<style>
.b_tab {
  cursor: pointer;
  font-size: 15px;
  font-weight: bold;
}
.selected_tab {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  border-bottom: 3px solid #3c4b64;
}
</style>
