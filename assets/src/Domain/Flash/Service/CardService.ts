import {ICard} from "../types";
import Axios from "../../../Plugins/Axios";
import {AxiosPromise} from "axios";

export default {
    getAll(): AxiosPromise<Array<ICard>> {
        return Axios.get("/cards");
    },
    getOne(cardId: number, type: string = 'DEFAULT'): AxiosPromise<ICard> {
        return Axios.get(`/cards/${cardId}/?type=${type}`);
    },
    delete(card: ICard) {
        return Axios.delete(`/cards/${card.id}`);
    },
    create(card: ICard): AxiosPromise<ICard> {
        return Axios.post(`/cards/${card.deck}`, card);
    },
    update(card: ICard): AxiosPromise<ICard> {
        console.log(card);
        return Axios.put(`/cards/${card.id}`, card);
    },
};
