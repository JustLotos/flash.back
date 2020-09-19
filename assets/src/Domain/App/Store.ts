import Vue from "vue";
import Vuex from "vuex";
import {IAppState} from "./AppModule";
import {UserModule} from "../User/UserModule";

Vue.use(Vuex);

export interface IRootState {
    UserModule: UserModule;
    app: IAppState;
}

export const Store = new Vuex.Store<IRootState>({})
