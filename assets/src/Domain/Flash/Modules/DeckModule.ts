import Vue from "vue";
import {Action, getModule, Module, Mutation, VuexModule} from "vuex-module-decorators";
import Store from "../../../Store";
import {AxiosResponse} from "axios";
import {IDeck, ITimeIntervals} from "../types";
import DeckService from "../Service/DeckService";

export interface IDeckState {
    current: IDeck;
    byId: {},
    allIds: Array<number>,
    load: boolean;
}

@Module({dynamic: true, store: Store, name: 'DeckModule', namespaced: true})
export default class Deck extends VuexModule implements IDeckState{
    uploadCheck: boolean = false;
    current;
    byId = {};
    allIds = [];
    load = false;

    get isUploaded() { return this.uploadCheck }
    get getDecks() { return this.byId }
    get getDecksId(): Array<number> { return this.allIds }

    get getDeckById() {
        return (id: number) => {
            return this.byId[id];
        };
    }

    get getDeckDefault() {
        let settings: IDeckSettings = { limitRepeat: 20, limitLearning: 20, difficultyIndex: 50, startTimeInterval: 1, minTimeInterval: 1};
        return { details: true, id: null, name: '', description: '', createdAt: null, updatedAt: null, settings: settings};
    }

    get baseTimeIntervals(): Array<ITimeIntervals> {
        return [
            {name: 'm',    value:60},
            {name: '10-m', value:600},
            {name: 'h',    value:3600},
            {name: '2-h',  value:7200},
            {name: '4-h',  value:14400},
            {name: '8-h',  value:28800},
            {name: '16-h', value:57600},
            {name: '24-h',  value:135200},
        ]
    }

    get minTimeIntervals(): Array<ITimeIntervals> {
        return [
            {name: 'm',    value:60},
            {name: '10-m', value:600},
            {name: 'h',    value:3600},
        ]
    }

    @Mutation
    FETCH_DECKS(decks: Array<IDeck>) {
        decks.forEach((deck: IDeck) => {
            deck.details = false;
            Vue.set(this.byId, deck.id, deck);
            if (this.allIds.indexOf(deck.id) < 0 ) {
                this.allIds.push(deck.id);
            }
        });
        this.uploadCheck = true;
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
        deck.details = true;
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
        const response = await DeckService.getOne(deck);
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