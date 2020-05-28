import mutations from "./mutations/mutations";
import getters from "./getters";
import actions from "./actions";

export default {
    state: {
        current: {},
        byId: {},
        allIds: [],
        isLoading: false,
        errors: errorsDefault()
    },
    getters: getters,
    mutations: mutations,
    actions: actions,
    namespaced: true
};

export function errorsDefault() {
    return {
        getAll: null,
        getOne: null,
        create: null,
        update: null,
        delete: null
    }
}