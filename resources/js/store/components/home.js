export default {
    namespaced: true,

    state: {
        current_action:'all',
        dashboard_tab: "request",
        dashboard_data: {},
        snackbar: false,
        snackbarText: "",
        snackbarColor: "success",
        user: [{ name: "", username: "" }],
        lang: "en",
    },
    mutations: {
        resetState(state) {
            state.snackbar = false;
            state.snackbarText = "";
            state.snackbarColor = "success";
        },
         changeTab(state, data) {
            state.dashboard_tab = data;
        },
        // async setData(state) {
        //     await getCurrentTab(state);
        // },

        updateCurrentDashboard(state, data) {
            state.current_action = data;
        }
    },
    getters: {
        getColor(){
            const color_code={
                all: 'rgb(60 75 100)',
                approved:'rgb(25, 135, 84)',
                received:'rgb(144, 238, 144)',
                pending:'rgb(249,177,21)',
                rejected:'rgb(255, 0, 0)'
            }
            return color_code;

        },
        getCurrentDashboard(state) {
            return state.current_action;
        },
        getState(state){
            return state.dashboard_tab;
        },
        getTabContent(state) {
            if (state.dashboard_tab ==="request") {
                const data = {
                    name: "Purchase Request",
                    approved: state.dashboard_data.purchase_approved_count,
                    pending: state.dashboard_data.purchase_pending_count,
                    rejected: state.dashboard_data.purchase_rejected_count,
                    // name: "Purchase Request",
                    // approved: 12,
                    // pending: 15,
                    // rejected: 5,
                };
                return data;
            }
            if (state.dashboard_tab === "order") {
                const data = {
                    name: "Purchase Order",
                    approved: state.dashboard_data.po_approved_count,
                    pending: state.dashboard_data.po_pending_count,
                    rejected: state.dashboard_data.po_rejected_count,
                    // name: "Purchase Order",
                    // approved: 33,
                    // pending: 12,
                    // rejected: 32,
                };
                return data;
            }
            if (state.dashboard_tab === "quote") {
                const data = {
                    name: "Quotation",
                    approved: state.dashboard_data.quotation_approved_count,
                    pending: state.dashboard_data.quotation_pending_count,
                    rejected: state.dashboard_data.po_rejected_count,
                    // name: "Quotation",
                    // approved: 23,
                    // pending: 45,
                    // rejected: 32,
                };
                return data;
            }
            if (state.dashboard_tab === "invoice") {
                const data = state.dashboard_data.payment_status;
                console.log("Invoices :",data);
                const i_data={
                    name: "Invoices",
                    paid:data.paid,
                    partially_paid:data.partially_paid,
                    unpaid:data.unpaid,
                }
                return i_data;
            }
        },
    },
    actions: {
        async getDashboardData({state}) {
            const res = await ApiServices.allSettingInfo();
            if (res.success === true) {
                state.dashboard_data = res.data;
            }
        },
    },
};
import { get } from "jquery";
import ApiServices from "../../services/ApiServices";
