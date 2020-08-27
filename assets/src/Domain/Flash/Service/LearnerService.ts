import Axios from "../../../Plugins/Axios";
import {ILearner} from "../types";
import {AxiosResponse} from "axios";

export default {
    async profile(): AxiosResponse<ILearner> {
        return Axios.get("/learner/profile");
    },
    async sendSession(session): AxiosResponse {
        return Axios.post("/learner/session", session);
    }
};