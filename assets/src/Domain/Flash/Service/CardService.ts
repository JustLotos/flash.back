import {ICard} from "../types";
import Axios from "../../../Plugins/Axios";
import {AxiosPromise} from "axios";

export default {
    getAll(): AxiosPromise<Array<ICard>> {
        return Axios.get("/cards");
    },
    getOne(cardId: number): AxiosPromise<ICard> {
        return Axios.get(`/cards/${cardId}`);
    },
    getOneFull(cardId: number): AxiosPromise<ICard> {
        return Axios.get(`/cards/${cardId}/?type=FULL`);
    },
    delete(card: ICard) {
        return axios.delete(`/cards/${card.id}`);
    },
    create(deckId: number, card: ICard): AxiosPromise<ICard> {
        return axios.post(`/cards${deckId}`, card);
    },
    update(card: ICard): AxiosPromise<ICard> {
        return axios.put(`/cards/${card.id}`, card);
    },
};
