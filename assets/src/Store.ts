import Vue from "vue";
import Vuex from "vuex";
import {IAppState} from "./App";
import {IAuthState} from "./Auth";

Vue.use(Vuex);

export interface IRootState {
    app: IAppState;
    auth: IAuthState;
}

export default new Vuex.Store<IRootState>({})
