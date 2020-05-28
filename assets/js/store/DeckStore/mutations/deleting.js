import Vue from "vue";
import {DELETE, DELETING_DECK, DELETING_DECK_ERROR, DELETING_DECK_SUCCESS} from "../constants";

export default {
    [DELETING_DECK](state) {
        state.isLoading = true;
        Vue.delete(state.errors, DELETE);
    },
    [DELETING_DECK_SUCCESS](state, deck) {
        state.isLoading = false;
        Vue.delete(state.errors, DELETE);
        Vue.delete(state.byId, deck.id);
        state.allIds.splice(state.allIds.indexOf(deck.id), 1)
    },
    [DELETING_DECK_ERROR](state, errors) {
        state.isLoading = false;
        Vue.set(state.errors, DELETE, errors);
    },
}
