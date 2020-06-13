import Vue from "vue";
import {Action, getModule, Module, Mutation, VuexModule} from "vuex-module-decorators";
import Store from "../../../Store";
import {AxiosResponse} from "axios";
import {ICard, IDeck, IRecord} from "../types";
import CardService from "../Service/CardService";
import {DeckModule} from "./DeckModule";

export interface ICardState {
    byId: {},
    allIds: Array<number>,
    currentActionLoad: ServiceAction | null;
    uploadStatus: UploadStatus;
}
enum ServiceAction { FETCH_ALL = 1, FETCH_ONE, CREATE, UPDATE, DELETE  }
enum UploadStatus { EMPTY,LIST,DETAILS,FULL}
@Module({dynamic: true, store: Store, name: 'CardModule', namespaced: true})
export default class Card extends VuexModule implements ICardState {
    byId = {};
    allIds = [];
    currentActionLoad = null;
    uploadStatus =  UploadStatus.EMPTY;

    get isLoading():            boolean { return !!this.currentActionLoad }
    get isFetchAllLoading():    boolean { return this.currentActionLoad == ServiceActions.FETCH_ALL }
    get isFetchOneLoading():    boolean { return this.currentActionLoad == ServiceActions.FETCH_ONE }
    get isCreatLoading():       boolean { return this.currentActionLoad == ServiceActions.CREATE }
    get isUpdateLoading():      boolean { return this.currentActionLoad == ServiceActions.UPDATE }
    get isDeleteLoading():      boolean { return this.currentActionLoad == ServiceActions.DELETE }
    get getCurrentActionLoad(): ServiceAction { return this.currentActionLoad }

    get isUploaded(): boolean { return !!this.uploadStatus }
    get getCardId(): Array<number> { return this.allIds }
    get getCards() { return this.byId }
    get getCardById() {
        return (id: number): ICard => {
            return this.byId[id];
        };
    }
    get getCardsByCardsIds()  {
        return (cards: Array<number>) => {
            let temp = {};
            if(!cards) { return temp }
            cards.map((cardId: number) => {
                temp[cardId] = this.byId[cardId];
            });
            return temp;
        }
    }
    get getCardsByDeckId() {
        return (deckId: number) => {
            let temp = {};
            this.allIds.filter((cardId: number) => {
                return this.byId[cardId].deck == deckId
            }).map((cardId: number) => {
                temp[cardId] =  this.byId[cardId]
            });
            return temp;
        }
    }


    get getCardDefault(): ICard {
        return {
            id: -1,
            name: '',
            frontSide:  [{id: -1, content: ''}],
            backSide:   [{id: -1, content: ''}]}
    }
    get stringifySide() {
        return (records: Array<IRecord>): string =>  {
            let str = '';
            records.forEach((record: IRecord) => { str += record.content });
            return str;
        }
    }
    get parseSide() {
        return (id: number, string: string): IRecord =>  {
            return  {id: id, content: string}
        }
    }

    @Mutation
    FETCH_CARDS_FROM_DECK(deck: IDeck) {
        deck.cards.forEach((card: ICard) => {
            card.details = false;
            card.deck = deck.id;
            Vue.set(this.byId, card.id, card);
            if (this.allIds.indexOf(card.id) < 0 ) {
                this.allIds.push(card.id);
            }
        });
        this.uploadStatus = UploadStatus.LIST;
    }
    @Mutation
    FETCH_CARDS_FULL_FROM_DECK(deck: IDeck) {
        deck.cards.forEach((card: ICard) => {
            card.details = true;
            card.deck = deck.id;
            Vue.set(this.byId, card.id, card);
            if (this.allIds.indexOf(card.id) < 0 ) {
                this.allIds.push(card.id);
            }
        });
        this.uploadStatus = UploadStatus.FULL;
    }
    @Mutation
    SET_CARD(card: ICard) {
        card.details = true;
        if(this.byId[card.id]) {
            if(this.byId[card.id].deck) {
                card.deck = this.byId[card.id].deck;
            }
        }

        Vue.set(this.byId, card.id, card);
        if (this.allIds.indexOf(card.id) < 0) {
            this.allIds.push(card.id);
        }
        this.uploadStatus = UploadStatus.FULL;
    }
    @Mutation
    DELETE_CARD(card: ICard) {
        let deck = DeckModule.getDeckById(card.deck);
        Vue.delete(this.byId, card.id);
        this.allIds.splice(this.allIds.indexOf(card.id), 1);
    }

    @Action({rawError: true})
    async getOneFull(cardId: number) {
        const response = await CardService.getOne(cardId, 'FULL');
        this.SET_CARD(response.data);
    }
    @Action({rawError: true})
    async create(card: ICard) {
        const response =await CardService.create(card);
        this.SET_CARD(response.data);
        response.data.deck = card.deck;
        DeckModule.ADD_NEW_CARD_TO_DECK(response.data);
    }
    @Action({rawError: true})
    async update(card: ICard) {
        const response =await CardService.update(card);
        response.deck = card.deck;
        this.SET_CARD(response.data);
    }
    @Action({rawError: true})
    async delete(card: ICard): Promise<any> {
        const response: AxiosResponse = await CardService.delete(card);
        this.DELETE_CARD(card);
        DeckModule.REMOVE_CARD_FROM_DECK(card);
        return response.data;
    }
};


export const CardModule = getModule(Card);