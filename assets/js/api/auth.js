import axios from "./common";
import {API_URL} from "./common";

export default {
    login(loginPayloads) {
        return axios.post(API_URL + "/auth/login", {
            email: loginPayloads.email,
            password: loginPayloads.password,
            remember_me: loginPayloads.rememberMe
        });
    },

    register(registerPayloads) {
        return axios.post(API_URL + "/auth/register", {
            email: registerPayloads.email,
            password: registerPayloads.password,
            plain_password: registerPayloads.plain_password
        });
    },

    refreshToken(refreshToken) {
        return axios.post(API_URL + '/auth/token/refresh', {refresh_token: refreshToken});
    }

};
