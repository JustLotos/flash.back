<template>
    <v-row justify="space-around">
        <v-col cols="12" sm="10">
            <v-card :elevation="18" class="pa-12">
                <v-row justify="center">
                    <v-col cols="12" sm="10">
                        <v-toolbar dense short flat>
                            <v-toolbar-title class="text-center">{{ getDeck.name }}</v-toolbar-title>
                            <v-spacer/>
                            <dial-button>
                                <v-btn @click="toggleDeleteModal" class="mb-2"><v-icon>mdi-delete</v-icon></v-btn>
                                <v-btn @click="toggleUpdateModal"><v-icon>mdi-pencil</v-icon></v-btn>
                            </dial-button>
                        </v-toolbar>
                        <v-card-subtitle class="text-center">{{getDeck.description}}</v-card-subtitle>
                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-flex>
                                <v-row>
                                    <v-col cols="12" sm10>
<!--                                        :to="{name: 'train', params: {id: deck.id}}"-->
                                        <v-hover open-delay="0.3s" v-slot:default="{hover}">
                                            <v-btn block depressed x-large color="primary" class="mb-2"
                                                :elevation="hover ? 24 : 0" :class="{'on-hover':hover}"
                                            >Учить</v-btn>
                                        </v-hover>
                                    </v-col>
                                    <v-col cols="12" sm10>
<!--                                        <v-hover open-delay="0.3s" v-slot:default="{hover}">-->
<!--                                            <v-btn block depressed x-large color="primary" class="mb-2"-->
<!--                                                :elevation="hover ? 24 : 0" :class="{'on-hover':hover}"-->
<!--                                                @click="createModalToggle">Добавить карточки</v-btn>-->
<!--                                        </v-hover>-->
                                    </v-col>
                                    <v-col cols="12" sm10>
                                        <v-expansion-panels flat hover class="mt-2">
                                            <v-expansion-panel>
                                                <v-expansion-panel-header expand-icon="mdi-menu-down" color="light">Карточки</v-expansion-panel-header>
                                                <v-expansion-panel-content eager>
                                                    <list-objects :items="getCards" :items-id="getCardsId">
                                                        <template v-slot:item="{item}">
                                                            <card-list-item :card="item"></card-list-item>
                                                        </template>
                                                    </list-objects>
                                                </v-expansion-panel-content>
                                            </v-expansion-panel>
                                        </v-expansion-panels>
                                    </v-col>
                                </v-row>
                            </v-flex>
                        </v-card-actions>
                    </v-col>
                </v-row>
            </v-card>
        </v-col>

        <modal v-model="updateModal">
            <deck-update :deck="deck" @updated="handleUpdate"></deck-update>
        </modal>
        <modal v-model="deleteModal">
            <deck-delete :deck="deck" @deny="toggleDeleteModal" @deleted="handleDelete"></deck-delete>
        </modal>
        <modal v-model="successModal"><v-alert type="success">{{modalMessage}}</v-alert></modal>
    </v-row>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import {DeckModule} from "../../Modules/DeckModule";
import DialButton from "../../../App/Components/DialButton.vue";
import Modal from "../../../App/Components/Modal.vue";
import DeckUpdate from "../../Components/Deck/DeckUpdate.vue";
import DeckDelete from "../../Components/Deck/DeckDelete.vue";
import ListObjects from "../../../App/Components/ListObjects";
import CardListItem from "../../Components/Card/CardListRow";
import {CardModule} from "../../Modules/CardModule";

@Component({components: {DialButton, Modal, DeckUpdate, DeckDelete, ListObjects, CardListItem}})
export default class DeckPage extends Vue{
    @Prop() id: number;
    deck = {};

    deleteModal: boolean = false;
    updateModal: boolean = false;
    successModal: boolean = false;
    modalMessage: string = '';
    setDeck(deck) { this.deck = deck }
    get getDeck() { return this.deck || {settings: {}} }
    get getCards() { return CardModule.getCardsByCardsIds(this.getDeck.cards) }
    get getCardsId() { return this.deck.cards }

    toggleDeleteModal() { this.deleteModal = !this.deleteModal }
    handleDelete(message: string) {
        this.toggleDeleteModal();
        this.modalMessage = message;
        this.successModal = false;
    }
    toggleUpdateModal() { this.updateModal = !this.updateModal }
    handleUpdate(message: string) {
        this.toggleUpdateModal();
        this.modalMessage = message;
        this.successModal = false;
    }


    beforeRouteEnter(from, to, next) {
        let deckId: number;
        if (to.name === 'Deck') { deckId = to.params.id; }
        else if (from.name == 'Deck') { deckId = from.params.id;}
        else {console.log('id не найден'); }

        let deck = DeckModule.getDeckById(deckId) || {};
        if(!deck.details) {
            DeckModule.getOneFull(deckId)
            .then(()=>{ next(vm=>vm.setDeck(DeckModule.getDeckById(deckId))) })
            .catch((error)=>{console.log('Ошибка получения коллекции' + JSON.stringify(error.response))});
        } else {
            next(vm=>vm.setDeck(deck))
        }
    }
}
</script>