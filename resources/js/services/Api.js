/**
 * Created by Samundra.
 * Date: 15/09/2021
 */
import axios from 'axios'
import store from '../store'
import config from '../config'

const apiUrl = config.baseURL

export default () => {
    //bearer auth token here
    let token = store.state.auth.token;
    let lang = store.state.home.lang;
    if(token === null){
        token = localStorage.getItem('access_token');
    }
    if(lang === null){
        lang = 'en';
    }
    const Api = axios.create({
        baseURL: apiUrl,
        headers: {
            'Accept-Language': lang,
            Authorization: `Bearer ${token}`
        }
    })

    Api.interceptors.request.use(config => {
        return config
    }, error => {
        console.error(error);
        // return Promise.reject(error);
        console.log('here i am now', error)

    })

    Api.interceptors.response.use((response) => {
        return response
    }, function (error) {
        if (error.response) {
            if (error.response.status === 401) {
                console.log('user unauthorized');
            }
            if (error.response.status === 403) {
                console.log('user unauthorized');
            }
        } else if (error.request) {
            console.log({message: 'Network Error'});
        } else {
            console.error('error in code', error);
        }
        return Promise.reject(error.response.data);
    })

    return Api
}
