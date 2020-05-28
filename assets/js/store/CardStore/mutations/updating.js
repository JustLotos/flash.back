import {
    UPDATE,
    UPDATING_CARD,
    UPDATING_CARD_ERROR,
    UPDATING_CARD_SUCCESS,
} from "../constants";
import {setCardStoreState} from "../../../plugins/helpers";
import Vue from "vue";

export default {
    [UPDATING_CARD](state) {
        state.isLoading = true;
        Vue.delete(state.errors, UPDATE);
    },
    [UPDATING_CARD_SUCCESS](state, deck) {
        state.isLoading = false;
        Vue.delete(state.errors, UPDATE);
        setCardStoreState(state, deck);
    },
    [UPDATING_CARD_ERROR](state, errors) {
        state.isLoading = false;
        Vue.set(state.errors, UPDATE, errors);
    },
}