import {Action, getModule, Module, Mutation, VuexModule} from "vuex-module-decorators";
import Store from "../../../Store";
import LearnerService from "../Service/LearnerService";
import {IName} from "../types";

@Module({dynamic: true, store: Store, name: 'LearnerModule', namespaced: true})
class Learner extends VuexModule implements ILearnerState{
    uploadCheck: boolean = false;
    name: IName = {first: '', last: ''};
    load = false;

    get getName(): IName { return this.name }
    get isUploaded(): boolean { return this.uploadCheck }

    @Mutation
    public loading(value = true) {
        this.load = value;
    }
    @Mutation
    private GET_USER_PROFILE(data: ILearnerResponse)
    {
        this.name = data.name;
        this.uploadCheck = true;
    }

    @Action({rawError: true})
    public async getProfile(): Promise<ILearnerResponse>{
        const response = await LearnerService.profile();
        this.GET_USER_PROFILE(response.data);
        return Promise.resolve(response.data);
    }
}

export interface ILearnerState {
    name: IName;
    load: boolean;
}

export interface ILearnerResponse {
    name: IName;
}

export const LearnerModule = getModule(Learner);