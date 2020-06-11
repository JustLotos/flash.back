import {Action, getModule, Module, Mutation, VuexModule} from "vuex-module-decorators";
import Store from "../../../Store";
import LearnerService from "../Service/LearnerService";
import {ILearner, IName} from "../types";

enum ServiceAction { FETCH = 'FETCH', UPDATE = 'UPDATE'  }
enum UploadStatus { EMPTY = 'EMPTY', DETAILS = 'DETAILS', FULL = 'FULL'}

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

    get isUploaded(): boolean           { return !!this.uploadStatus }
    get isUploadedDetails(): boolean    { return this.uploadStatus === UploadStatus.DETAILS }
    get isUploadedFull(): boolean       { return this.uploadStatus === UploadStatus.FULL }
    get getName(): IName                { return this.name }

    get isLoading(): boolean    { return  !!this.currentActionLoad }
    get isFetching(): boolean   { return this.currentActionLoad === ServiceAction.FETCH }
    get isUpdating(): boolean   { return this.currentActionLoad === ServiceAction.UPDATE }

    @Mutation
    public LOADING(value: ServiceAction) {
        this.currentActionLoad = value;
    }
    @Mutation
    public UNSET_LOAD() {
        this.currentActionLoad = null;
    }
    @Mutation
    private GET_USER_PROFILE(data: ILearner) {
        this.name = data.name;
        this.uploadStatus = UploadStatus.DETAILS;
    }
    @Action({rawError: true})
    public async getProfile(): Promise<ILearner>{
        this.LOADING(ServiceAction.FETCH)
        const response = await LearnerService.profile();
        this.GET_USER_PROFILE(response.data);
        this.UNSET_LOAD();
        return response.data;
    }
}

export const LearnerModule = getModule(Learner);