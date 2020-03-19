import Vue from "vue";
import Vuex from "vuex";
import UserModule from './UserStore/index';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        user: UserModule
    }
});