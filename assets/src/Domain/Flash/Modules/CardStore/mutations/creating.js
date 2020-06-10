import {
    CREATING_CARD,
    CREATING_CARD_ERROR,
    CREATING_CARD_SUCCESS,
} from "../constants";
import {setCardStoreState} from "../../../plugins/helpers";
import Vue from "vue";
import {CREATE} from "../../DeckStore/constants";

export default {
    [CREATING_CARD](state) {
        state.isLoading = true;
        Vue.delete(state.errors, CREATE);
    },
    [CREATING_CARD_SUCCESS](state, card) {
        state.isLoading = false;
        Vue.delete(state.errors, CREATE);
        setCardStoreState(state, card);
    },
    [CREATING_CARD_ERROR](state, errors) {
        state.isLoading = false;
        Vue.set(state.errors, CREATE, errors);
    },
}

