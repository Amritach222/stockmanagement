/**
 * Created by Anusha.
 * Date: 11/10/2021
 */
import ApiServices from "../../services/ApiServices";

export default {

    namespaced: true,

    state: {
        id: null,
        name: null,
        company_name: null,
        vat_no: null,
        email: null,
        image: null,
        landline: null,
        mobile: null,
        address: null,
        country: null,
        state: null,
        city: null,
        postal_code: null,
        is_active: null,
        category_id: null,
    },

    actions: {
        async vendorList({rootState}) {
            let dataFetch = await ApiServices.vendorIndex();
            if (dataFetch.status === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = 'Vendor List!';
                rootState.home.snackbarColor = 'success';
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async vendorCreate({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('company_name', state.company_name);
            data.append('vat_no', state.vat_no);
            data.append('email', state.email);
            data.append('landline', state.landline);
            data.append('mobile', state.mobile);
            data.append('image', state.image);
            data.append('address', state.address);
            data.append('country', state.country);
            data.append('state', state.state);
            data.append('city', state.city);
            data.append('postal_code', state.postal_code);
            data.append('is_active', state.is_active);
            data.append('category_id', state.category_id);
            let res = await ApiServices.vendorCreate(data);
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

        async vendorShow({state, rootState}) {
            let dataFetch = await ApiServices.vendorShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async vendorEdit({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('company_name', state.company_name);
            data.append('vat_no', state.vat_no);
            data.append('email', state.email);
            data.append('landline', state.landline);
            data.append('mobile', state.mobile);
            data.append('image', state.image);
            data.append('address', state.address);
            data.append('country', state.country);
            data.append('state', state.state);
            data.append('city', state.city);
            data.append('postal_code', state.postal_code);
            data.append('is_active', state.is_active);
            data.append('category_id', state.category_id);
            let res = await ApiServices.vendorEdit(state.id, data);
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

