import axios from "../../../Plugins/Axios";
import {AxiosPromise} from "axios";
import {RouterApi} from "../../App/RouterAPI";

export default{
    fetchAll(type: string = 'DEFAULT'): AxiosPromise<Array<IDeck>> {
        return axios.get( RouterApi.getUrlByName('Decks').path + `?type=${type}`);
    },
    fetchOne(id: number, type: string = 'DEFAULT'): AxiosPromise<IDeck> {
        return axios.get(RouterApi.getUrlByName('Deck').path + `${id}?type=${type}`);
    },
    delete(deck: IDeck): AxiosPromise {
        return axios.delete(RouterApi.getUrlByName('Deck').path + `${deck.id}`);
    },
    create(deck: IDeck): AxiosPromise<IDeck> {
        return axios.post(RouterApi.getUrlByName('Deck').path, deck);
    },
    update(deck: IDeck): AxiosPromise<IDeck> {
        return axios.put(RouterApi.getUrlByName('Deck').path + `${deck.id}`, deck);
    }
};
