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
        short_code: null,
        value: null,
        title: null,
        currency: null,
        time_zone: null,
        date_format: null,
        mail_host: null,
        mail_port: null,
        mail_address: null,
        mail_from_name: null,
        password: null,
        encryption: null,
        gateway: null,
        api_key: null,
        content: null,
        view_page: null,
        head_of_department: null,
        from: null,
        to: null,
        user_id: null,
        designation_id: null,
        image: null,
        department_id: null,
        signature_id: null,
        fiscal_year_id: null,
    },

    actions: {
        async brandList({rootState}) {
            let dataFetch = await ApiServices.brandIndex();
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async brandCreate({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            let res = await ApiServices.brandCreate(data);
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

        async brandShow({state, rootState}) {
            let dataFetch = await ApiServices.brandShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async brandEdit({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            let res = await ApiServices.brandEdit(state.id, data);
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

        async departmentList({rootState}) {
            let dataFetch = await ApiServices.departmentIndex();
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async departmentCreate({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('head_of_department', state.head_of_department);
            let res = await ApiServices.departmentCreate(data);
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

        async departmentShow({state, rootState}) {
            let dataFetch = await ApiServices.departmentShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async departmentEdit({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('head_of_department', state.head_of_department);
            let res = await ApiServices.departmentEdit(state.id, data);
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

        async designationList({rootState}) {
            let dataFetch = await ApiServices.designationIndex();
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async designationCreate({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('level', state.level);
            let res = await ApiServices.designationCreate(data);
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

        async designationShow({state, rootState}) {
            let dataFetch = await ApiServices.designationShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async designationEdit({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('level', state.level);
            let res = await ApiServices.designationEdit(state.id, data);
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

        async fiscalYearList({rootState}) {
            let dataFetch = await ApiServices.fiscalYearIndex();
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async fiscalYearCreate({state, rootState}) {
            const data = new FormData();
            data.append('from', state.from);
            data.append('to', state.to);
            let res = await ApiServices.fiscalYearCreate(data);
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

        async fiscalYearShow({state, rootState}) {
            let dataFetch = await ApiServices.fiscalYearShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async fiscalYearEdit({state, rootState}) {
            const data = new FormData();
            data.append('from', state.from);
            data.append('to', state.to);
            let res = await ApiServices.fiscalYearEdit(state.id, data);
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

        async unitList({rootState}) {
            let dataFetch = await ApiServices.unitIndex();
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async unitCreate({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('short_code', state.short_code);
            let res = await ApiServices.unitCreate(data);
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

        async unitShow({state, rootState}) {
            let dataFetch = await ApiServices.unitShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async unitEdit({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('short_code', state.short_code);
            let res = await ApiServices.unitEdit(state.id, data);
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

        async taxList({rootState}) {
            let dataFetch = await ApiServices.taxIndex();
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async taxCreate({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('value', state.value);
            let res = await ApiServices.taxCreate(data);
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

        async taxShow({state, rootState}) {
            let dataFetch = await ApiServices.taxShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async taxEdit({state, rootState}) {
            const data = new FormData();
            data.append('name', state.name);
            data.append('value', state.value);
            let res = await ApiServices.taxEdit(state.id, data);
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


        async settingShow({state, rootState}) {
            let dataFetch = await ApiServices.settingShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async settingEdit({state, rootState}) {
            const data = new FormData();
            data.append('title', state.title);
            data.append('currency', state.currency);
            data.append('time_zone', state.time_zone);
            data.append('date_format', state.date_format);
            data.append('image', state.image);
            data.append('fiscal_year_id', state.fiscal_year_id);
            let res = await ApiServices.settingEdit(state.id, data);
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

        async smsSettingShow({state, rootState}) {
            let dataFetch = await ApiServices.smsSettingShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async smsSettingEdit({state, rootState}) {
            const data = new FormData();
            data.append('gateway', state.gateway);
            data.append('api_key', state.api_key);
            let res = await ApiServices.smsSettingEdit(state.id, data);
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

        async mailSettingShow({state, rootState}) {
            let dataFetch = await ApiServices.mailSettingShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async mailSettingEdit({state, rootState}) {
            const data = new FormData();
            data.append('mail_host', state.mail_host);
            data.append('mail_port', state.mail_port);
            data.append('mail_address', state.mail_address);
            data.append('mail_from_name', state.mail_from_name);
            data.append('password', state.password);
            data.append('encryption', state.encryption);
            let res = await ApiServices.mailSettingEdit(state.id, data);
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

        async mailTemplateList({rootState}) {
            let dataFetch = await ApiServices.mailTemplateIndex();
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async mailTemplateShow({state, rootState}) {
            let dataFetch = await ApiServices.mailTemplateShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async mailTemplateEdit({state, rootState}) {
            const data = new FormData();
            data.append('title', state.title);
            data.append('content', state.content);
            data.append('view_page', state.view_page);
            let res = await ApiServices.mailTemplateEdit(state.id, data);
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

        async signatureList({rootState}) {
            let dataFetch = await ApiServices.signatureIndex();
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async signatureCreate({state, rootState}) {
            const data = new FormData();
            data.append('image', state.image);
            data.append('designation_id', state.designation_id);
            data.append('user_id', state.user_id);
            let res = await ApiServices.signatureCreate(data);
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

        async signatureShow({state, rootState}) {
            let dataFetch = await ApiServices.signatureShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async signatureEdit({state, rootState}) {
            const data = new FormData();
            data.append('image', state.image);
            data.append('user_id', state.user_id);
            data.append('designation_id', state.designation_id);
            let res = await ApiServices.signatureEdit(state.id, data);
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

        async signatureUseDepartmentList({rootState}) {
            let dataFetch = await ApiServices.signatureUseDepartmentIndex();
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async signatureUseDepartmentCreate({state, rootState}) {
            const data = new FormData();
            data.append('department_id', state.department_id);
            data.append('signature_id', state.signature_id);
            let res = await ApiServices.signatureUseDepartmentCreate(data);
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

        async signatureUseDepartmentShow({state, rootState}) {
            let dataFetch = await ApiServices.signatureUseDepartmentShow(state.id);
            if (dataFetch.status === true) {
                return dataFetch;
            } else {
                rootState.home.snackbar = false;
                rootState.home.snackbarText = dataFetch.message;
                rootState.home.snackbarColor = 'failed';
                return dataFetch;
            }
        },

        async signatureUseDepartmentEdit({state, rootState}) {
            const data = new FormData();
            data.append('signature_id', state.signature_id);
            data.append('department_id', state.department_id);
            let res = await ApiServices.signatureUseDepartmentEdit(state.id, data);
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
