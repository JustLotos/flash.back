import Axios from "../../../Plugins/Axios";
import {ILearnerResponse} from "../Modules/LearnerModule";

export default {
    async profile(): AxiosResponse<ILearnerResponse> {
        return Axios.get("/learner/profile");
    }
};