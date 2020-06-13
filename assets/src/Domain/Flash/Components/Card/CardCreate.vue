<template>
    <v-card>
        <v-card-title class="justify-center">Добавление карточки</v-card-title>
        <card-form @submit="create" :errors="getErrors">
            <template v-slot:submit>Добавить</template>
        </card-form>
    </v-card>
</template>
<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import {ICard} from "../../types";
import {CardModule} from "../../Modules/CardModule";
import CardForm from "../Card/CardForm";

@Component({components: {CardForm}})
export default class CardCreate extends Vue{
    @Prop({required: true}) deckId: number;
    errors = {};

    get getErrors() { return this.errors }

    async create(card: ICard) {
        card.deck = this.deckId;
        await CardModule.create(card)
            .then(()=>{this.$emit('created', 'Карточка успешно создана!')})
            .catch((errors)=>{console.log(errors)});
    }
}
</script>