import mutations from "./mutations";
import getters from "./getters";
import actions from "./actions";

export default {
    state: {
        isLoading: false,
        errorsLogin: null,
        errorsRegister: null,
        isAuthenticated: false,
        token: localStorage.getItem('user-token') || null,
        refresh_token: null,
        roles: []
    },
    getters: getters,
    mutations: mutations,
    actions: actions,
    namespaced: true,
};
