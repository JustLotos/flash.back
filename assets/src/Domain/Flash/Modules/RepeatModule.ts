import {Action, getModule, Module, Mutation, VuexModule} from "vuex-module-decorators";
import Store from "../../../Store";
import {AxiosResponse} from "axios";
import {IDiscreteRepeatAnswer} from "../types";
import RepeatService from "../Service/RepeatService";
import {CardModule} from "./CardModule";
@Module({dynamic: true, store: Store, name: 'RepeatModule', namespaced: true})

export default class Repeat extends VuexModule{
    @Action({rawError: true})
    async repeatDiscrete(answer: IDiscreteRepeatAnswer): Promise<any> {
        const response: AxiosResponse = await RepeatService.discreteRepeat(answer);
        CardModule.SET_CARD(response.data);
    }
};

export const RepeatModule = getModule(Repeat);