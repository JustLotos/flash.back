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
    @Prop() deckId: number;
    errors: ICard = CardModule.getCardDefault;

    get getErrors(): ICard { return this.errors }

    async create(card: ICard) {
        await CardModule.create(deckId, card)
            .then(()=>{
                this.$emit('created', 'Карточка успешно создана!');
            }).catch((errors)=>{
                console.log(errors);
            });
    }
}
</script>