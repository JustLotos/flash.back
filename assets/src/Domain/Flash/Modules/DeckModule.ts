import Vue from "vue";
import {Action, getModule, Module, Mutation, VuexModule} from "vuex-module-decorators";
import Store from "../../../Store";
import {AxiosResponse} from "axios";
import {IDeck, ITimeIntervals} from "../types";
import DeckService from "../Service/DeckService";
import {cloneObject} from "../../../Utils/Helpers";
import {CardModule} from "./CardModule";

export interface IDeckState {
    current: IDeck;
    byId: {},
    allIds: Array<number>,
    currentActionLoad: ServiceActions | null;
}
enum UploadStatus { EMPTY,LIST,DETAILS,FULL}
enum ServiceActions { FETCH_ALL = 1, FETCH_ONE, CREATE, UPDATE, DELETE }

@Module({dynamic: true, store: Store, name: 'DeckModule', namespaced: true})
export default class Deck extends VuexModule implements IDeckState{
    current;
    byId = {};
    allIds = [];
    /** Загрузка - используется для анимации лодаера при начально загрузке стриниц */
    currentActionLoad: ServiceActions | null = null;
    /** Ступень загрузки - используется для оптимизация количества запросов */
    uploadStatus: UploadStatus = UploadStatus.EMPTY;

    get isUploaded() { return !!this.uploadStatus }
    get isUploadedFull() { return this.uploadStatus === UploadStatus.FULL; }
    get getUploaded() { return this.uploadStatus }

    get isLoading():            boolean { return !!this.currentActionLoad }
    get isFetchAllLoading():    boolean { return this.currentActionLoad == ServiceActions.FETCH_ALL }
    get isFetchOneLoading():    boolean { return this.currentActionLoad == ServiceActions.FETCH_ONE }
    get isCreatLoading():       boolean { return this.currentActionLoad == ServiceActions.CREATE }
    get isUpdateLoading():      boolean { return this.currentActionLoad == ServiceActions.UPDATE }
    get isDeleteLoading():      boolean { return this.currentActionLoad == ServiceActions.DELETE }

    get getDecks() {
        return this.byId
    }
    get getDecksId(): Array<number> {
        return this.allIds
    }
    get getDeckById() {
        return (id: number): IDeck => {
            return this.byId[id];
        };
    }
    get getDeckDefault(): IDeck {
        return {
            id: -1,
            name: '',
            description: '',
            settings: {
                limitRepeat: 20,
                limitLearning: 20,
                difficultyIndex: 50,
                startTimeInterval: 1,
                minTimeInterval: 1
            }
        };
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
    public LOADING(value = null) {
        this.currentActionLoad = value;
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
        this.uploadStatus = UploadStatus.LIST;
    }
    @Mutation
    FETCH_DECKS_FULL(decks: Array<IDeck>) {
        decks.forEach((deck: IDeck) => {
            deck.details = true;
            deck = cloneObject(deck);
            if (deck.cards) {
                deck.cards = deck.cards.map(card => card.id);
            }
            Vue.set(this.byId, deck.id, deck);
            if (this.allIds.indexOf(deck.id) < 0 ) {
                this.allIds.push(deck.id);
            }
        });
        this.uploadStatus = UploadStatus.FULL;
    }
    @Mutation
    SET_DECK(deck: IDeck) {
        deck.details = true;
        deck = cloneObject(deck);
        if (deck.cards) {
            deck.cards = deck.cards.map(card => card.id);
        }

        // this.minTimeIntervals.forEach((interval)=> {
        //      if(interval.value === deck.settings.minTimeInterval) {
        //          deck.settings.minTimeInterval = interval.value;
        //      }
        // });
        Vue.set(this.byId, deck.id, deck);
        if (this.allIds.indexOf(deck.id) < 0) {
            this.allIds.push(deck.id);
        }
        this.uploadStatus = UploadStatus.DETAILS;
    }
    @Mutation
    DELETE_DECK(deck: IDeck) {
        Vue.delete(this.byId, deck.id);
        this.allIds.splice(this.allIds.indexOf(deck.id), 1);
    }

    @Action({rawError: true})
    async fetchAll(): Promise<Array<IDeck>> {
        this.LOADING(ServiceActions.FETCH_ALL);
        const response: AxiosResponse<Array<IDeck>> = await DeckService.fetchAll();
        this.FETCH_DECKS(response.data);
        this.LOADING();
        return response.data;
    }
    @Action({rawError: true})
    async fetchAllFull(): Promise<Array<IDeck>> {
        this.LOADING(ServiceActions.FETCH_ALL);
        const response: AxiosResponse<Array<IDeck>> = await DeckService.fetchAll('FULL');
        this.FETCH_DECKS_FULL(response.data);
        response.data.forEach((deck: IDeck)=>{
            CardModule.FETCH_CARDS_FULL_FROM_DECK(deck);
        })
        this.LOADING();
        return response.data;
    }
    @Action({rawError: true})
    async fetchOne(id: number): Promise<IDeck> {
        this.LOADING(ServiceActions.FETCH_ONE)
        const response: AxiosResponse<IDeck> = await DeckService.fetchOne(id);
        this.SET_DECK(response.data);
        this.LOADING();
        return response.data;
    }
    @Action({rawError: true})
    async fetchOneFull(id: number): Promise<IDeck> {
        this.LOADING(ServiceActions.FETCH_ONE);
        const response = await DeckService.fetchOne(id, 'FULL');
        this.SET_DECK(response.data);
        CardModule.FETCH_CARDS_FROM_DECK(response.data);
        this.LOADING();
        return response.data;
    }
    @Action({rawError: true})
    async create(deck: IDeck): Promise<IDeck> {
        this.LOADING(ServiceActions.CREATE);
        const response: AxiosResponse<IDeck> = await DeckService.create(deck);
        this.SET_DECK(response.data);
        this.LOADING();
        return response.data;
    }
    @Action({rawError: true})
    async update(deck: IDeck): Promise<IDeck> {
        this.LOADING(ServiceActions.UPDATE);
        const response =await DeckService.update(deck);
        this.SET_DECK(response.data);
        this.LOADING();
    }
    @Action({rawError: true})
    async delete(deck: IDeck) {
        this.LOADING(ServiceActions.DELETE);
        await DeckService.delete(deck);
        this.DELETE_DECK(deck);
        this.LOADING();
    }
};

export const DeckModule = getModule(Deck);