import AuthAPI from "../../api/auth";
import {
    AUTHENTICATING,
    AUTHENTICATING_ERRORS, AUTHENTICATING_FAILURE,
    AUTHENTICATING_SUCCESS, LOGIN_ERRORS, LOGOUT, REGISTER_ERRORS
} from "./constants";

const actions = {
    async login({commit}, payload) {
        commit(AUTHENTICATING);
        try {
            const response = await AuthAPI.login(
                {
                    email: payload.email,
                    password: payload.password,
                    rememberMe: payload.rememberMe
                }
            );
            commit(AUTHENTICATING_SUCCESS, response.data);
            return response.data;
        } catch (error) {
            // #TODO error.request https://gist.github.com/fgilio/230ccd514e9381fafa51608fcf137253
            commit(AUTHENTICATING_FAILURE);
            commit(LOGIN_ERRORS, error.response.data.errors);
            return null;
        }
    },

    async register({commit}, payload) {
        commit(AUTHENTICATING);
        try {
            const response = await AuthAPI.register(payload);
            commit(AUTHENTICATING_SUCCESS, response.data);
            return response.data;
        } catch (error) {
            commit(AUTHENTICATING_FAILURE, error.response.data.errors);
            commit(REGISTER_ERRORS, error.response.data.errors);
            return null;
        }
    },

    logout({commit}) {
        commit(AUTHENTICATING);
        // #TODO узнать нужен ли endpoint для серверной части
        commit(LOGOUT);
        return true;
    },

    onRefreshApp({commit}) {
        commit(AUTHENTICATING);
        if (localStorage.getItem('access-token')) {
            commit(AUTHENTICATING_SUCCESS, {
                token: localStorage.getItem('access-token'),
                refresh_token: localStorage.getItem('refresh-token'),
                roles: localStorage.getItem('roles')
            });
            return true;
        } else {
            return false;
        }

    }
};

export default actions;