import AuthAPI from "../../../api/auth";
import {
    AUTHENTICATING,
    AUTHENTICATING_FAILURE,
    LOGIN_ERRORS,
    CLEAR_LOGIN_ERRORS,
    AUTHENTICATING_SUCCESS,
} from "../constants";

const actions = {
    async login({commit}, payload) {
        commit(AUTHENTICATING);
        try {
            const response = await AuthAPI.login(payload);
            commit(AUTHENTICATING_SUCCESS, response.data);
            commit(CLEAR_LOGIN_ERRORS);
            return response.data;
        } catch (error) {
            // #TODO error.request https://gist.github.com/fgilio/230ccd514e9381fafa51608fcf137253
            commit(AUTHENTICATING_FAILURE);
            commit(LOGIN_ERRORS, error.response.data.errors);
            return null;
        }
    },
};

export default actions;