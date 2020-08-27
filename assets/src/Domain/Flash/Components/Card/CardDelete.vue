<template>
    <confirm-dialog
        :confirm-operation-phrase="'Удалить'"
        :confirm-deny-phrase="'Отменить'"
        @confirm="handleConfirm"
        @deny="handleDeny"
        confirmation-message="'Вы хотите удалить данну карточку?'"
    ></confirm-dialog>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import {ICard, IDeck} from "../../types";
import ConfirmDialog from "../../../App/Components/ConfirmDialog.vue";
import {CardModule} from "../../Modules/CardModule";
@Component({
    components: {ConfirmDialog}
})
export default class CardDelete extends Vue{
    @Prop() card: ICard;

    handleConfirm() {
        CardModule.delete(this.card)
            .then(()=>{ this.$emit('deleted', 'Карточка успешно удалена') })
            .catch((error)=>{console.log(error)})
    }
    handleDeny() {
        this.$emit('deny', 'Операция отменена')
    }
}
</script>
