import {
    AUTHENTICATING,
    AUTHENTICATING_FAILURE,
    AUTHENTICATING_SUCCESS,
    LOGIN_ERRORS, LOGOUT,
    REGISTER_ERRORS
} from "./constants";

const mutations = {
    [AUTHENTICATING](state) {
        state.isLoading = true;
        state.isAuthenticated = false;
        state.token = null;
        state.refreshToken = null;
        state.roles = [];
        state.errorsLogin = null;
        state.errorsRegister = null;
    },
    [AUTHENTICATING_SUCCESS](state, data) {
        state.isLoading = false;
        state.isAuthenticated = true;
        state.token = data.token;
        state.refreshToken = data.refresh_token;
        state.roles = data.roles;
        localStorage.setItem('access-token', data.token);
        localStorage.setItem('refresh-token', data.refresh_token);
        localStorage.setItem('roles', data.roles);
    },
    [AUTHENTICATING_FAILURE](state) {
        state.isLoading = false;
        state.isAuthenticated = false;
        state.user = null;
        state.token = null;
        state.refreshToken = null;
        state.roles = [];
    },
    [LOGIN_ERRORS](state, errors){
        state.errorsLogin = errors;
    },
    [REGISTER_ERRORS](state, errors){
        state.errorsRegister = errors;
    },
    [LOGOUT](state) {
        localStorage.removeItem('access-token');
        localStorage.removeItem('refresh-token');
        localStorage.removeItem('roles');
        state.isLoading = false;
    }
};

export default mutations;