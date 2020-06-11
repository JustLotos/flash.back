import {Action, getModule, Module, Mutation, VuexModule} from "vuex-module-decorators";
import Store from "../../../Store";
import LearnerService from "../Service/LearnerService";
import {ILearner, IName} from "../types";

enum ServiceAction { FETCH = 1, UPDATE  }
enum UploadStatus { EMPTY, DETAILS, FULL}

export interface ILearnerState {
    name: IName;
    currentActionLoad: ServiceAction | null;
    uploadStatus: UploadStatus;
}

@Module({dynamic: true, store: Store, name: 'LearnerModule', namespaced: true})
class Learner extends VuexModule implements ILearnerState{
    name: IName = {first: '', last: ''};
    currentActionLoad = null;
    uploadStatus = UploadStatus.EMPTY;

    get getName(): IName { return this.name }
    get isUploaded(): boolean { return !!this.uploadStatus }

    @Mutation
    public loading(value = true) {
        this.load = value;
    }
    @Mutation
    private GET_USER_PROFILE(data: ILearner)
    {
        this.name = data.name;
        this.uploadStatus = UploadStatus.DETAILS;
    }

    @Action({rawError: true})
    public async getProfile(): Promise<ILearner>{
        const response = await LearnerService.profile();
        this.GET_USER_PROFILE(response.data);
        return response.data;
    }
}

export const LearnerModule = getModule(Learner);