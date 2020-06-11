<template>
    <v-form ref="cardForm" style="max-width: 900px">
        <v-row justify="center" class="ma-0 pa-0">
            <v-col cols="12" sm="10" class="ma-0 pa-0">
                <control-name v-model="getCard.name" :error="getErrors.name"></control-name>
            </v-col>
        </v-row>
        <v-flex>
            <v-row justify="center" class="ma-0 pa-0">
                <v-col cols="12" sm="11" class="ma-0 pa-0 mb-2">
                    <control-editor v-model="getFrontSide"></control-editor>
                </v-col>
                <v-col cols="12" sm="11" class="ma-0 pa-0">
                    <control-editor v-model="getBackSide"></control-editor>
                </v-col>
            </v-row>
        </v-flex>
        <v-card-actions>
            <v-row justify="center" class="ma-0 pa-0 text-center">
                <slot name="controls"></slot>
                <v-btn color="primary" @click="submit" :loading="loading"><slot name="submit"></slot></v-btn>
            </v-row>
        </v-card-actions>
    </v-form>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import {ICard} from "../../types";
import {CardModule} from "../../Modules/CardModule";
import ControlName from "../../../App/Components/FormElements/ControlName";
import ControlEditor from "../../../App/Components/FormElements/ControlEditor";
import {cloneObject} from "../../../../Utils/Helpers";


@Component({components: {ControlName, ControlEditor}})
export default class CardForm extends Vue{
    @Prop({required: true}) card: ICard;
    @Prop() errors: ICard;

    get getFrontSide(): string {
        return this.getCard.frontSide[0].content;
    }
    set getFrontSide(value: string) {
        this.getCard.frontSide[0].content = value;
    }
    get getBackSide(): string {
        return this.getCard.backSide[0].content;
    }
    set getBackSide(value: string) {
        this.getCard.backSide[0].content = value;
    }

    get getErrors() { return this.errors || {} }
    get getCard(): ICard { return  this.card || CardModule.getCardDefault}
    get loading(): boolean { return CardModule.isLoading}

    submit() {
        if (this.$refs.cardForm.validate()) {
            this.$emit('submit', this.getCard);
        }
    }
}
</script>