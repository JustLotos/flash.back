<template>
    <v-item-group>
        <v-btn
            v-if="isForgot"
            :color="getOptions.forgot.color"
            @click="handle(getOptions.forgot.name)"
        >{{getOptions.forgot.label}}</v-btn>
        <v-btn
            v-if="isRecognize"
            :color="getOptions.recognize.color"
            @click="handle(getOptions.recognize.name)"
        >{{getOptions.recognize.label}}</v-btn>
        <v-btn
            v-if="isRemember"
            :color="getOptions.remember.color"
            @click="handle(getOptions.remember.name)"
        >{{getOptions.remember.label}}</v-btn>
        <v-btn
            v-if="isKnow"
            :color="getOptions.know.color"
            @click="handle(getOptions.know.name)"
        > {{getOptions.know.label}}</v-btn>
    </v-item-group>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import {ICard, IDiscreteRepeatOptions} from "../../types";
import {CardModule} from "../../Modules/CardModule";

@Component
export default class  DiscreteRepeatAnswerButtons extends Vue{
    @Prop({required: true}) card: ICard;

    get isForgot(): boolean {
        return this.getCardRepeatCount >= CardModule.discreteRepeatOptions.forgot.repeatCount;
    }
    get isRecognize(): boolean {
        return this.getCardRepeatCount >= CardModule.discreteRepeatOptions.recognize.repeatCount;
    }
    get isRemember(): boolean {
        return this.getCardRepeatCount >= CardModule.discreteRepeatOptions.remember.repeatCount;
    }
    get isKnow(): boolean {
        return this.getCardRepeatCount >= CardModule.discreteRepeatOptions.know.repeatCount;
    }

    get getCardRepeatCount(): ICard {
        return this.card.repeat.count || 0;
    }

    get getOptions(): IDiscreteRepeatOptions {
        return CardModule.discreteRepeatOptions;
    }

    handle(value: string) {
        this.$emit('answered', value);
    }
}
</script>
