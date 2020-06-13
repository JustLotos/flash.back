<template>
    <v-card>
        <v-card-title class="justify-center">Редактирование карточки</v-card-title>
        <card-form :card="card" @submit="update" :errors="getErrors">
            <template v-slot:submit>Сохранить</template>
        </card-form>
    </v-card>
</template>

<script lang="ts">
    import {Component, Prop, Vue} from "vue-property-decorator";
    import {ICard} from "../../types";
    import CardForm from "./CardForm.vue";
    import {CardModule} from "../../Modules/CardModule";
    @Component({
        components: {CardForm}
    })
    export default class CardUpdate extends Vue {
        @Prop() card: ICard;
        errors: ICard = CardModule.getCardDefault;

        get getErrors(): ICard {return this.errors}
        async update(card: ICard) {
            CardModule.update(card)
                .then(()=>{  this.$emit('updated', 'Карточка успешно сохранена!') })
                .catch((error) => { console.log(error) })
        }

    }
</script>