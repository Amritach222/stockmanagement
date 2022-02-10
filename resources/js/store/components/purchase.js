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
            if (items.length > 0) {
                items.forEach((singleItem) => {
                    let donotadd = true;
                    if (state.selectedPurchaseRequestedProducts.length > 0) {
                        state.selectedPurchaseRequestedProducts.forEach((single) => {
                            if (singleItem.id === single.id) {
                                donotadd = false;
                            }
                        });
                    }
                    if (donotadd) {
                        state.selectedPurchaseRequestedProducts.push(singleItem);
                    }
                });
            }
            console.log('selected items', state.selectedPurchaseRequestedProducts);
            return true;
        },
        async removeSelectedProduct({state, rootState}, item) {
            let newarr = [];
            if (state.selectedPurchaseRequestedProducts.length > 0) {
                state.selectedPurchaseRequestedProducts.forEach((single) => {
                    if (item.id !== single.id) {
                        newarr.push(single);
                    }
                });
            }
            state.selectedPurchaseRequestedProducts = newarr;
            console.log('removed result items', state.selectedPurchaseRequestedProducts);
            return true;
        }
    }
}
