import Vue from "vue";
import {Action, getModule, Module, Mutation, VuexModule} from "vuex-module-decorators";
import Store from "../../../Store";
import {AxiosResponse} from "axios";
import {IDeck} from "../types";
import {cloneObject} from "../../../Utils/Helpers";
import DeckService from "../Service/DeckService";

export interface IDeckState {
    current: IDeck;
    byId: {},
    allIds: Array<number>,
    load: boolean;
}

@Module({dynamic: true, store: Store, name: 'DeckModule', namespaced: true})
export default class Deck extends VuexModule implements IDeckState{
    current;
    byId = {};
    allIds = [];
    load = false;

    get getDecks() {
        return this.byId;
    }

    get getDecksId(): Array<number> {
        return this.allIds;
    }

    get getCurrent(): IDeck {
        return this.current;
    }

    @Mutation
    FETCH_DECKS(decks: Array<IDeck>) {
        decks.forEach((deck: IDeck) => {
            Vue.set(this.byId, deck.id, deck);
            if (this.allIds.indexOf(deck.id) < 0 ) {
                this.allIds.push(deck.id);
            }
        });
        this.isLoading = false;
    }

    @Mutation
    DELETE_DECK(deck: IDeck) {
        Vue.delete(this.byId, deck.id);
        this.allIds.splice(this.allIds.indexOf(deck.id), 1);
        this.isLoading = false;
    }

    @Mutation
    SET_DECK(deck: IDeck) {
        if(!this.byId) this.byId = {};
        deck = cloneObject(deck);
        Vue.set(this.byId, deck.id, deck);
        if (this.allIds.indexOf(deck.id) < 0) {
            this.allIds.push(deck.id);
        }
        this.isLoading = false;
    }

    @Action({rawError: true})
    async getAll() {
        const response: AxiosResponse<Array<IDeck>> = await DeckService.getAll();
        this.FETCH_DECKS(response.data);
    }

    @Action({rawError: true})
    async getOne(deck: IDeck) {
        const response =await DeckService.getOne(deck);
        this.SET_DECK(response.data);
    }

    @Action({rawError: true})
    async create(deck: IDeck) {
        const response =await DeckService.create(deck);
        this.SET_DECK(response.data);
    }

    @Action({rawError: true})
    async update(deck: IDeck) {
        const response =await DeckService.update(deck);
        this.SET_DECK(response.data);
    }

    @Action({rawError: true})
    async delete(deck: IDeck) {
        const response: AxiosResponse = await DeckService.delete(deck);
        this.DELETE_DECK(deck);
        return Promise.resolve(response.data);
    }
};


export const DeckModule = getModule(Deck);