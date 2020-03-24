import axios from "./common";
import {API_URL} from "./common";
// #TODO вынести валидацию в отдельный файл
export default {
    login(loginPayloads) {
        return axios.post(API_URL+"/auth/login", {
                email: loginPayloads.email,
                password: loginPayloads.password,
                rememberMe: loginPayloads.rememberMe
        });
    },
    register(registerPayloads) {
        return axios.post(API_URL+"/auth/register", {
            email: registerPayloads.email,
            password: registerPayloads.password,
            plain_password: registerPayloads.plain_password
        });
    }
};
