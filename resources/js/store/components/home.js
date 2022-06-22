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
            const all_data=state.dashboard_data;
            if (state.dashboard_tab ==="request") {
                if(all_data===null || all_data===undefined || all_data===''){
                    const data = {
                        name: "Purchase Request",
                        approved: 0,
                        pending: 0,
                        rejected: 0,

                    };
                    return data
                }
                else{
                    const data = {
                        name: "Purchase Request",
                        approved: all_data.purchase_approved_count,
                        pending: all_data.purchase_pending_count,
                        rejected: all_data.purchase_rejected_count,
                    };

                    return  data
                }
            }
            if (state.dashboard_tab === "order") {
                if(all_data===null || all_data===undefined || all_data===''){
                    const data = {
                        name: "Purchase Request",
                        approved: 0,
                        pending: 0,
                        rejected: 0,

                    };
                    return data
                }

                else{
                    const data = {
                        name: "Purchase Order",
                        approved: all_data.po_approved_count,
                        pending: all_data.po_pending_count,
                        rejected: all_data.po_rejected_count,
                    };
                    return  data
                }
            }
            if (state.dashboard_tab === "quote") {
                if(all_data===null || all_data===undefined || all_data===''){
                    const data = {
                        name: "Purchase Request",
                        approved: 0,
                        pending: 0,
                        rejected: 0,

                    };
                    return data
                }
                else{
                    const data = {
                        name: "Quotation",
                        approved: all_data.quotation_approved_count,
                        pending: all_data.quotation_pending_count,
                        rejected: all_data.po_rejected_count,
                    };
                    return data;
                }
            }
            if (state.dashboard_tab === "invoice") {
                const data = state.dashboard_data;
                // When data not retrieving from database
                if(data===null || data===undefined || data===''){
                    const i_data={
                        name: "Invoices",
                        paid:0,
                        partially_paid:0,
                        unpaid:0,
                    }
                    return i_data
                }
                //if payment status also has no data
                else if(data.payment_status===null || data.payment_status===undefined || data.payment_status===''){
                    const i_data={
                        name: "Invoices",
                        paid:0,
                        partially_paid:0,
                        unpaid:0,
                    }
                    return i_data
                }
                else{
                    const i_data={
                        name: "Invoices",
                        paid:data.payment_status.paid,
                        partially_paid:data.payment_status.partially_paid,
                        unpaid:data.payment_status.unpaid,
                    }
                    return i_data
                }
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
