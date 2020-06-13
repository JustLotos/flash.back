<template>
    <v-item-group>
        <v-btn @click="handle('BAD')">Плохо</v-btn>
        <v-btn @click="handle('GOOD')">Хорошо</v-btn>
    </v-item-group>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import {ICard} from "../../types";

@Component
export default class  DiscreteRepeatAnswerButtons extends Vue{
    @Prop({required: true}) card: ICard;

    handle(value: string) {
        this.$emit('answered', value);
    }
}
</script>
