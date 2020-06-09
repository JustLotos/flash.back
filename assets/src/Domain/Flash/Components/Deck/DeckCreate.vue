<template>
    <v-card>
        <v-card-title class="justify-center">Добавление колоды</v-card-title>
        <deck-form @submit="create" :errors="errors">
            <template v-slot:submit>Добавить</template>
        </deck-form>
    </v-card>
</template>

<script lang="ts">
import {Component, Vue} from "vue-property-decorator";
import {IDeck} from "../../types";
import DeckForm from "./DeckForm";
import {DeckModule} from "../../Modules/DeckModule";

@Component({components: {DeckForm}})
export default class DeckCreate extends Vue {
    errors = {};
    async create(deck: IDeck) {
        this.$emit('created', 'Колода успешно создана!');
        // await DeckModule.create(deck)
        // .then(()=>{
        //     this.$emit('created', 'Колода успешно создаана!');
        // })
        // .catch((errors)=>{
        //     this.errors = errors;
        //     console.log("Ошибка создание колоды: " + JSON.stringify(errors));
        // })
    }

    get getErrors() {
        return this.errors;
    }
}
</script>