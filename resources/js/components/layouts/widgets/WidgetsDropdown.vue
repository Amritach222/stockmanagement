<template>

  <div v-if="!$is('Vendor')">
      <v-row dense :style="{padding:'0 10px'}">
        <v-col cols="12" md="8"
        >
          <v-card class="p-3 mr-3" :style="{ borderRadius: '20px' }">
          <div class="d-flex justify-content-between">
            <h4>{{getCurrentData().name}}</h4>

          </div>

          <BarChart />
        </v-card>
        </v-col>
        <v-col class="d-flex align-items-center justify-content-center">
            <v-row>
              <!-- Change from here -->
              <v-col class="d-flex justify-content-center align-items-center"
            :cols="6">
            <v-card
              :style="{height:'100%', borderRadius: '20px', height:'150px', width:'150px' }"
              class=" position-relative"
              >
              <div class="status_icon_with_rounded_background">
                  <v-icon :style="{color:'RGB(25, 135, 84)'}">
                   mdi-check-decagram
                  </v-icon>
              </div>
              <v-card-text >
                <h2>
                  <b>{{ getCurrentData().approved}}</b>
                </h2>
                <p class="text-secondary">Approved</p>
              </v-card-text>
              <div class="arrow-container position-absolute " @click="gotoMinorDashboard('approved')">
              <!-- Redirect page to minor dashboard -->
              <router-link v-if="getCurrentTab() == 'request'"
                            :to="'/purchase/purchase-request-history'">
                             <v-icon>mdi-arrow-top-right</v-icon>
                        </router-link>
                         <router-link v-if="getCurrentTab() == 'order'"
                            :to="'/purchaseOrders'">
                             <v-icon>mdi-arrow-top-right</v-icon>
                        </router-link>
                         <router-link v-if="getCurrentTab() == 'quote'"
                            :to="'/quotations'">
                             <v-icon>mdi-arrow-top-right</v-icon>
                        </router-link>
                         <router-link v-if="getCurrentTab() == 'invoice'"
                            :to="'/invoices'">
                             <v-icon>mdi-arrow-top-right</v-icon>
                        </router-link>
              </div>
            </v-card>
            </v-col>
             <!-- Change from here -->
             <p v-if="getCurrentTab() == 'request'"></p>
              <v-col class="d-flex justify-content-center align-items-center"
             v-else
            :cols="6">
            <v-card
              :style="{height:'100%', borderRadius: '20px', height:'150px', width:'150px' }"
              class=" position-relative"
              >
              <div class="status_icon_with_rounded_background">
                  <v-icon :style="{color:'RGB(144, 238, 144)'}">
                   mdi-email-receive
                  </v-icon>
              </div>
              <v-card-text >
                <h2>
                  <b>0</b>
                </h2>
                <p class="text-secondary">Received</p>
              </v-card-text>
              <div class="arrow-container position-absolute " @click="gotoMinorDashboard('received')">
                <router-link v-if="getCurrentTab() == 'request'"
                            :to="'/purchase/purchase-request-history'">
                             <v-icon>mdi-arrow-top-right</v-icon>
                        </router-link>
                         <router-link v-if="getCurrentTab() == 'order'"
                            :to="'/purchaseOrders'">
                             <v-icon>mdi-arrow-top-right</v-icon>
                        </router-link>
                         <router-link v-if="getCurrentTab() == 'quote'"
                            :to="'/quotations'">
                             <v-icon>mdi-arrow-top-right</v-icon>
                        </router-link>
                         <router-link v-if="getCurrentTab() == 'invoice'"
                            :to="'/invoices'">
                             <v-icon>mdi-arrow-top-right</v-icon>
                        </router-link>
              </div>
            </v-card>
            </v-col>
             <!-- Change from here -->
              <v-col class="d-flex justify-content-center align-items-center"
            :cols="6">
            <v-card
              :style="{height:'100%', borderRadius: '20px', height:'150px', width:'150px' }"
              class=" position-relative"
              >
              <div class="status_icon_with_rounded_background">
                  <v-icon :style="{color:'rgb(255, 0, 0)'}">
                   mdi-cancel
                  </v-icon>
              </div>
              <v-card-text >
                <h2>
                  <b>{{ getCurrentData().rejected}}</b>
                </h2>
                <p class="text-secondary">Rejected</p>
              </v-card-text>
              <div class="arrow-container position-absolute " @click="gotoMinorDashboard('rejected')">
                <router-link v-if="getCurrentTab() == 'request'"
                            :to="'/purchase/purchase-request-history'">
                             <v-icon>mdi-arrow-top-right</v-icon>
                        </router-link>
                         <router-link v-if="getCurrentTab() == 'order'"
                            :to="'/purchaseOrders'">
                             <v-icon>mdi-arrow-top-right</v-icon>
                        </router-link>
                         <router-link v-if="getCurrentTab() == 'quote'"
                            :to="'/quotations'">
                             <v-icon>mdi-arrow-top-right</v-icon>
                        </router-link>
                         <router-link v-if="getCurrentTab() == 'invoice'"
                            :to="'/invoices'">
                             <v-icon>mdi-arrow-top-right</v-icon>
                        </router-link>
              </div>
            </v-card>
            </v-col>
             <!-- Change from here -->
              <v-col class="d-flex justify-content-center align-items-center"
            :cols="6">
            <v-card
              :style="{height:'100%', borderRadius: '20px', height:'150px', width:'150px' }"
              class=" position-relative"
              >
              <div class="status_icon_with_rounded_background">
                  <v-icon :style="{color:'rgb(249,177,21)'}">
                   mdi-account-clock
                  </v-icon>
              </div>
              <v-card-text >
                <h2>
                  <b>{{ getCurrentData().pending}}</b>
                </h2>
                <p class="text-secondary">Pending</p>
              </v-card-text>
              <div class="arrow-container position-absolute " @click="gotoMinorDashboard('pending')">
               <router-link v-if="getCurrentTab() == 'request'"
                            :to="'/purchase/purchase-request-history'">
                             <v-icon>mdi-arrow-top-right</v-icon>
                        </router-link>
                         <router-link v-if="getCurrentTab() == 'order'"
                            :to="'/purchaseOrders'">
                             <v-icon>mdi-arrow-top-right</v-icon>
                        </router-link>
                         <router-link v-if="getCurrentTab() == 'quote'"
                            :to="'/quotations'">
                             <v-icon>mdi-arrow-top-right</v-icon>
                        </router-link>
                         <router-link v-if="getCurrentTab() == 'invoice'"
                            :to="'/invoices'">
                             <v-icon>mdi-arrow-top-right</v-icon>
                        </router-link>
              </div>
            </v-card>
            </v-col>
            </v-row>
        </v-col>
      </v-row>
    <!-- Data Table for Stock items  -->

    <v-card class="mt-4">
      <v-card-title>
        Stock Items
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search stock items here"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table
        :headers="headers"
        :items="products"
        :search="search"
        :loading="tableLoad"
        loading-text="Loading... Please wait..."
      >
        <template v-slot:item.link="{ item }">
          <img
            :src="cdnURL + item.link"
            v-if="item.link"
            style="width: 50px; height: 50px; object-fit: cover"
            v-on:click="openImage(item.link)"
          />

          <img
            :src="baseURL + 'images/placeholder.jpg'"
            v-else
            style="width: 50px; height: 50px; object-fit: cover"
          />
        </template>
        <template v-slot:item.brand="{ item }">
          {{ item.brand.name }}
        </template>
        <template v-slot:item.category="{ item }">
          {{ item.category.name }}
        </template>
      </v-data-table>
    </v-card>
  </div>
