export default {

    namespaced: true,

    state: {
        editItem: [],
    },
    mutations: {
        resetState(state) {
            state.editItem = [];
        },
    }
}
