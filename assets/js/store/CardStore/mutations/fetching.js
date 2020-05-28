import {setCardStoreState} from "../../../plugins/helpers";
import {FETCH, FETCHING_CARDS, FETCHING_CARDS_ERROR, FETCHING_CARDS_SUCCESS} from "../constants";
import Vue from "vue";

export default {
    [FETCHING_CARDS](state) {
        state.isLoading = true;
        Vue.delete(state.errors, FETCH);
    },
    [FETCHING_CARDS_SUCCESS](state, deck) {
        state.isLoading = false;
        Vue.delete(state.errors, FETCH);
        deck.cards.forEach((card)=>{
            setCardStoreState(state, card, deck.id);
        });
    },
    [FETCHING_CARDS_ERROR](state, errors) {
        state.isLoading = false;
        Vue.set(state.errors, FETCH, errors);
    },
}