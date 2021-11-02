/**
 * Created by Anusha.
 * Date: 11/10/2021
 */
import ApiServices from "../../services/ApiServices";

export default {

    namespaced: true,

    state: {
        id: null,
        department_id: '',
        fiscal_year_id: '',
        allocated_budget_amount: '',
        initial_dispatched_amount: '',
        date_first_received: '',
        remarks: '',
        file: '',
        request_amount:'',
        status:'',
        category_id:'',
        amount:'',
        approved_by:'',
    },

    actions: {
        async budgetList({rootState}) {
            let dataFetch = await ApiServices.budgetIndex();
            if (dataFetch.status === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = 'Budget List!';
                rootState.home.snackbarColor = 'success';
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async budgetCreate({state, rootState}) {
            const data = new FormData();
            data.append('department_id', state.department_id);
            data.append('fiscal_year_id', state.fiscal_year_id);
            data.append('allocated_budget_amount', state.allocated_budget_amount);
            data.append('initial_dispatched_amount', state.initial_dispatched_amount);
            data.append('date_first_received', state.date_first_received);
            data.append('remarks', state.remarks);
            data.append('file', state.file);
            let res = await ApiServices.budgetCreate(data);
            if (res.success === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'success';
                return true;
            } else {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'red';
                return false;
            }
        },

        async budgetShow({state, rootState}) {
            let dataFetch = await ApiServices.budgetShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async budgetEdit({state, rootState}) {
            const data = new FormData();
            data.append('department_id', state.department_id);
            data.append('fiscal_year_id', state.fiscal_year_id);
            data.append('allocated_budget_amount', state.allocated_budget_amount);
            data.append('initial_dispatched_amount', state.initial_dispatched_amount);
            data.append('date_first_received', state.date_first_received);
            data.append('remarks', state.remarks);
            data.append('file', state.file);
            let res = await ApiServices.budgetEdit(state.id, data);
            if (res.success === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'success';
                return true;
            } else {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'red';
                return false;
            }
        },

        async budgetRequestList({rootState}) {
            let dataFetch = await ApiServices.budgetRequestIndex();
            if (dataFetch.status === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = 'Budget Request List!';
                rootState.home.snackbarColor = 'success';
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async budgetRequestCreate({state, rootState}) {
            const data = new FormData();
            data.append('department_id', state.department_id);
            data.append('request_amount', state.request_amount);
            let res = await ApiServices.budgetRequestCreate(data);
            if (res.success === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'success';
                return true;
            } else {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'red';
                return false;
            }
        },

        async budgetRequestShow({state, rootState}) {
            let dataFetch = await ApiServices.budgetRequestShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async budgetRequestEdit({state, rootState}) {
            const data = new FormData();
            data.append('department_id', state.department_id);
            data.append('request_amount', state.request_amount);
            let res = await ApiServices.budgetRequestEdit(state.id, data);
            if (res.success === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'success';
                return true;
            } else {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'red';
                return false;
            }
        },

        async budgetExtendList({rootState}) {
            let dataFetch = await ApiServices.budgetExtendIndex();
            if (dataFetch.status === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = 'Budget Extend List!';
                rootState.home.snackbarColor = 'success';
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async budgetExtendCreate({state, rootState}) {
            const data = new FormData();
            data.append('department_id', state.department_id);
            data.append('amount', state.amount);
            data.append('remarks', state.remarks);
            data.append('file', state.file);
            let res = await ApiServices.budgetExtendCreate(data);
            if (res.success === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'success';
                return true;
            } else {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'red';
                return false;
            }
        },

        async budgetExtendShow({state, rootState}) {
            let dataFetch = await ApiServices.budgetExtendShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async budgetExtendEdit({state, rootState}) {
            const data = new FormData();
            data.append('department_id', state.department_id);
            data.append('fiscal_year_id', state.fiscal_year_id);
            data.append('amount', state.amount);
            data.append('remarks', state.remarks);
            data.append('file', state.file);
            let res = await ApiServices.budgetExtendEdit(state.id, data);
            if (res.success === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'success';
                return true;
            } else {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'red';
                return false;
            }
        },

        async budgetLimitList({rootState}) {
            let dataFetch = await ApiServices.budgetLimitIndex();
            if (dataFetch.status === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = 'Budget limit List!';
                rootState.home.snackbarColor = 'success';
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async budgetLimitCreate({state, rootState}) {
            const data = new FormData();
            data.append('category_id', state.category_id);
            data.append('amount', state.amount);
            let res = await ApiServices.budgetLimitCreate(data);
            if (res.success === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'success';
                return true;
            } else {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'red';
                return false;
            }
        },

        async budgetLimitShow({state, rootState}) {
            let dataFetch = await ApiServices.budgetLimitShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async budgetLimitEdit({state, rootState}) {
            const data = new FormData();
            data.append('category_id', state.category_id);
            data.append('amount', state.amount);
            let res = await ApiServices.budgetLimitEdit(state.id, data);
            if (res.success === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'success';
                return true;
            } else {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'red';
                return false;
            }
        },

        async freezeBudgetList({rootState}) {
            let dataFetch = await ApiServices.freezeBudgetIndex();
            if (dataFetch.status === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = 'Freeze Budget List!';
                rootState.home.snackbarColor = 'success';
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async freezeBudgetCreate({state, rootState}) {
            const data = new FormData();
            data.append('department_id', state.department_id);
            data.append('fiscal_year_id', state.fiscal_year_id);
            data.append('amount', state.amount);
            data.append('remark', state.remarks);
            let res = await ApiServices.freezeBudgetCreate(data);
            if (res.success === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'success';
                return true;
            } else {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'red';
                return false;
            }
        },

        async freezeBudgetShow({state, rootState}) {
            let dataFetch = await ApiServices.freezeBudgetShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async freezeBudgetEdit({state, rootState}) {
            const data = new FormData();
            data.append('department_id', state.department_id);
            data.append('fiscal_year_id', state.fiscal_year_id);
            data.append('amount', state.amount);
            data.append('remark', state.remarks);
            let res = await ApiServices.freezeBudgetEdit(state.id, data);
            if (res.success === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'success';
                return true;
            } else {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'red';
                return false;
            }
        },
    },
}

