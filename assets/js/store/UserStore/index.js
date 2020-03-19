import mutations from "./mutations";
import getters from "./getters";
import actions from "./actions";

export default {
    state: {
        isLoading: false,
        errors: null,
        isAuthenticated: false,
        user: null
    },
    getters: getters,
    mutations: mutations,
    actions: actions,
    namespaced: true,
};
