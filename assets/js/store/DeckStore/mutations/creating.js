import {CREATE, CREATING_DECK, CREATING_DECK_ERROR, CREATING_DECK_SUCCESS} from "../constants";
import {setDeckStoreState} from "../../../plugins/helpers";
import Vue from "vue";

export default {
    [CREATING_DECK](state) {
        state.isLoading = true;
        Vue.delete(state.errors, CREATE);
    },
    [CREATING_DECK_SUCCESS](state, deck) {
        state.isLoading = false;
        Vue.delete(state.errors, CREATE);
        setDeckStoreState(state, deck);
    },
    [CREATING_DECK_ERROR](state, errors) {
        state.isLoading = false;
        Vue.set(state.errors, CREATE, errors);
    },
}

