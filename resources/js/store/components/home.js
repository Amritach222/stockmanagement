export default {

    namespaced: true,

    state: {
        snackbar: false,
        snackbarText: '',
        snackbarColor: 'success',
        user:[{'name':'','username':''}],
        lang:'en',
    },
    mutations: {
        resetState(state) {
            state.snackbar = false;
            state.snackbarText = '';
            state.snackbarColor = 'success';
        },
    }
}
