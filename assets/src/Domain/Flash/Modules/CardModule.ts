import Vue from "vue";
import {Action, getModule, Module, Mutation, VuexModule} from "vuex-module-decorators";
import Store from "../../../Store";
import {AxiosResponse} from "axios";
import {ICard, IDeck, IRecord} from "../types";
import CardService from "../Service/CardService";

export interface ICardState {
    current: ICard;
    byId: {},
    allIds: Array<number>,
    load: boolean;
}

@Module({dynamic: true, store: Store, name: 'CardModule', namespaced: true})
export default class Card extends VuexModule implements ICardState{
    current;
    byId = {};
    allIds = [];
    load = false;

    get isUploaded(): boolean {
        return true;
    }
    get isLoading(): boolean {
        return this.load
    }
    get getCards() {
        return this.byId
    }
    get getCardById() {
        return (id: number): ICard => {
            return this.byId[id];
        };
    }
    get getCardsByCardsIds()  {
        return (cards: Array<number>) => {
            let temp = {};
            if(!cards) {
                return temp;
            }
            cards.map((cardId: number)=> {
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
    get getCardId(): Array<number> {
        return this.allIds
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
    }

    @Mutation
    SET_CARD(card: ICard) {
        Vue.set(this.byId, card.id, card);
        if (this.allIds.indexOf(card.id) < 0) {
            this.allIds.push(card.id);
        }
    }

    @Mutation
    SET_CARD_FULL(card: ICard) {
        card.details = true;
        Vue.set(this.byId, card.id, card);
        if (this.allIds.indexOf(card.id) < 0) {
            this.allIds.push(card.id);
        }
    }

    @Mutation
    DELETE_CARD(card: ICard) {
        Vue.delete(this.byId, card.id);
        this.allIds.splice(this.allIds.indexOf(card.id), 1);
    }

    @Action({rawError: true})
    async getOneFull(deckId: number) {
        const response = await CardService.getOneFull(deckId);
        this.SET_CARD_FULL(response.data);
    }

    @Action({rawError: true})
    async create(deck: number, card: ICard) {
        const response =await CardService.create(deck, card);
        this.SET_CARD(response.data);
    }

    @Action({rawError: true})
    async update(card: ICard) {
        const response =await CardService.update(card);
        this.SET_CARD(response.data);
    }

    @Action({rawError: true})
    async delete(card: ICard) {
        const response: AxiosResponse = await CardService.delete(card);
        this.DELETE_CARD(card);
        return Promise.resolve(response.data);
    }
};


export const CardModule = getModule(Card);