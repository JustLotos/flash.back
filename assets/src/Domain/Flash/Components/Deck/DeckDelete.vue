<template>
    <control-confirm
        :confirmation-message="confirmationMessage"
        :confirm-operation-phrase="'Удалить'"
        :confirm-deny-phrase="'Отменить'"
        :verify="getDeckName"
        @confirm="handleConfirm"
        @deny="handleDeny"
    ></control-confirm>
</template>

<script lang="ts">
import ControlConfirm from "../../../App/Components/ConfirmDialog.vue";
import {Component, Prop, Vue} from "vue-property-decorator";
import {IDeck} from "../../types";
import {DeckModule} from "../../Modules/DeckModule";

@Component({components: {ControlConfirm}})
export default class DeckDelete extends Vue {
    confirmationMessage: string = 'Для удаления, введите имя коллекции';

    @Prop({required: true}) deck: IDeck;

    get getDeckName(): string { return this.deck.name || ''}

    async handleConfirm() {
        this.$emit('deleted', 'Коллекция успешно удалена!');
        // await DeckModule.delete(this.deck)
        //     .then(()=>{ this.$emit('deleted', 'Коллекция успешно удалена!') })
        //     .catch((error)=>{console.log(error)});
    }
    handleDeny() { this.$emit('deny', 'Операция отменена') }
}
</script>