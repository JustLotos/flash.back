import {
    AUTHENTICATING,
    AUTHENTICATING_ERROR,
    AUTHENTICATING_SUCCESS
} from "./constants";

const mutations = {
    [AUTHENTICATING](state) {
        state.isLoading = true;
        state.errors = null;
        state.isAuthenticated = false;
        state.user = null;
    },
    [AUTHENTICATING_SUCCESS](state, user) {
        state.isLoading = false;
        state.errors = null;
        state.isAuthenticated = true;
        state.user = user;
    },
    [AUTHENTICATING_ERROR](state, errors) {
        state.isLoading = false;
        state.errors = errors;
        state.isAuthenticated = false;
        state.user = null;
    }
};

export default mutations;