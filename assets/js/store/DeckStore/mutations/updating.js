import {UPDATE, UPDATING_DECK, UPDATING_DECK_ERROR, UPDATING_DECK_SUCCESS} from "../constants";
import {setDeckStoreState} from "../../../plugins/helpers";
import Vue from "vue";

export default {
    [UPDATING_DECK](state) {
        state.isLoading = true;
        Vue.delete(state.errors, UPDATE);
    },
    [UPDATING_DECK_SUCCESS](state, deck) {
        state.isLoading = false;
        Vue.delete(state.errors, UPDATE);
        setDeckStoreState(state, deck);
    },
    [UPDATING_DECK_ERROR](state, errors) {
        state.isLoading = false;
        Vue.set(state.errors, UPDATE, errors);
    },
}