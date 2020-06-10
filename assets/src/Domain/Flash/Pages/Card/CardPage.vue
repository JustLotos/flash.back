<template>
    <v-flex>
        <v-row justify="space-around">
            <v-col cols="12" md="10">
                <v-card :elevation="18">
                    <v-row justify="center">
                        <v-col cols="12" sm="10">
                            <v-toolbar dense short flat>
                                <v-toolbar-title>{{getCard.name}}</v-toolbar-title>
                                <v-spacer/>
                                <dial-button>
                                    <v-btn><v-icon>mdi-pencil</v-icon></v-btn>
                                </dial-button>
                            </v-toolbar>
                            <v-divider></v-divider>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12" sm="10"><v-card-text>Ключ</v-card-text></v-col>
                                    <v-col cols="12" sm="10">{{getFrontSide}}</v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12" sm="10"><v-card-text>Значение</v-card-text></v-col>
                                    <v-col cols="12" sm="10">{{getBackSide}}</v-col>
                                </v-row>
                            </v-card-text>
                        </v-col>
                    </v-row>
                </v-card>
            </v-col>
        </v-row>
    </v-flex>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import {CardModule} from "../../Modules/CardModule";
import DialButton from "../../../App/Components/DialButton.vue";
import {ICard} from "../../types";

@Component({components: {DialButton}})
export default class CardPage extends Vue{
    @Prop() id: number;

    card: ICard = CardModule.getCardDefault;

    setCard(card: ICard) { this.card = card };
    get getCard():ICard { return this.card; }

    get getFrontSide(): string {
        return CardModule.convertSide(this.card.frontSide);
    }
    get getBackSide(): string {
        return CardModule.convertSide(this.card.backSide);
    }


    beforeRouteEnter(from, to, next) {
        let cardId: number;
        if (to.name === 'Card') { cardId = to.params.id; }
        else if (from.name == 'Card') { cardId = from.params.id;}
        else {console.log('id не найден'); }

        let card = CardModule.getCardById(cardId) || {};
        if(!card.details) {
            CardModule.getOneFull(cardId)
                .then(()=>{ next(vm=>vm.setCard(CardModule.getCardById(cardId))) })
                .catch((error)=>{ console.log('Ошибка получения карточки' + JSON.stringify(error.response)) });
        } else {
            next(vm=>vm.setCard(card))
        }
    }
}
</script>