<template>
    <v-form ref="cardForm" class="ma-0">
        <v-row justify="center" class="ma-0 pa-0">
            <v-col cols="12" sm="10" class="ma-0 pa-0">
                <control-name v-model="card.name" :error-message="errors.name" class="width"></control-name>
            </v-col>
        </v-row>
        <v-flex>
            <v-row justify="center" class="ma-0 pa-0">
                <v-col cols="12" sm="11" class="ma-0 pa-0 mb-2">
                    <control-editor v-model="getCard.frontSide[0]"></control-editor>
                </v-col>
                <v-col cols="12" sm="11" class="ma-0 pa-0">
                    <control-editor v-model="getCard.backSide[0]"></control-editor>
                </v-col>
            </v-row>
        </v-flex>
        <v-row justify="center" class="ma-0 pa-0">
            <v-col sm="auto" class="ma-3 pa-0">
                <v-btn color="primary" @click="submit" :loading="loading"><slot name="submit"></slot></v-btn>
            </v-col>
        </v-row>
    </v-form>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import {ICard} from "../../types";
import {CardModule} from "../../Modules/CardModule";
import ControlName from "../../../App/Components/FormElements/ControlEmail";
import ControlEditor from "../../../App/Components/FormElements/ControlEditor";


@Component({components: {ControlName, ControlEditor}})
export default class CardForm extends Vue{
    @Prop() card: ICard;
    @Prop() errors: ICard;

    get getErrors(): ICard { return this.errors || CardModule.getCardDefault }
    get getCard(): ICard { return  this.card || CardModule.getCardDefault}
    get loading(): boolean { return CardModule.is}
    submit() {
        if (this.$refs.cardForm.validate()) {
            this.$emit('submit', this.card);
        }
    }
}
</script>