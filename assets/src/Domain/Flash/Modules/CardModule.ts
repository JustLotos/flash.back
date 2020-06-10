import Vue from "vue";
import {Action, getModule, Module, Mutation, VuexModule} from "vuex-module-decorators";
import Store from "../../../Store";
import {AxiosResponse} from "axios";
import {ICard, IDeck} from "../types";
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

    get getCards() { return this.byId }
    get getCardId(): Array<number> { return this.allIds }
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
            cards.filter((card)=> card.deck == deckId)
                .map((cardId: number)=> { temp[cardId] =  this.byId[cardId]});
            debugger;
            return temp;
        }
    }


    get getCardDefault(): ICard {
        return { id: 0, name: '', frontSide: [''], backSide: [''] }
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
        this.load = false;
    }

    @Mutation
    FETCH_CARDS_FULL(deckId: number, cards: Array<ICard>) {
        cards.forEach((card: ICard) => {
            card.details = true;
            card.deck = deckId;
            Vue.set(this.byId, card.id, card);
            if (this.allIds.indexOf(card.id) < 0 ) {
                this.allIds.push(card.id);
            }
        });
        this.load = false;
    }

    @Mutation
    DELETE_CARD(card: ICard) {
        Vue.delete(this.byId, card.id);
        this.allIds.splice(this.allIds.indexOf(card.id), 1);
        this.load = false;
    }

    @Mutation
    SET_CARD(card: ICard) {
        Vue.set(this.byId, card.id, card);
        if (this.allIds.indexOf(card.id) < 0) {
            this.allIds.push(card.id);
        }
        this.load = false;
    }

    @Mutation
    SET_CARD_FULL(card: ICard) {
        Vue.set(this.byId, card.id, card);
        if (this.allIds.indexOf(card.id) < 0) {
            this.allIds.push(card.id);
        }
        this.load = false;
    }

    @Action({rawError: true})
    async getAll(deckId: number) {
        const response: AxiosResponse<Array<ICard>> = await CardService.getAll();
    }

    @Action({rawError: true})
    async getOneFull(deckId: number) {
        const response = await CardService.getOne(deckId);
        this.SET_CARD(response.data);
    }

    @Action({rawError: true})
    async create(deck: IDeck, card: ICard) {
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