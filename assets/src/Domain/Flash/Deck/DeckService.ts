import axios from "../../../Plugins/Axios";
import {IDeck} from "../types";
import {AxiosPromise} from "axios";

export default  {
    fetchAll(type: string = 'DEFAULT'): AxiosPromise<Array<IDeck>> {
        return axios.get(`/decks/?type=${type}`);
    },
    fetchOne(id: number, type: string = 'DEFAULT'): AxiosPromise<IDeck> {
        return axios.get(`/decks/${id}?type=${type}`);
    },
    delete(deck: IDeck): AxiosPromise {
        return axios.delete(`/decks/${deck.id}`);
    },
    create(deck: IDeck): AxiosPromise<IDeck> {
        return axios.post(`/decks`, deck);
    },
    update(deck: IDeck): AxiosPromise<IDeck> {
        return axios.put(`/decks/${deck.id}`, deck);
    },
};
