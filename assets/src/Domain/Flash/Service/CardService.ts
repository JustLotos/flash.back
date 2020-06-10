import {ICard, IDeck} from "../types";
import Axios from "../../../Plugins/Axios";
import {AxiosPromise} from "axios";

export default {
    getAll(): AxiosPromise<Array<ICard>> {
        return Axios.get("/cards");
    },
    getOne(id: number): AxiosPromise<ICard> {
        return Axios.get("/cards/" + id);
    },
    delete(card: ICard) {
        return axios.delete("/cards/" + card.id);
    },
    create(deck: IDeck, card: ICard): AxiosPromise<ICard> {
        return axios.post("/cards" + deck.id, card);
    },
    update(card: ICard): AxiosPromise<ICard> {
        return axios.put("/cards/" + card.id, card);
    },
};
