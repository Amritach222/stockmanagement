export default {

    namespaced: true,

    state: {
        editItem: [],
        selectedPurchaseRequestedProducts: [],
    },
    mutations: {
        resetState(state) {
            state.editItem = [];
        },

    },
    actions: {
        async addSelectedProducts({state, rootState}, items) {
            if(items.length > 0){
                items.forEach((singleItem) => {
                    state.selectedPurchaseRequestedProducts.push(singleItem);
                });
            }
            console.log('selected items', state.selectedPurchaseRequestedProducts);
        }
    }
}
