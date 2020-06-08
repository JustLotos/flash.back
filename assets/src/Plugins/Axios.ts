import axios, {AxiosRequestConfig} from "axios";
import {AuthModule} from "../Domain/Auth/AuthModule";
import Router from "../Domain/Auth/Guard";
import {LearnerModule} from "../Domain/Flash/Modules/LearnerModule";

let Axios = axios.create({
    baseURL: process.env.API_URL || 'http://flash.local/api/v1',
    headers: {
        "Content-type": "application/json"
    }
});

Axios.interceptors.response.use(
    (response) => { return response },
    function (error) {
        const originalRequest: AxiosRequestConfig = error.config;

        AuthModule.loading(false);
        LearnerModule.loading(false);

        if (error.response?.status === 401 && originalRequest.url === '/auth/token/refresh') {
            AuthModule.logout();
            return Router.push({name: 'Login'});
        }

        if (
            error.response?.status === 401 && !originalRequest._retry &&
            originalRequest.url !== '/auth/login' &&
            originalRequest.url !== '/auth/register'&&
            originalRequest.url !== '/auth/reset/password'
        ) {
            originalRequest._retry = true;
            AuthModule.refresh().then(() => {
                error.config.headers.common['Authorization'] = 'Bearer' + AuthModule.getToken;
                return axios(originalRequest);
            });
        }
        return Promise.reject(error);
    }
);

Axios.interceptors.request.use(
    config => {
        if (AuthModule.isAuthenticated) {
            config.headers['Authorization'] = 'Bearer ' + AuthModule.getToken;
        }
        return config;
    },
    error => Promise.reject(error)
);

export default Axios;