import {ICard, IDeck} from "../types";
import Axios from "../../../Plugins/Axios";

export default {
    getAll() {
        return Axios.get("/cards");
    },
    getOne(card: ICard) {
        return Axios.get("/cards/" + card.id);
    },
    delete(card: ICard) {
        return axios.delete("/cards/" + card.id);
    },
    create(deck: IDeck,card: ICard) {
        return axios.post("/cards" + deck.id, card);
    },
    update(card: ICard) {
        return axios.put("/cards/" + card.id, card);
    },
};
