import {ICard, IDiscreteRepeatAnswer} from "../types";
import Axios from "../../../Plugins/Axios";
import {AxiosPromise} from "axios";

export default {
    discreteRepeat(answer: IDiscreteRepeatAnswer): AxiosPromise<Array<ICard>> {
        return Axios.post(`/cards/${answer.cardId}/repeat/discrete`, answer);
    },
};
