<template>
    <v-card>
        <v-row justify="center">
            <v-col cols="9">
                <list-objects :items="decks" :items-id="decksId">
                    <template v-slot:item="{item}">
                        <deck-list-item :deck="item"/>
                    </template>
                    <template v-slot:empty>
                        <v-row justify="center">
                            <v-col cols="12" class="text-center">Колоды еще не добавлены</v-col>
                        </v-row>
                    </template>
                </list-objects>
            </v-col>
        </v-row>

        <v-card-text :class="placement">
            <circle-button @click="toggleModal" tooltip="Создание коллекции карточек"/>
        </v-card-text>
        <modal v-model="createModal"><deck-create @created="handleCreate"/></modal>
        <modal v-model="successModal"><v-alert type="success">{{modalMessage}}</v-alert></modal>
    </v-card>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import {DeckModule} from "../../Modules/DeckModule";
import ListObjects from "../../../App/Components/ListObjects";
import DeckListItem from "../../Components/Deck/DeckListItem";
import DeckCreate from "../../Components/Deck/DeckCreate";
import Modal from "../../../App/Components/Modal";
import CircleButton from "../../../App/Components/CircleButton";
import {AppModule} from "../../../App/AppModule";

@Component({
    components: { ListObjects, DeckListItem, DeckCreate, Modal, CircleButton },
})
export default class DecksPage extends Vue{
    createModal: boolean = false;
    successModal: boolean = false;
    modalMessage: string = '';

    toggleModal() {
        this.createModal = !this.createModal;
    }

    handleCreate() {
        this.modalMessage = value;
        this.successModal = !this.successModal;
    }

    beforeRouteEnter(to , from , next) {
        if(!DeckModule.isUploaded) {
            DeckModule.getAll()
                .then(next())
                .catch((error)=>{ console.log("Ошибка извлечения колоды" + JSON.stringify(error))});
        } else {
            next()
        }
    }
    get decks() {
        return DeckModule.getDecks;
    }
    get decksId() {
        return DeckModule.getDecksId;
    }
    get placement() {
        return { 'on-side': !!this.decksId.length, 'on-card': !(!!this.decksId.length) }
    }
}
</script>
<style scoped>
    .on-side{
        position: fixed;
        right: 7%;
        bottom: 12%;
        z-index: 10;
        padding: 0;
    }
    .on-card{
        position: absolute;
        z-index: 10;
        top: 50%;
        left: -30%;
        padding: 0;
    }
    .position-relative{
        position: relative;
    }
</style>