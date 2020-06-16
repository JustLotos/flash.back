<template>
    <v-container v-if="!isLoading" class="fill-height d-block" fluid >
        <v-navigation-drawer app v-model="localSidebar" clipped fixed height="100%" :width="325">
            <v-row class="pa-0 ma-0">
                <v-col cols="12">
                    <v-tabs v-model="tab">
                        <v-tab href="#tab-1">Коллекции</v-tab>
                        <v-tab href="#tab-2">Теги</v-tab>
                    </v-tabs>
                    <v-tabs-items v-model="tab">
                        <v-tab-item :value="'tab-1'">
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
                        </v-tab-item>
                        <v-tab-item :value="'tab-2'"></v-tab-item>
                    </v-tabs-items>
                </v-col>
            </v-row>
        </v-navigation-drawer>
        <v-card class="fill-height transparent">
            <v-row justify="center">
                <v-col cols="11">
                    <v-toolbar height="70px">
                        <v-app-bar-nav-icon @click="toggleLocalSidebar()"/>
                        <v-spacer/>
                        <v-toolbar-title>
                            <v-select dense solo persistent-hint return-object single-line class="ma-0 ml-8 pa-0"
                              style="width: 500px"
                              item-text="name" item-value="id" label="Выберите коллекцию"
                              v-model="getActiveDeck"
                              :items="getSelectItems"
                              :error-messages="error"
                            ></v-select>
                        </v-toolbar-title>

                    </v-toolbar>
                </v-col>
            </v-row>
            <v-row justify="center" class="fill-height" >
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
    <loader v-else/>
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
import Loader from "../../../App/Components/FormElements/Loader.vue";
import {ISelectItem} from "../../../App/types";

@Component({components: {Loader, CardForm, CardCreate, CardUpdate, ListObjects, Modal}})
export default class ReviewPage extends Vue {
    tab: any = null;
    localSidebar: boolean = true;
    modal: boolean = false;
    modalMessage: string = '';
    activeCard: ICard = CardModule.getCardDefault;
    activeDeck: IDeck = DeckModule.getDeckDefault;
    saveAsNew: boolean = true;
    error: string = '';

    get isRealActiveCard() {
        return this.getActiveCard.id !== -1;
    }

    get isRealActiveDeck() {
        return this.getActiveDeck.id !== -1;
    }

    handleSubmitCardForm(card: ICard) {
        if (this.saveAsNew) {
            if(this.isRealActiveDeck) {
                card.deck = this.getActiveDeck.id;
                CardModule.create(card)
                    .then(()=>{
                        this.modalMessage = 'Карта успешно создана'!
                        this.modal = true;
                    })
                    .catch((error)=>{console.log(error)})
            } else {
                this.error = 'Для повторения необходимо выбрать колоду';
            }
        }else {
            CardModule.update(card)
                .then(()=>{
                    this.modalMessage = 'Карта успешно обновлена'!
                    this.modal = true;
                })
                .catch((error)=>{console.log(error)})
        }
    }

    get getDecks() { return DeckModule.getDecks }
    get getDecksId(): Array<number> { return DeckModule.getDecksId }
    get getSelectItems(): Array<ISelectItem> {
        return this.getDecksId.map((deckId: number)=>{
            return {id: deckId, name: this.getDecks[deckId].name}
        });
    }
    get isLoading() { return DeckModule.isActionFetchAllLoading }
    getCardsIdByDeckId(id: number) { return  CardModule.getCardsByDeckId(id) }
    resetActiveDeck(deck: IDeck = DeckModule.getDeckDefault) {
        this.activeDeck = deck;
        this.resetActiveCard();
    }
    get getActiveDeck(): IDeck {return this.activeDeck}
    set getActiveDeck(deck: IDeck) {this.activeDeck = deck}
    resetActiveCard(card: ICard = CardModule.getCardDefault) { this.activeCard = card; }
    get getActiveCard(): ICard { return this.activeCard }
    toggleLocalSidebar() { this.localSidebar = !this.localSidebar;}

    get getToolbarTitle(): string {
        if(this.getActiveCard.name !== '') {
            return `${this.getActiveCard.name} from`;
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