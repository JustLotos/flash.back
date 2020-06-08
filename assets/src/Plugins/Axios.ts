import axios from "axios";
import {AuthModule} from "../Domain/Auth/AuthModule";
import Router from "../Router";
import {AuthResponse} from "../Domain/Auth/types";

let API_URL = process.env.APP_HOST + '/api/v1';

let Axios = axios.create({
    baseURL: process.env.API_URL || 'http://flash.local/api/v1',
    headers: {
        "Content-type": "application/json"
    }
});

Axios.interceptors.response.use(
    (response) => { return response },
    function (error) {
        const originalRequest = error.config;

        if (error.response?.status === 401 && originalRequest.url === API_URL + '/auth/token/refresh') {
            AuthModule.logout();
            Router.push({name: 'Login'});
        }

        debugger;
        if (
            error.response?.status === 401 && !originalRequest._retry &&
            originalRequest.url !== API_URL + Router.resolve({name: 'Login'}) &&
            originalRequest.url !== API_URL + Router.resolve({name: 'Register'})
        ) {
            originalRequest._retry = true;
            return AuthModule.refresh()
                .then((response: AuthResponse) => {
                    // return Axios(originalRequest);
                })
                .catch(()=>{AuthModule.logout();Router.push({name: 'Login'});});
        }
        return Promise.reject(error);
    }
);

Axios.interceptors.request.use(
    config => {
        if (AuthModule.isAuthenticated) {
            config.headers['Authorization'] = 'Bearer ' + AuthModule.token;
        }
        return config;
    },
    error => Promise.reject(error)
);

export default Axios;