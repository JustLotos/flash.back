<template>
    <v-layout justify-center align-center>
        <v-flex>
            <v-card color="primary" class="pt-5 pr-5 pl-5">
                <v-row justify="center" no-gutters style="position: relative">
                    <v-sheet v-if="resultTime" class="timer"> {{resultTime.toFixed(1)}} </v-sheet>
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
        <modal v-model="modal"><v-alert type="warning">{{modalMessage}}</v-alert></modal>
    </v-layout>
</template>
<script lang="ts">
import {Component, Prop, Vue, Watch} from "vue-property-decorator";
import {DeckModule} from "../../Modules/DeckModule";
import {CardModule} from "../../Modules/CardModule";
import {ICard, IDeck} from "../../types";
import Modal from "../../../App/Components/Modal.vue";
import DiscreteRepeatAnswerButtons from "../../Components/Repeat/DiscreteRepeatAnswerButtons.vue";
import {RepeatModule} from "../../Modules/RepeatModule";
import date from "../../../../Utils/date";

enum STATE { INIT = 'INIT', ANSWER = 'ANSWER' , NEXT = 'NEXT' }
@Component({ components: { DiscreteRepeatAnswerButtons, Modal }})
export default class DiscreteRepeatPage extends Vue{
    @Prop({required: true}) id: number;
    isRunning: boolean = false;
    interval = null;
    modal: boolean = false;
    modalMessage: string = '';
    state: STATE = STATE.INIT;

    deck: IDeck;
    activeCard: ICard = CardModule.getCardDefault;
    resultTime: number = 0;
    repeatedCardsIds: Array<number>;

    setInit() {
        this.state = STATE.INIT;
        if(this.checkRepeatedCards()) {
            this.activeCard = CardModule.getCardById(<number>this.repeatedCardsIds.pop());
            this.interval = setInterval(() => { this.resultTime += + 0.1 }, 100)
        }
    }

    setAnswer() {
        this.state = STATE.ANSWER;
        this.resultTime = 0;
        this.interval = clearInterval(this.interval);
    }

    setNext(value: string) {
        this.state = STATE.NEXT;
        RepeatModule.repeatDiscrete({
            cardId: this.activeCard.id,
            date: date('Y-m-d\\TH:i:sP', Date.now()/1000),
            status: value,
            time: this.resultTime
        });
    }

    setDeck(deck: IDeck) {
        this.deck = deck;
        this.repeatedCardsIds = CardModule.getReadyForRepeatCards(this.deck.id);
        if(this.checkRepeatedCards()) {
            this.setInit();
        }
    }

    checkRepeatedCards() {
        if(this.repeatedCardsIds && this.repeatedCardsIds.length) {
            return true;
        } else {
            this.callModal('В данной коллекции отсутствую карточки для повторения, ' +
                'пожайлуста выберите другую коллекцию или добавьте новые карточки');
        }
    }

    callModal(message: string) {
        this.modal = true;
        this.modalMessage = message;
    }

    @Watch('modal')
    redirect(modal: boolean) {
        if(!modal) {
            this.$root.$router.push({name: 'Prepare'});
        }
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