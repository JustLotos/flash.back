import {ICard} from "../types";
import Axios from "../../../Plugins/Axios";
import {AxiosPromise} from "axios";

export default {
    discreteRepeat(): AxiosPromise<Array<ICard>> {
        return Axios.get(`/cards/${card}/repeat/discrete`);
    },
};
