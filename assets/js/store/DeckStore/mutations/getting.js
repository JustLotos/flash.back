import {setDeckStoreState} from "../../../plugins/helpers";
import {GET, GETTING_DECK, GETTING_DECK_ERROR, GETTING_DECK_SUCCESS} from "../constants";
import Vue from "vue";

export default {
    [GETTING_DECK](state) {
        state.isLoading = true;
        Vue.delete(state.errors, GET);
    },
    [GETTING_DECK_SUCCESS](state, deck) {
        state.isLoading = false;
        Vue.delete(state.errors, GET);
        setDeckStoreState(state, deck);
    },
    [GETTING_DECK_ERROR](state, errors) {
        state.isLoading = false;
        Vue.set(state.errors, GET, errors);
    },
}

