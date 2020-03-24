import {
    CLEAR_LOGIN_ERRORS,
    LOGIN_ERRORS,
} from "../constants";

const mutations = {
    [LOGIN_ERRORS](state, errors) {
        state.errors = errors;
    },
    [CLEAR_LOGIN_ERRORS](state) {
        state.isLoading = null;
    }
};

export default mutations;