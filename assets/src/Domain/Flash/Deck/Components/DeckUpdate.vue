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
import {IDeck} from "../types";
import DeckForm from "./DeckForm.vue";
import {DeckModule} from "../DeckModule";

@Component({components: {DeckForm}})
export default class DeckCreate extends Vue {
    @Prop() deck: IDeck;
    errors = {};

    async update (deck: IDeck) {
        DeckModule.update(deck).then(() => {
            this.$emit('updated', 'Колода успешно сохранена!');
        }).catch((error)=> {
            console.log(error);
        })

    }

    mounted() {
        if(!this.deck.details) {
            DeckModule.fetchOne(this.deck.id)
                .then(()=>{ this.deck = DeckModule.getDeckById(this.deck.id) })
                .catch((error)=>{
                    console.log('Ошибка получения коллекции' + JSON.stringify(error));
                });
        }
    }
}
</script>

