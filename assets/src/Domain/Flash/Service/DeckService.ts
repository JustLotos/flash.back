import axios from "../../../Plugins/Axios";
import {IDeck} from "../types";
import {AxiosPromise} from "axios";

export default  {
    getAll(type: string = 'DEFAULT'): AxiosPromise<Array<IDeck>> {
        if(type === 'DEFAULT') {
            return axios.get("/decks");
        } else if (type === 'DETAIL') {
            return axios.get("/decks?type=DETAIL");
        } else if (type === 'FULL') {
            return axios.get("/decks?type=FULL");
        }
    },
    getOne(id: number, type: string = 'DEFAULT'): AxiosPromise<IDeck> {
        if(type === 'DEFAULT') {
            return axios.get("/decks/" + id);
        } else if(type === 'FULL') {
            return axios.get("/decks/" + id);
        }
    },
    delete(deck: IDeck): AxiosPromise {
        return axios.delete("/decks/" + deck.id);
    },
    create(deck: IDeck): AxiosPromise<IDeck> {
        return axios.post("/decks", deck);
    },
    update(deck: IDeck): AxiosPromise<IDeck> {
        return axios.put("/decks/" + deck.id, deck);
    },
};
