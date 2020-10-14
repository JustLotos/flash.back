import Vue from "vue";
import {Action, getModule, Module, Mutation, VuexModule} from "vuex-module-decorators";
import {AxiosResponse} from "axios";
import DeckService from "./DeckService";
import {cloneObject} from "../../../Utils/Helpers";

enum ServiceAction { FETCH_ALL = 'FETCH_ALL', FETCH_ONE = 'FETCH_ONE', CREATE = 'CREATE', UPDATE = 'UPDATE', DELETE='DELETE'}

@Module({dynamic: true, store: Store, name: 'DeckModule', namespaced: true})
export default class Deck extends VuexModule implements IDeckState{
    byId = {};
    allIds = [];
    currentActionLoad = null;
    uploadStatus: UploadStatus = UploadStatus.EMPTY;
    dateIntervalRegex = /\d+/;


    get isUploadedList()        {
        return this.uploadStatus === UploadStatus.LIST
            || this.uploadStatus === UploadStatus.DETAILS
            || this.uploadStatus === UploadStatus.FULL;
    }
    get isUploadedDetails()     {
        return this.uploadStatus === UploadStatus.DETAILS
            || this.uploadStatus === UploadStatus.LIST;
    }
    get isUploadedFull()        {
        return this.uploadStatus === UploadStatus.FULL;
    }

    get getUploaded()           { return this.uploadStatus }
    get isActionLoading():            boolean { return !!this.currentActionLoad }
    get isActionFetchAllLoading():    boolean { return this.currentActionLoad == ServiceAction.FETCH_ALL }
    get isActionFetchOneLoading():    boolean { return this.currentActionLoad == ServiceAction.FETCH_ONE }
    get isActionCreatLoading():       boolean { return this.currentActionLoad == ServiceAction.CREATE }
    get isActionUpdateLoading():      boolean { return this.currentActionLoad == ServiceAction.UPDATE }
    get isActionDeleteLoading():      boolean { return this.currentActionLoad == ServiceAction.DELETE }
    get getCurrentActionLoad(): ServiceAction { return this.currentActionLoad }

    get getDecks() { return this.byId }
    get getDecksId(): Array<number> { return this.allIds }
    get getDeckById() { return (id: number): IDeck =>  this.byId[id] }

    get isRealDeck() { return (deck: IDeck) => { return deck.id !== -1} }
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
    public LOADING(value: ServiceAction) {
        this.currentActionLoad = value;
    }
    @Mutation
    public UNSET_LOAD() {
        this.currentActionLoad = null;
    }

    @Mutation
    REMOVE_CARD_FROM_DECK(card: ICard) {
        if(card.deck) {
            let index = this.byId[card.deck].cards.indexOf(card.id);
            this.byId[card.deck].cards.splice(index, 1);
        }
    }

    @Mutation
    ADD_NEW_CARD_TO_DECK(card: ICard) {
        this.byId[card.deck].cards.push(card.id);
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
            deck = cloneObject(deck);
            deck.details = true;
            deck.settings.startTimeInterval =
                Number((String(deck.settings.startTimeInterval)).match(this.dateIntervalRegex)[0]);
            deck.settings.minTimeInterval =
                Number((String(deck.settings.minTimeInterval)).match(this.dateIntervalRegex)[0]);
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
        deck.settings.startTimeInterval =
            Number((String(deck.settings.startTimeInterval)).match(this.dateIntervalRegex)[0]);
        deck.settings.minTimeInterval =
            Number((String(deck.settings.minTimeInterval)).match(this.dateIntervalRegex)[0]);
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
        this.LOADING(ServiceAction.FETCH_ALL);
        const response: AxiosResponse<Array<IDeck>> = await DeckService.fetchAll();
        this.FETCH_DECKS(response.data);
        this.UNSET_LOAD();
        return response.data;
    }
    @Action({rawError: true})
    async fetchAllFull(): Promise<Array<IDeck>> {
        this.LOADING(ServiceAction.FETCH_ALL);
        const response: AxiosResponse<Array<IDeck>> = await DeckService.fetchAll('FULL');
        this.FETCH_DECKS_FULL(response.data);
        response.data.forEach((deck: IDeck)=>{
            if(deck.cards) {
                CardModule.FETCH_CARDS_FULL_FROM_DECK(deck);
            }
        })
        this.UNSET_LOAD();
        return response.data;
    }

    @Action({rawError: true})
    async fetchOneFull(id: number): Promise<IDeck> {
        this.LOADING(ServiceAction.FETCH_ONE);
        const response = await DeckService.fetchOne(id, 'FULL');
        let deck: IDeck = response.data;
        this.SET_DECK(deck);
        if(deck.cards) {
            CardModule.FETCH_CARDS_FULL_FROM_DECK(deck);
        }
        this.UNSET_LOAD();
        return deck;
    }

    @Action({rawError: true})
    async fetchOne(id: number): Promise<IDeck> {
        this.LOADING(ServiceAction.FETCH_ONE)
        const response: AxiosResponse<IDeck> = await DeckService.fetchOne(id);
        this.SET_DECK(response.data);
        this.UNSET_LOAD();
        return response.data;
    }

    @Action({rawError: true})
    async create(deck: IDeck): Promise<IDeck> {
        this.LOADING(ServiceAction.CREATE);
        const response: AxiosResponse<IDeck> = await DeckService.create(deck);
        this.SET_DECK(response.data);
        this.UNSET_LOAD();
        return response.data;
    }
    @Action({rawError: true})
    async update(deck: IDeck): Promise<IDeck> {
        this.LOADING(ServiceAction.UPDATE);
        const response = await DeckService.update(deck);
        this.SET_DECK(response.data);
        this.UNSET_LOAD();
    }
    @Action({rawError: true})
    async delete(deck: IDeck) {
        this.LOADING(ServiceAction.DELETE);
        await DeckService.delete(deck);
        this.DELETE_DECK(deck);
        this.UNSET_LOAD();
    }
};


export const DeckModule = getModule(Deck);