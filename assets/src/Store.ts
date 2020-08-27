import Vue from "vue";
import Vuex from "vuex";
import {IAppState} from "./Domain/App/AppModule";
import {IAuthState} from "./Domain/Auth/AuthModule";
import {ILearnerState} from "./Domain/Flash/Modules/LearnerModule";
import {IDeckState} from "./Domain/Flash/Modules/DeckModule";
import {ICardState} from "./Domain/Flash/Modules/CardModule";

Vue.use(Vuex);

export interface IRootState {
    app: IAppState;
    auth: IAuthState;
    learner: ILearnerState;
    deck: IDeckState;
    card: ICardState;
}

export default new Vuex.Store<IRootState>({})
