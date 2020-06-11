import Axios from "../../../Plugins/Axios";
import {ILearner} from "../types";

export default {
    async profile(): AxiosResponse<ILearner> {
        return Axios.get("/learner/profile");
    }
};