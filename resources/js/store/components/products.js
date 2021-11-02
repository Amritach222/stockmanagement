/**
 * Created by Anusha.
 * Date: 11/10/2021
 */
import ApiServices from "../../services/ApiServices";

export default {

    namespaced: true,

    state: {
        isLoggedIn: true,
        id: null,
        name: null,
        parent_id: null,
        attribute_group_id: null,
        brand_id: null,
        category_id: null,
        details: null,
        price: null,
        quantity: null,
        stock: null,
        alert_stock: null,
        unit_id: null,
        tax_id: null,
        tax_method: null,
        product_id: null,
        short_code: null,
    },

    actions: {
        async categoryList({rootState}) {
            let categoryFetch = await ApiServices.categoryIndex();
            if (categoryFetch.status === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = 'Category List!';
                rootState.home.snackbarColor = 'success';
                return categoryFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = categoryFetch.message;
                rootState.home.snackbarColor = 'failed';
                return categoryFetch;
            }
        },

        async categoryCreate({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('parent_id', state.parent_id);
            let res = await ApiServices.categoryCreate(data);
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

        async categoryShow({state, rootState}) {
            let categoryFetch = await ApiServices.categoryShow(state.id);
            if (categoryFetch.status === true) {
                return categoryFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = categoryFetch.message;
                rootState.home.snackbarColor = 'failed';
                return categoryFetch;
            }
        },

        async categoryEdit({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('parent_id', state.parent_id);
            let res = await ApiServices.categoryEdit(state.id, data);
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

        async productList({rootState}) {
            let dataFetch = await ApiServices.productIndex();
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async productCreate({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('brand_id', state.brand_id);
            data.append('category_id', state.category_id);
            data.append('details', state.details);
            let res = await ApiServices.productCreate(data);
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

        async productShow({state, rootState}) {
            let dataFetch = await ApiServices.productShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async productEdit({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('brand_id', state.brand_id);
            data.append('category_id', state.category_id);
            data.append('details', state.details);
            let res = await ApiServices.productEdit(state.id, data);
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

        async itemList({rootState}) {
            let dataFetch = await ApiServices.itemIndex();
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async itemCreate({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('stock', state.stock);
            data.append('alert_stock', state.alert_stock);
            data.append('product_id', state.product_id);
            data.append('brand_id', state.brand_id);
            data.append('cost_price', state.price);
            data.append('unit_id', state.unit_id);
            data.append('tax_id', state.tax_id);
            data.append('tax_method', state.tax_method);
            let res = await ApiServices.itemCreate(data);
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

        async itemShow({state, rootState}) {
            let dataFetch = await ApiServices.itemShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async itemEdit({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('stock', state.stock);
            data.append('alert_stock', state.alert_stock);
            data.append('product_id', state.product_id);
            data.append('brand_id', state.brand_id);
            data.append('cost_price', state.price);
            data.append('unit_id', state.unit_id);
            data.append('tax_id', state.tax_id);
            data.append('tax_method', state.tax_method);
            let res = await ApiServices.itemEdit(state.id, data);
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

        async itemAttributeGroupList({rootState}) {
            let dataFetch = await ApiServices.itemAttributeGroupIndex();
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async itemAttributeGroupCreate({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            let res = await ApiServices.itemAttributeGroupCreate(data);
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

        async itemAttributeGroupShow({state, rootState}) {
            let dataFetch = await ApiServices.itemAttributeGroupShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async itemAttributeGroupEdit({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            let res = await ApiServices.itemAttributeGroupEdit(state.id, data);
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

        async itemAttributeList({rootState}) {
            let dataFetch = await ApiServices.itemAttributeIndex();
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async itemAttributeCreate({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('attribute_group_id', state.attribute_group_id);
            let res = await ApiServices.itemAttributeCreate(data);
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

        async itemAttributeShow({state, rootState}) {
            let dataFetch = await ApiServices.itemAttributeShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async itemAttributeEdit({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('attribute_group_id', state.attribute_group_id);
            let res = await ApiServices.itemAttributeEdit(state.id, data);
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

