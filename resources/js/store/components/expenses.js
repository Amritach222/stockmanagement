/**
 * Created by Anusha.
 * Date: 11/29/2021
 */
import ApiServices from "../../services/ApiServices";

export default {

    namespaced: true,

    state: {
        id: null,
        name: null,
        is_active: null,
        user_id: null,
        bank_account_id: null,
        cheque_no: null,
        department_id: null,
        amount: null,
        transaction_type: null,
        expense_category_id: null,
        note: null,
    },

    actions: {
        async expenseCategoryList({rootState}) {
            let dataFetch = await ApiServices.expenseCategoryIndex();
            if (dataFetch.status === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = 'Expense Category List!';
                rootState.home.snackbarColor = 'success';
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async expenseCategoryCreate({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('is_active', state.is_active);
            let res = await ApiServices.expenseCategoryCreate(data);
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

        async expenseCategoryShow({state, rootState}) {
            let dataFetch = await ApiServices.expenseCategoryShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async expenseCategoryEdit({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('is_active', state.is_active);
            let res = await ApiServices.expenseCategoryEdit(state.id, data);
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

        async expenseList({rootState}) {
            let dataFetch = await ApiServices.expenseIndex();
            if (dataFetch.status === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = 'Expense List!';
                rootState.home.snackbarColor = 'success';
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async expenseCreate({state, rootState}) {
            const data = new FormData();
            data.append('bank_account_id', state.bank_account_id);
            data.append('amount', state.amount);
            data.append('cheque_no', state.cheque_no);
            data.append('department_id', state.department_id);
            data.append('expense_category_id', state.expense_category_id);
            data.append('note', state.note);
            data.append('transaction_type', state.transaction_type);
            let res = await ApiServices.expenseCreate(data);
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

        async expenseShow({state, rootState}) {
            let dataFetch = await ApiServices.expenseShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async expenseEdit({state, rootState}) {
            const data = new FormData();
            data.append('bank_account_id', state.bank_account_id);
            data.append('amount', state.amount);
            data.append('cheque_no', state.cheque_no);
            data.append('department_id', state.department_id);
            data.append('expense_category_id', state.expense_category_id);
            data.append('note', state.note);
            data.append('transaction_type', state.transaction_type);
            let res = await ApiServices.expenseEdit(state.id, data);
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
