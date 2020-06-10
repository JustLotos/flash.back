<template>
    <v-card color="primary" class="white--text pa-2">
        <v-row justify="center">
            <v-col cols="8">
                <v-hover open-delay="0.3s" v-slot:default="{hover}">
                    <v-toolbar color="primary" dense short :elevation="hover ? 12 : 0">
                        <v-toolbar-title>
                            <v-btn :color="hover ? 'primary' : 'light'">{{ deck.name }}</v-btn>
                        </v-toolbar-title>
                        <v-spacer></v-spacer>
                        <dial-button>
                            <v-btn @click="toggleDeleteModal" class="mb-2"><v-icon>mdi-delete</v-icon></v-btn>
                            <v-btn @click="toggleUpdateModal"><v-icon>mdi-pencil</v-icon></v-btn>
                        </dial-button>
                    </v-toolbar>
                </v-hover>
                <v-card-subtitle dark class="card-description white--text mb-2">{{ deck.description }}</v-card-subtitle>
                <v-card-actions>
                    <v-row justify="end" no-gutters>
                        <v-btn :to="{name: 'Deck', params: {id: deck.id}}">Перейти<v-icon>{{ 'mdi-chevron-right' }}</v-icon></v-btn>
                    </v-row>
                </v-card-actions>
            </v-col>
        </v-row>

        <modal v-model="deleteModal">
            <deck-delete :deck="deck" @deny="toggleDeleteModal" @deleted="handleDelete"></deck-delete>
        </modal>
        <modal v-model="updateModal">
            <deck-update :deck="deck" @updated="handleUpdate"></deck-update>
        </modal>
        <modal v-model="successModal"><v-alert type="success">{{modalMessage}}</v-alert></modal>
    </v-card>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import {IDeck} from "../../types";
import Modal from "../../../App/Components/Modal";
import ControlConfirm from "../../../App/Components/ConfirmDialog.vue";
import DialButton from "../../../App/Components/DialButton.vue";
import DeckDelete from "./DeckDelete.vue";
import DeckUpdate from "./DeckUpdate.vue";
import {DeckModule} from "../../Modules/DeckModule";
import {AppModule} from "../../../App/AppModule";

@Component({ components: {DeckDelete, DeckUpdate, Modal, ControlConfirm, DialButton} })
export default class DeckListItem extends Vue{
    deleteModal: boolean = false;
    updateModal: boolean = false;
    successModal: boolean = false;
    modalMessage: string = '';

    @Prop({required: true, default: {}}) deck: IDeck;
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
}
</script>

<style scoped>
    .position-top{
        position: absolute;
        bottom: 100%;
        left: 100%;
        margin-bottom: -100px;
        margin-left: -75px;
    }
    .card-description{
        height: 100px;
    }
</style>