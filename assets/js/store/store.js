import Vue from "vue";
import Vuex from "vuex";
import CommonStore from './CommonStore/index';
import DeckStore from './DeckStore/index';
import CardStore from './CardStore/index';
import UserStore from './UserStore/index';
Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        CommonStore: CommonStore,
        DeckStore: DeckStore,
        CardStore: CardStore,
        UserStore: UserStore
    },
});