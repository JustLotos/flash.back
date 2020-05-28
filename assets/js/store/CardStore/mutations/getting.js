import {GET, GETTING_CARD, GETTING_CARD_ERROR, GETTING_CARD_SUCCESS} from "../constants";
import {setCardStoreState} from "../../../plugins/helpers";
import Vue from "vue";

export default {
    [GETTING_CARD](state) {
        state.isLoading = true;
        Vue.delete(state.errors, GET);
    },
    [GETTING_CARD_SUCCESS](state, card) {
        state.isLoading = false;
        Vue.delete(state.errors, GET);
        setCardStoreState(state, card);
    },
    [GETTING_CARD_ERROR](state, errors) {
        state.isLoading = false;
        Vue.set(state.errors, GET, errors);
    },
}