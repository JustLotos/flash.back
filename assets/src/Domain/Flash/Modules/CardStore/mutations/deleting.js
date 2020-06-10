import Vue from "vue";
import {
    DELETE,
    DELETING_CARD,
    DELETING_CARD_ERROR,
    DELETING_CARD_SUCCESS,
} from "../constants";

export default {
    [DELETING_CARD](state) {
        state.isLoading = true;
        Vue.delete(state.errors, DELETE);
    },
    [DELETING_CARD_SUCCESS](state, card) {
        state.isLoading = false;
        Vue.delete(state.errors, DELETE);
        Vue.delete(state.byId, card.id);
        state.allIds.splice(state.allIds.indexOf(card.id), 1);
    },
    [DELETING_CARD_ERROR](state, errors) {
        state.isLoading = false;
        Vue.set(state.errors, DELETE, errors);
    },
}
