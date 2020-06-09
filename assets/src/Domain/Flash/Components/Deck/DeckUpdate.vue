<template>
    <v-card>
        <v-card-title class="justify-center">Редактирование колоды</v-card-title>
        <deck-form :deck="deck" @submit="update" :errors="errors">
            <template v-slot:submit>Сохранить</template>
        </deck-form>
    </v-card>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import {IDeck} from "../../types";
import DeckForm from "./DeckForm";
import {DeckModule} from "../../Modules/DeckModule";

@Component({components: {DeckForm}})
export default class DeckCreate extends Vue {
    @Prop() deck: IDeck;
    errors = {};

    async update (deck: IDeck) {
        this.$emit('updated', 'Колода успешно сохранена!');
        // await this.$store.dispatch("DeckStore/update", deck).then(()=>{
        //
        // }).catch((errors)=>{console.log(errors);})
    }

    mounted() {
        if(!this.deck.details) {
            DeckModule.getOne(this.deck)
                .then(()=>{
                    this.deck = DeckModule.getDeckById(this.deck.id);
                })
                .catch((error)=>{
                    debugger;
                    console.log('Ошибка получения коллекции' + JSON.stringify(error));
                });
        }
    }
}
</script>

