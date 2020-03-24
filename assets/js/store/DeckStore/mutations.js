import {
    FETCHING_DECKS,
    FETCHING_DECKS_SUCCESS,
    FETCHING_DECKS_ERROR
} from "./constants";

const mutations = {
    [FETCHING_DECKS](state) {
        state.isLoading = true;
        state.errors = null;
        state.decks = null;
    },
    [FETCHING_DECKS_SUCCESS](state, data) {
        state.isLoading = false;
        state.errors = null;
        state.decks = data;
    },
    [FETCHING_DECKS_ERROR](state, errors) {
        state.isLoading = false;
        state.errors = errors;
        state.decks = null;
    }
};

export default mutations;