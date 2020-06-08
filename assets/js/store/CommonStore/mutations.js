import {
    ACCESS_TOKEN, AUTHENTICATING, AUTHENTICATING_SUCCESS,
    LOGIN_ERRORS, LOGOUT, REFRESH_TOKEN, REGISTER_ERRORS,
    TOKEN_REFRESH, TOKEN_REFRESH_ERROR, TOKEN_REFRESH_SUCCESS
} from "./constants";
import Vue from "vue";
import {errorsDefault} from "./index";
import {userDefault} from "../UserStore";
import {USER} from "../UserStore/constants";

export default {
    [LOGOUT](state) {
        state.isLoading = false;
        defaultReset(state);
    },
    [AUTHENTICATING](state) {
        defaultReset(state);
        state.isLoading = true;
        state.errors = errorsDefault();
    },

    [AUTHENTICATING_SUCCESS](state, data) {
        state.isLoading = false;
        state.accessToken = data.token;
        state.refreshToken = data.refresh_token;
        Vue.set(state.user, 'roles', data.roles)
        localStorage.setItem(ACCESS_TOKEN, state.accessToken);
        localStorage.setItem(REFRESH_TOKEN, state.refreshToken);
        localStorage.setItem(USER, JSON.stringify(state.user));
    },

    [TOKEN_REFRESH](state) {
        state.isLoading = true;
        localStorage.removeItem(ACCESS_TOKEN);
    },
    [TOKEN_REFRESH_SUCCESS] (state, data) {
        state.isLoading = false;
        state.accessToken = data.token;
        state.refreshToken = data.refresh_token;
        localStorage.setItem(ACCESS_TOKEN, data.token);
        localStorage.setItem(REFRESH_TOKEN, data.refresh_token);
    },
    [TOKEN_REFRESH_ERROR] (state, errors) {
        state.isLoading = false;
        Vue.set(state.errors, 'refreshToken', errors);
    },
    [LOGIN_ERRORS] (state, errors) {
        state.isLoading = false;
        Vue.set(state.errors, 'login', errors);
    },
    [REGISTER_ERRORS] (state, errors) {
        state.isLoading = false;
        Vue.set(state.errors, 'register', errors);
    }
};


function defaultReset(state) {
    state.accessToken = null;
    state.refreshToken = null;
    state.user = userDefault();
    localStorage.removeItem(ACCESS_TOKEN);
    localStorage.removeItem(REFRESH_TOKEN);
    localStorage.removeItem(USER);
}