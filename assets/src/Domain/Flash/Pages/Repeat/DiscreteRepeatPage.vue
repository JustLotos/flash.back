<template>
    <v-layout justify-center align-center>
        <v-flex>
            <v-card color="primary" class="pt-5 pr-5 pl-5">
                <v-row justify="center" no-gutters style="position: relative">
                    <v-sheet class="timer"> {{resultTime.toFixed(1)}} </v-sheet>
                    <v-col cols="12" sm="12" class="mb-5">
                        <v-sheet color="light" min-height="200px">
                            <v-card-text v-html="getFrontSide"></v-card-text>
                        </v-sheet>
                    </v-col>
                    <v-row justify="center" no-gutters>
                        <v-col cols="12" sm="auto">
                            <v-divider inset></v-divider>
                        </v-col>
                    </v-row>
                    <v-col cols="12" sm="12" class="mt-5">
                        <v-sheet color="light" min-height="200px">
                            <v-card-text v-if="isAnswer" v-html="getBackSide"></v-card-text>
                        </v-sheet>
                    </v-col>
                </v-row>
                <v-card-actions>
                    <v-row justify="space-around">
                        <v-btn v-if="isInit" @click="setAnswer" >Показать ответ</v-btn>
                        <discrete-repeat-answer-buttons v-if="isAnswer" :card="getActiveCard" @answered="setNext"/>
                        <v-btn v-if="isNext" @click="setInit">Следующая</v-btn>
                    </v-row>
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>
<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import {DeckModule} from "../../Modules/DeckModule";
import {CardModule} from "../../Modules/CardModule";
import {ICard, IDeck} from "../../types";
import DiscreteRepeatAnswerButtons from "../../Components/Repeat/DiscreteRepeatAnswerButtons.vue";

enum STATE { INIT = 'INIT', ANSWER = 'ANSWER' , NEXT = 'NEXT' }
@Component({
    components: {DiscreteRepeatAnswerButtons}
})
export default class DiscreteRepeatPage extends Vue{
    @Prop({required: true}) id: number;
    isRunning: boolean = false;
    interval = null;
    deck: IDeck;
    activeCard: ICard = CardModule.getCardDefault;
    state: STATE = STATE.INIT;
    resultTime: number = 0;
    repeatedCards;

    setInit() {
        this.state = STATE.INIT;
        this.interval = setInterval(
            () => { this.resultTime += + 0.1 },
            100
        )
    }

    setAnswer() {
        this.state = STATE.ANSWER;
        this.resultTime = 0;
        this.interval = clearInterval(this.interval);
    }

    setNext(value: string) {
        this.state = STATE.NEXT;
    }

    setDeck(deck: IDeck) {
        this.deck = deck;
        debugger;
        this.repeatedCards = CardModule.getReadyForRepeatCards(this.deck.id);
        //this.activeCard = CardModule.getCardById(deck.cards[0]);
        this.setInit();
    }

    get isInit()                    { return this.state === STATE.INIT }
    get isAnswer()                  { return this.state === STATE.ANSWER }
    get isNext()                    { return this.state === STATE.NEXT }
    get getActiveCard(): ICard      { return this.activeCard }
    set getActiveCard(card: ICard)  { this.activeCard = card }
    get getFrontSide(): string      { return this.activeCard.frontSide[0].content }
    get getBackSide(): string       { return this.activeCard.backSide[0].content }
    get getCards()                  { return CardModule.getCardsByDeckId(this.id) }
    get getCardsId()                { return CardModule.getCardId }
    get getDeck(): IDeck            { return this.deck }

    beforeRouteEnter(to, from, next) {
        let deck = DeckModule.getDeckById(to.params.id) || {};
        if(!deck.details) {
            DeckModule.fetchOneFull(to.params.id)
                .then(()=>{ next(vm=>vm.setDeck(DeckModule.getDeckById(to.params.id))) })
                .catch((error)=>{console.log('Ошибка получения коллекции' + JSON.stringify(error.response))});
        } else {
            next(vm=>vm.setDeck(deck))
        }
    }
}
</script>

<style scoped>
    .timer {
        position: absolute;
        top: 0;
        left: 100%;
        margin-top: 0.5%;
        margin-left: -7%;
    }
</style>