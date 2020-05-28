import {setDeckStoreState} from "../../../plugins/helpers";
import {FETCH, FETCHING_DECKS, FETCHING_DECKS_ERROR, FETCHING_DECKS_SUCCESS} from "../constants";
import Vue from "vue";

export default {
    [FETCHING_DECKS](state) {
        state.isLoading = true;
        Vue.delete(state.errors, FETCH);
    },
    [FETCHING_DECKS_SUCCESS](state, decks) {
        state.isLoading = false;
        Vue.delete(state.errors, FETCH);
        decks.forEach((deck)=>{
            setDeckStoreState(state, deck);
        });
    },
    [FETCHING_DECKS_ERROR](state, errors) {
        state.isLoading = false;
        Vue.set(state.errors, FETCH, errors);
    },
}