/**
 * Created by Anusha.
 * Date: 11/10/2021
 */
import ApiServices from "../../services/ApiServices";

export default {

    namespaced: true,

    state: {
        id: null,
        bank_name: null,
        account_no: null,
        account_name: null,
        total_balance: null,
        branch: null,
        account_id: null,
        transaction_amount: null,
        transaction_type: null,
    },

    actions: {
        async bankAccountList({rootState}) {
            let dataFetch = await ApiServices.bankAccountIndex();
            if (dataFetch.status === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = 'Bank Account List!';
                rootState.home.snackbarColor = 'success';
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async bankAccountCreate({state, rootState}) {
            const data = new FormData();
            data.append('bank_name', state.bank_name);
            data.append('account_name', state.account_name);
            data.append('account_no', state.account_no);
            data.append('total_balance', state.total_balance);
            data.append('branch', state.branch);
            let res = await ApiServices.bankAccountCreate(data);
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

        async bankAccountShow({state, rootState}) {
            let dataFetch = await ApiServices.bankAccountShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async bankAccountEdit({state, rootState}) {
            const data = new FormData();
            data.append('bank_name', state.bank_name);
            data.append('account_name', state.account_name);
            data.append('account_no', state.account_no);
            data.append('total_balance', state.total_balance);
            data.append('branch', state.branch);
            let res = await ApiServices.bankAccountEdit(state.id, data);
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

        async bankAccountTransactionList({rootState}) {
            let dataFetch = await ApiServices.bankAccountTransactionIndex();
            if (dataFetch.status === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = 'Bank Account Transaction List!';
                rootState.home.snackbarColor = 'success';
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async bankAccountTransactionCreate({state, rootState}) {
            const data = new FormData();
            data.append('account_id', state.account_id);
            data.append('transaction_amount', state.transaction_amount);
            data.append('transaction_type', state.transaction_type);
            let res = await ApiServices.bankAccountTransactionCreate(data);
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

        async bankAccountTransactionShow({state, rootState}) {
            let dataFetch = await ApiServices.bankAccountTransactionShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async bankAccountTransactionEdit({state, rootState}) {
            const data = new FormData();
            data.append('account_id', state.account_id);
            data.append('transaction_amount', state.transaction_amount);
            data.append('transaction_type', state.transaction_type);
            let res = await ApiServices.bankAccountTransactionEdit(state.id, data);
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
