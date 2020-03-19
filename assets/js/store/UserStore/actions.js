import AuthAPI from "../../api/auth";
import {
    AUTHENTICATING,
    AUTHENTICATING_ERROR,
    AUTHENTICATING_SUCCESS
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
            commit(AUTHENTICATING_ERROR, error.response.data.errors);
            return null;
        }
    }
};

export default actions;