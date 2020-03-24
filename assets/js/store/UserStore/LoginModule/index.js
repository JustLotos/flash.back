import mutations from "./mutations";
import getters from "./getters";
import actions from "./actions";

export default {
    state: {
        errors: null,
    },
    getters: getters,
    mutations: mutations,
    actions: actions,
    namespaced: true
};
