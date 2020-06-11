<template>
    <v-flex>
        <v-row justify="space-around">
            <v-col cols="12" md="10">
                <v-card :elevation="18">
                    <v-row justify="center">
                        <v-col cols="12" sm="10">
                            <v-toolbar dense short flat>
                                <v-btn @click="goBack" text><v-icon>mdi-menu-left</v-icon></v-btn>
                                <v-spacer/>
                                <v-toolbar-title>{{getCard.name}}</v-toolbar-title>
                                <v-spacer/>
                                <dial-button>
                                    <v-btn @click="toggleUpdateModal"><v-icon>mdi-pencil</v-icon></v-btn>
                                </dial-button>
                            </v-toolbar>
                            <v-divider></v-divider>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12" sm="10" class="p0 m0"><v-card-text>Ключ</v-card-text></v-col>
                                    <v-col cols="12" sm="10"><v-sheet v-html="getFrontSide"></v-sheet></v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12" sm="10" class="p0 m0"><v-card-text>Значение</v-card-text></v-col>
                                    <v-col cols="12" sm="10"><v-sheet v-html="getBackSide"></v-sheet></v-col>
                                </v-row>
                            </v-card-text>
                        </v-col>
                    </v-row>
                </v-card>
            </v-col>
        </v-row>

        <modal v-model="updateModal">
            <card-update :card="card" @updated="handleUpdate"></card-update>
        </modal>
    </v-flex>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import {CardModule} from "../../Modules/CardModule";
import {ICard} from "../../types";
import DialButton from "../../../App/Components/DialButton";
import Modal from "../../../App/Components/Modal.vue";
import CardUpdate from "../../Components/Card/CardUpdate.vue";

@Component({components: {CardUpdate, Modal, DialButton}})
export default class CardPage extends Vue{
    @Prop() id: number;
    card: ICard = CardModule.getCardDefault;
    updateModal: boolean = false;
    deleteModal: boolean = false;
    successModal: boolean = false;
    modalMessage: string = '';


    goBack() { this.$root.$router.go(-1) }
    setCard(card: ICard) { this.card = card };
    get getCard():ICard { return this.card; }

    get getFrontSide(): string {
        return CardModule.stringifySide(this.card.frontSide);
    }
    get getBackSide(): string {
        return CardModule.stringifySide(this.card.backSide);
    }

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

    beforeRouteEnter(to, from, next) {
        let card = CardModule.getCardById(to.params.id) || {};
        if(!card.details) {
            CardModule.getOneFull(to.params.id)
                .then(()=>{ next(vm=>vm.setCard(CardModule.getCardById(to.params.id))) })
                .catch((error)=>{ console.log('Ошибка получения карточки' + JSON.stringify(error.response)) });
        } else {
            next(vm=>vm.setCard(<ICard>card))
        }
    }
}
</script>