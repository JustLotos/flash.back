<template>
    <v-row justify="space-around">
        <v-col cols="12" sm="10">
            <v-card v-if="!isLoading" :elevation="18" class="pa-12" >
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
                                        <v-hover open-delay="0.3s" v-slot:default="{hover}">
                                            <v-btn block depressed x-large color="primary" class="mb-2"
                                                :elevation="hover ? 24 : 0" :class="{'on-hover':hover}"
                                                @click="toggleCreateModal">Добавить карточки</v-btn>
                                        </v-hover>
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
            <loader v-else/>
        </v-col>


        <modal v-model="createModal">
            <card-create :deck-id="getDeck.id" @created="handleCreate"></card-create>
        </modal>
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
import {DeckModule} from "../DeckModule";
import DialButton from "../../../App/Components/DialButton.vue";
import Modal from "../../../App/Components/Modal.vue";
import DeckUpdate from "../Components/DeckUpdate.vue";
import DeckDelete from "../Components/DeckDelete.vue";
import ListObjects from "../../../App/Components/ListObjects";
import CardListItem from "../../Components/Card/CardListRow";
import {CardModule} from "../../Modules/CardModule";
import Loader from "../../../App/Components/FormElements/Loader.vue";
import CardCreate from "../../Components/Card/CardCreate.vue";
import {cloneObject} from "../../../../Utils/Helpers";
import {IDeck} from "../types";
import {AxiosError} from "axios";
import {handle404Exception} from "../../../User/Guard";

@Component({components: {CardCreate, Loader, DialButton, Modal, DeckUpdate, DeckDelete, ListObjects, CardListItem}})
export default class DeckPage extends Vue{
    @Prop() id: number;
    deck = {};

    createModal: boolean = false;
    deleteModal: boolean = false;
    updateModal: boolean = false;
    successModal: boolean = false;
    modalMessage: string = '';
    setDeck(deck) { this.deck = deck }
    get getDeck(): IDeck { return this.deck || cloneObject(DeckModule.getDeckDefault) }
    get getCards() { return CardModule.getCardsByCardsIds(this.getDeck.cards) }
    get getCardsId() { return this.deck.cards }
    get isLoading() { return DeckModule.isActionFetchOneLoading }


    toggleCreateModal() { this.createModal = !this.createModal }
    handleCreate(message: string) {
        this.toggleCreateModal();
        this.modalMessage = message;
        this.successModal = true;
    }
    toggleDeleteModal() { this.deleteModal = !this.deleteModal }
    handleDelete(message: string) {
        this.toggleDeleteModal();
        this.modalMessage = message;
        this.successModal = true;
    }
    toggleUpdateModal() { this.updateModal = !this.updateModal }
    handleUpdate(message: string) {
        this.modalMessage = message;
        this.successModal = true;
    }

    beforeRouteEnter(to, from, next) {
        let deck = DeckModule.getDeckById(to.params.id) || {};
        if(!deck.details) {
            DeckModule.fetchOneFull(to.params.id)
            .then(()=>{ next(vm=>vm.setDeck(DeckModule.getDeckById(to.params.id))) })
            .catch((error: AxiosError)=>{
                handle404Exception(error, {name: "Decks"});
                console.log('Ошибка получения коллекции' + JSON.stringify(error.response))
            });
        } else {
            next(vm=>vm.setDeck(deck))
        }
    }
}
</script>