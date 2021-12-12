/**
 * Created by Samundra.
 * Date: 15/09/2021
 */
import ApiServices from "../../services/ApiServices";
import i18n from "../../i18n";
import store from "../index";

async function fetchUserInformation(rootState) {
    let userData = await ApiServices.getUserInformation();
    if (userData.success === true) {
        rootState.home.user = userData.data;
        localStorage.setItem('userData', JSON.stringify(userData.data));
        // rootState.home.snackbar = true;
        // rootState.home.snackbarText = 'Registration successful!';
        // rootState.home.snackbarColor = 'success';
        return true;
    } else {
        return userData.message;
    }
}

export default {

    namespaced: true,

    state: {
        isLoggedIn: false,
        token: null,
        name: null,
        username: null,
        password: null,
        c_password: null,
        provider: null,
        auth_token: null,
        first_name: null,
        middle_name: null,
        last_name: null,
        mobile_no: null,
        address: null,
    },

    mutations: {
        setToken(state, token) {
            state.token = token;
            state.isLoggedIn = true;
        },
    },

    actions: {
        async registerUser({state, rootState}) {
            const data = new FormData();
            data.append('first_name', state.first_name);
            data.append('last_name', state.last_name);
            data.append('middle_name', state.middle_name);
            data.append('email', state.email);
            data.append('password', state.password);
            data.append('confirm_password', state.confirm_password);
            data.append('username', state.username);
            data.append('mobile_no', state.mobile_no);
            data.append('address', state.address);
            const res = await ApiServices.register(data);
            if (res.success === true) {
                state.token = res.data.access_token;
                state.isLoggedIn = true;
                localStorage.setItem('access_token', res.data.access_token);
                localStorage.setItem('isLoggedIn', 'true');
                localStorage.setItem('userData', JSON.stringify(res.data));
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'success';
                return true;
            } else {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'red';
                return res;
            }
        },

        async getUserInformation({rootState}) {
            let userFetch = await fetchUserInformation(rootState);
            // console.log('information from user', userFetch);
            if (userFetch === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = 'Login success!';
                rootState.home.snackbarColor = 'success';
            } else {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = 'Login success, could not fetch user right now!';
                rootState.home.snackbarColor = 'success';
            }
        },

        async loginUser({state, rootState}) {
            const data = new FormData();
            data.append('username', state.username);
            data.append('password', state.password);
            let res = await ApiServices.login(data);
            if (res.success === true) {
                state.token = res.data.access_token;
                state.isLoggedIn = true;
                localStorage.setItem('access_token', res.data.access_token);
                localStorage.setItem('isLoggedIn', 'true');
                localStorage.setItem('userData', JSON.stringify(res.data));
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'success';
                return true;
            } else {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'red';
                return res;
            }
        },

        async socialLoginRegister({state, rootState}) {
            const data = new FormData();
            data.append('provider', state.provider);
            data.append('auth_token', state.auth_token);
            let res = await ApiServices.socialLoginRegister(data);
            if (res.success === true) {
                state.token = res.data[0].access_token;
                state.refreshToken = res.data[0].refresh_token;
                state.isLoggedIn = true;
                localStorage.setItem('access_token', res.data[0].access_token);
                localStorage.setItem('refresh_token', res.data[0].refresh_token);
                localStorage.setItem('isLoggedIn', 'true');
                let userFetch = await fetchUserInformation(rootState);
                // console.log('information from user', userFetch);
                if (userFetch === true) {
                    rootState.home.snackbar = true;
                    rootState.home.snackbarText = 'Login success!';
                    rootState.home.snackbarColor = 'success';
                    return true;
                } else {
                    rootState.home.snackbar = true;
                    rootState.home.snackbarText = 'Login success, could not fetch user right now!';
                    rootState.home.snackbarColor = 'success';
                    return true;
                }
            } else {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = 'Login failed!';
                rootState.home.snackbarColor = 'red';
                return false;
            }
        },

        async errorRegister({rootState}) {
            rootState.home.snackbar = true;
            rootState.home.snackbarText = 'Failed!';
            rootState.home.snackbarColor = 'red';
            return false;
        },

        async logoutUser({state, rootState}) {
            let res = await ApiServices.logout();
            state.token = null;
            state.refreshToken = null;
            state.isLoggedIn = false;
            localStorage.setItem('access_token', '');
            localStorage.setItem('isLoggedIn', 'false');
            localStorage.setItem('userData', '');
            rootState.home.snackbar = true;
            rootState.home.snackbarText = res.message;
            rootState.home.snackbarColor = 'success';
            return true;
        },

        async resetUserPassword({state, rootState}, data) {
            let res = await ApiServices.reset(data);
            if (res.success === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'success';
                return true;
            } else {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'red';
                return res;
            }
        },

        async resetUserForgotPassword({state, rootState}, data) {
            let res = await ApiServices.resetForgotPassword(data);
            if (res.success === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'success';
                return true;
            } else {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'red';
                return res;
            }
        },

        async forgotPassword({state, rootState}, data) {
            let res = await ApiServices.forgotPassword(data);
            if (res.success === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'success';
                return true;
            } else {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'red';
                return res;
            }
        },

        async verifyResetCode({state, rootState}, data) {
            let res = await ApiServices.verifyCode(data);
            if (res.success === true) {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'success';
                return res;
            } else {
                rootState.home.snackbar = true;
                rootState.home.snackbarText = res.message;
                rootState.home.snackbarColor = 'red';
                return res;
            }
        }
    },
}

