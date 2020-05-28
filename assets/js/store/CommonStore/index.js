import mutations from "./mutations";
import getters from "./getters";
import actions from "./actions";
import {ACCESS_TOKEN, REFRESH_TOKEN} from "./constants";

export default {
    state: {
        accessToken: localStorage.getItem(ACCESS_TOKEN) || null,
        refreshToken: localStorage.getItem(REFRESH_TOKEN) || null,

        isLoading: false,
        errors: errorsDefault()
    },
    getters: getters,
    mutations: mutations,
    actions: actions,
};

export function errorsDefault() {
    return {
        login: null,
        register: null,
        refreshToken: null
    }
}