</template>

<script>
import { CChartLineSimple, CChartBarSimple, BarChart } from "./charts/index.js";
import ApiServices from "../../../services/ApiServices.js";
import i18n from "../../../i18n";
import config from "../../../config";
import store from '../../../store'
import dataForChart from './charts/chartData'
export default {
  name: "WidgetsDropdown",
  props: ["settData"],
  components: { CChartLineSimple, CChartBarSimple, BarChart },
  data: () => ({
    cdnURL: config.cdnURL,
    baseURL: config.baseURL,
    tableLoad: true,
    store:store,
    search: "",
    headers: [
      { text: i18n.t("id"), align: "start", sortable: true, value: "id" },
      { text: i18n.t("name"), value: "name" },
      { text: i18n.t("image"), value: "link", sortable: false },
      { text: i18n.t("brand"), value: "brand", sortable: false },
      { text: i18n.t("category"), value: "category", sortable: false },
      { text: i18n.t("type"), value: "type" },
    ],
    products: [],
  }),
  async created() {
    this.loadItems();
    this.getCurrentData();

  },
  methods: {
    gotoMinorDashboard(action){
      store.state.home.current_action=action

    },
    getCurrentTab(){
      return store.state.home.dashboard_tab
    },
    getCurrentData(){
      const data=store.getters['home/getTabContent']
      return data
    },
    openImage(data) {
      window.open(config.cdnURL + data, `_blank`);
    },

    async loadItems() {
      let res = await ApiServices.productIndex();
      if (res.success === true) {
        this.tableLoad = false;
        this.products = res.data;
      }
    },
  }
}
;
</script>
<style scoped>
.dashboard-right-col {
  padding-bottom: 0 !important;
}
.arrow-container {
  position: relative;
  background: lightblue;
  margin-bottom: 20px;
  margin-right: 20px;
  padding: 5px;
  height: fit-content;
  width: fit-content;
  border-radius: 50%;
  border-bottom-left-radius: 50% !important ;
  border-bottom-right-radius: 50% !important;
  cursor: pointer;
  bottom:0;
  right:0;
}
.status_icon_with_rounded_background{
  margin-top: 24px;
  margin-left: 20px;
  height: fit-content;
  width: fit-content;
}
</style>
