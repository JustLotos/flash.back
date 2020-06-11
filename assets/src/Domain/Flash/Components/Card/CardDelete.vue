<template>
    <control-confirm
        :confirm-operation-phrase="'Удалить'"
        :confirm-deny-phrase="'Отменить'"
        @confirm="handleConfirm"
        @deny="handleDeny"
    ></control-confirm>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import {IDeck} from "../../types";
import ControlConfirm from "../../../App/Components/FormElements/ControlConfirm.vue";
@Component({
    components: {ControlConfirm}
})
export default class CardDelete extends Vue{
    @Prop() card: IDeck;

    handleConfirm() {

    }
    handleDeny() {

    }
}
</script>
