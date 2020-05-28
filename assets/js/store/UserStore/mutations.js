import {GETTING_USER_PROFILE, GETTING_USER_PROFILE_FAILURE, GETTING_USER_PROFILE_SUCCESS, USER} from "./constants";
import Vue from "vue";

export default {
    [GETTING_USER_PROFILE](state) {
        state.isLoading = true;
        Vue.delete(state, USER);
    },
    [GETTING_USER_PROFILE_SUCCESS](state, user) {
        state.isLoading = false;
        Vue.set(state, USER, user);
    },
    [GETTING_USER_PROFILE_FAILURE](state, errors) {
        state.isLoading = false;
        console.log(errors);
    },
}