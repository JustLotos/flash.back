<template>
    <v-container>
        <v-card>
            <v-row justify="center">
                <v-col cols="9">
                    <list-objects :items="decks" :items-id="decksId" :pagination="{perPage: 10, buttonsCount: 7}">
                        <template v-slot:item="{item}">
                            <deck-list-item :deck="item"></deck-list-item>
                        </template>
                        <template v-slot:empty>
                            <v-row justify="center">
                                <v-col cols="12" class="text-center">Колоды еще не добавлены</v-col>
                            </v-row>
                        </template>
                        <template v-slot:notFound>
                            <v-row justify="center">
                                <v-col cols="12" class="text-center">Колоды не найдены</v-col>
                            </v-row>
                        </template>
                    </list-objects>
                </v-col>
            </v-row>
            <v-card-text :class="createModalBtnPlacement">
                <v-fab-transition>
                    <v-tooltip top>
                        <template v-slot:activator="{ on }">
<!--                            @click="createModalToggle"-->
                            <v-btn v-on="on" color="primary" dark absolute top right fab>
                                <v-icon>mdi-plus</v-icon>
                            </v-btn>
                        </template>
                        <span>Добавить новую колоду</span>
                    </v-tooltip>
                </v-fab-transition>
            </v-card-text>
        </v-card>
<!--        <v-dialog v-model="createModal" max-width="700px">-->
<!--            <v-container>-->
<!--                <v-layout justify-center align-center class="position-relative">-->
<!--                    <deck-create @deck-created="handleSuccessCreate" />-->
<!--                    <v-btn absolute top right icon dark @click="createModalToggle">-->
<!--                        <v-icon>mdi-close</v-icon>-->
<!--                    </v-btn>-->
<!--                </v-layout>-->
<!--            </v-container>-->
<!--        </v-dialog>-->

<!--        <success-modal v-model="successModal">{{successMessage}}</success-modal>-->
    </v-container>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import {DeckModule} from "../../Modules/DeckModule";
import ListObjects from "../../../App/Components/ListObjects";
import DeckListItem from "../../Components/Deck/DeckListItem";
@Component({
    components: {
        ListObjects,
        DeckListItem
    }
})
export default class DecksPage extends Vue{
    get decks() {
        return DeckModule.getDecks;
    }
    get decksId() {
        return DeckModule.getDecksId;
    }
    beforeRouteEnter(to , from , next) {
        DeckModule.getAll()
            .then(()=>{next()})
            .catch((error)=>{ console.log("Ошибка извлечения колоды" + JSON.stringify(error))});
    }

    get createModalBtnPlacement() {
        let empty = !!this.decksId && !!this.decksId.length;
        return { 'on-side': empty, 'on-card': !empty }
    }
}



    // export default {
    //     name: 'DeckList',
    //     components: {SuccessModal, DeckCreate, BaseLayout, ListObjects, DeckListItem},
    //     data: function() {
    //         return {
    //             createModal: false,
    //             successModal: false,
    //             successMessage: '',
    //         }
    //     },
    //     computed: {
    //         ...mapGetters('DeckStore', [
    //             'decks',
    //             'decksId'
    //         ]),

    //     },
    //     methods: {
    //         createModalToggle: function() {
    //             this.createModal = !this.createModal;
    //         },
    //         handleSuccessCreate: function(value) {
    //             this.successMessage = value;
    //             this.successModal = !this.successModal;
    //         },
    //     },
    // }
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