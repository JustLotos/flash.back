import axios from "../../../Plugins/Axios";
import {IDeck} from "../types";
import {AxiosPromise} from "axios";

export default  {
    getAll(): AxiosPromise<Array<IDeck>> {
        return axios.get("/decks");
    },
    getOne(deck: IDeck): AxiosPromise<IDeck> {
        return axios.get("/decks/" + deck.id);
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
