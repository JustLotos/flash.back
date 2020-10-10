<template>
    <v-layout justify-center align-center>
        <v-card v-if="!isLoading" class="transparent">
            <v-row justify="center" >
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
        <loader v-else />
    </v-layout>

</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import {DeckModule} from "../DeckModule";
import ListObjects from "../../../App/Components/ListObjects";
import DeckListItem from "../Components/DeckListItem.vue";
import DeckCreate from "../Components/DeckCreate.vue";
import Modal from "../../../App/Components/Modal";
import CircleButton from "../../../App/Components/CircleButton";
import {AppModule} from "../../../App/AppModule";
import Loader from "../../../App/Components/FormElements/Loader.vue";

@Component({
    components: {Loader, ListObjects, DeckListItem, DeckCreate, Modal, CircleButton },
})
export default class DecksPage extends Vue{
    createModal: boolean = false;
    successModal: boolean = false;
    modalMessage: string = '';

    get isLoading(): boolean {
        return DeckModule.isActionFetchAllLoading;
    }
    get decks() { return DeckModule.getDecks }
    get decksId() { return DeckModule.getDecksId }
    get placement() { return { 'on-side': !!this.decksId.length, 'on-card': !(!!this.decksId.length) } }

    toggleModal() { this.createModal = !this.createModal }
    handleCreate(value) {
        this.modalMessage = value;
        this.successModal = !this.successModal;
    }

    beforeRouteEnter(to , from , next) {
        if(!DeckModule.isUploadedList) {
            DeckModule.fetchAll().then(next())
                .catch((error)=>{ console.log("Ошибка извлечения коллекции" + JSON.stringify(error))});
        } else {
            next()
        }
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