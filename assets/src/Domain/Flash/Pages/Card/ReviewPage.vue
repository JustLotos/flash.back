<template>
    <v-container class="fill-height d-block" fluid>
        <v-navigation-drawer app v-model="localSidebar" clipped fixed height="100%" :width="325">
            <v-row class="pa-0 ma-0">
                <v-col cols="12">
                    <v-expansion-panels flat inset class="mr-5">
                        <list-objects :items="getDecks" :items-id="getDecksId">
                            <template v-slot:item="deck">
                                <v-expansion-panel>
                                    <v-expansion-panel-header ripple
                                      @click="resetActiveDeck(deck.item)"
                                    >{{deck.item.name}}</v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <list-objects :items="getCardsIdByDeckId(deck.item.id)" :items-id="deck.item.cards">
                                            <template v-slot:item="card">
                                                <v-btn block elevation="0" color="light" depressed class="mb-1 mt-1"
                                                       @click="resetActiveCard(card.item)"
                                                >{{card.item.name}}</v-btn>
                                            </template>
                                        </list-objects>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </template>
                        </list-objects>
                    </v-expansion-panels>
                </v-col>
            </v-row>
        </v-navigation-drawer>
        <v-card class="fill-height">
            <v-row justify="center">
                <v-col cols="11">
                    <v-toolbar class="m-2">
                        <v-app-bar-nav-icon @click="toggleLocalSidebar()"/>
                        <v-spacer/>
                        <v-toolbar-title>{{getToolbarTitle}}</v-toolbar-title>
                    </v-toolbar>
                </v-col>
            </v-row>
            <v-row justify="center" class="fill-height">
                <v-col cols="12" lg="9" class="justify-center align-center">
                    <card-form :card="getActiveCard" @submit="handleSubmitCardForm">
                        <template v-slot:submit>Сохранить</template>
                        <template v-slot:controls>
                            <v-checkbox label="Сохранить как новую" class="ma-0 mr-5 mt-1 pa-0"
                                v-model="saveAsNew" v-if="isRealActiveCard"/>
                        </template>
                    </card-form>
                </v-col>
            </v-row>
        </v-card>

        <modal v-model="modal" ><v-alert type="success">{{modalMessage}}</v-alert></modal>
    </v-container>
</template>

<script lang="ts">
import {Component, Vue} from "vue-property-decorator";
import Modal from "../../../App/Components/Modal";
import ListObjects from "../../../App/Components/ListObjects.vue";
import CardUpdate from "../../Components/Card/CardUpdate.vue";
import CardCreate from "../../Components/Card/CardCreate.vue";
import {DeckModule} from "../../Modules/DeckModule";
import {ICard, IDeck} from "../../types";
import {CardModule} from "../../Modules/CardModule";
import CardForm from "../../Components/Card/CardForm.vue";

@Component({components: {CardForm, CardCreate, CardUpdate, ListObjects, Modal}})
export default class ReviewPage extends Vue {
    localSidebar: boolean = true;
    modal: boolean = false;
    modalMessage: string = '';
    activeCard: ICard = CardModule.getCardDefault;
    activeDeck: IDeck = DeckModule.getDeckDefault;
    saveAsNew: boolean = false;

    get isRealActiveCard() {
        return this.getActiveCard.id !== -1;
    }

    handleSubmitCardForm(card: ICard) {
        if(this.saveAsNew) {
            console.log('create');
        }else {
            console.log('update');
        }
    }

    get getDecks() {
        return DeckModule.getDecks;
    }
    get getDecksId(): Array<number> {
        return DeckModule.getDecksId;
    }

    getCardsIdByDeckId(id: number) {
        return  CardModule.getCardsByDeckId(id);
    }
    resetActiveDeck(deck: IDeck = DeckModule.getDeckDefault) {
        this.activeDeck = deck;
        this.resetActiveCard();
    }
    get getActiveDeck(): IDeck {
        return this.activeDeck;
    }
    resetActiveCard(card: ICard = CardModule.getCardDefault) {
        this.activeCard = card;
    }
    get getActiveCard(): ICard {
        return this.activeCard;
    }
    toggleLocalSidebar() {
        this.localSidebar = !this.localSidebar;
    }

    get getToolbarTitle(): string {
        if(this.getActiveDeck.name !== '' && this.getActiveCard.name !== '') {
            return `${this.getActiveCard.name} from ${this.getActiveDeck.name}`;
        }
        else if(this.getActiveDeck.name !== '') {
            return `${this.getActiveDeck.name}`;
        }
        else if(this.getActiveCard.name !== '') {
            return `${this.getActiveCard.name}`;
        }
        return '';
    }
    beforeRouteEnter(to , from , next) {
        if(!DeckModule.isUploadedFull) {
            DeckModule.fetchAllFull()
                .then(()=>{next()})
                .catch((e)=>{console.log(e)})
        } else {
            next();
        }
    }
}
</script>