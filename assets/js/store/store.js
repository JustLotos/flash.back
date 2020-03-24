import Vue from "vue";
import Vuex from "vuex";
import UserStore from './UserStore/index';
import DeckStore from './DeckStore/index';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        UserStore: UserStore,
        DeckStore: DeckStore
    }
});