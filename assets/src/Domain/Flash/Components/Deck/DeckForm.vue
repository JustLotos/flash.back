<template>
    <v-form ref="form">
        <v-row justify="center" no-gutters style="max-width: 700px; min-width: 560px;">
            <v-col cols="12" sm="8">
                <control-name v-model="getDeck.name" :error="getErrors.name"></control-name>
            </v-col>
            <v-flex v-if="details">
                <v-row justify="center">
                    <v-col cols="12" sm="8">
                        <control-text v-model="getDeck.description" :error="getErrors.description" label="Описание"></control-text>
                    </v-col>
                    <v-col cols="12" sm="8" class="text-center">
                            <v-btn elevation="0" @click="toggleSettings">Настройки</v-btn>
                    </v-col>
                    <v-flex v-if="settings">
                        <v-row justify="center">
                            <v-col cols="12" sm="8">
                                <control-slider
                                    v-model:slider="getDeck.settings.limitRepeat"
                                    hint="Количество карточек доступных для повторения в день">
                                    <template v-slot:label="{value}"><v-label>Повторение ({{value}})</v-label></template>
                                </control-slider>
                            </v-col>
                            <v-col cols="12" sm="8">
                                <control-slider
                                    v-model:slider="getDeck.settings.limitLearning"
                                    hint="Количество карточек доступных для повторения в день">
                                    <template v-slot:label="{value}"><v-label>Изучение ({{value}})</v-label></template>
                                </control-slider>
                            </v-col>
                            <v-col cols="12" sm="8">
                                <control-slider
                                    v-model:slider="getDeck.settings.difficultyIndex"
                                    hint="Этот коэффициент влияет вобщем на частоту повторения">
                                    <template v-slot:label="{value}"><v-label>Коэффициент сложности ({{value}}%)</v-label></template>
                                </control-slider>
                            </v-col>
                            <v-col cols="12" sm="8">
                                <control-slider
                                    v-model:slider="getDeck.settings.startTimeInterval"
                                    :ticks="getBaseTimeIntervalTicks"
                                    :max="getBaseTimeIntervalTicks.labels.length"
                                    hint="С данного времени начнется интервалы повторения">
                                    <template v-slot:label="{value}">
                                        <v-label>Начальное время ({{getBaseTimeIntervalTicks.labels[value-1]}})</v-label>
                                    </template>
                                </control-slider>
                            </v-col>
                            <v-col cols="12" sm="8">
                                <control-slider
                                    v-model:slider="getDeck.settings.minTimeInterval"
                                    :ticks="getMinTimeIntervalTicks"
                                    :max="getMinTimeIntervalTicks.labels.length"
                                    hint="Минимальный интервал повторения">
                                    <template v-slot:label="{value}">
                                        <v-label>Минимальное время ({{getMinTimeIntervalTicks.labels[value-1]}})</v-label>
                                    </template>
                                </control-slider>
                            </v-col>
                        </v-row>
                    </v-flex>
                </v-row>
            </v-flex>
        </v-row>
        <v-row justify="center">
            <v-col sm="auto">
                <v-btn elevation="0" @click="toggleDetails">{{detailsMessage}}</v-btn>
                <v-btn color="primary" @click="submit"><slot name="submit"></slot></v-btn>
            </v-col>
        </v-row>
    </v-form>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import {IDeck, ITimeIntervals} from "../../types";
import {DeckModule} from "../../Modules/DeckModule";
import ControlName from "../../../App/Components/FormElements/ControlName.vue";
import ControlText from "../../../App/Components/FormElements/ControlText.vue";
import ControlSlider from "../../../App/Components/FormElements/ControlSlider.vue";

@Component({
    components: {ControlSlider, ControlName, ControlText}
})
export default class DeckForm extends Vue {
    @Prop({required: false }) errors;
    @Prop({required: false }) deck;

    details: boolean = false;
    settings: boolean = false;
    detailsMessage: string = 'Подробнее';

    get getDeck(): IDeck { return this.deck }
    get getErrors() { return this.errors || { settings:{} } }
    get getTicks() {
        return function (arrIntervals: Array<ITimeIntervals>) {
            let ticks =  {name: 'always', labels: [], step: 1, size: 0};
            arrIntervals
                .sort((a: ITimeIntervals, b: ITimeIntervals) => a.value - b.value)
                .forEach((element: ITimeIntervals)=>{
                    ticks.labels.push(element.name)
                    ticks.size++;
                });
            return ticks;
        }


    }
    get getBaseTimeIntervalTicks() {
        return this.getTicks(DeckModule.baseTimeIntervals);
    }
    get getMinTimeIntervalTicks() {
        return this.getTicks(DeckModule.minTimeIntervals);
    }

    toggleSettings() { this.settings = !this.settings }
    toggleDetails() {
        this.details = !this.details;
        this.details ?
            this.detailsMessage = 'Скрыть':
            this.detailsMessage = 'Подробнее';
    }

    submit() {
        if (this.$refs.form.validate()) {

            if(!Number.isInteger(this.getDeck.settings.startTimeInterval))
                this.getDeck.settings.startTimeInterval =
                    <number>DeckModule.baseTimeIntervals[this.getDeck.settings.startTimeInterval].value;
            if(!Number.isInteger(this.getDeck.settings.startTimeInterval))
                this.getDeck.settings.minTimeInterval =
                    <number>DeckModule.baseTimeIntervals[this.getDeck.settings.minTimeInterval].value;

            this.$emit('submit', {
                id: this.getDeck.id,
                name: this.getDeck.name,
                description: this.getDeck.description,
                settings: {
                    limitRepeat: this.getDeck.settings.limitRepeat,
                    limitLearning: this.getDeck.settings.limitLearning,
                    difficultyIndex: this.getDeck.settings.difficultyIndex,
                    minTimeInterval: this.getDeck.settings.minTimeInterval,
                    startTimeInterval: this.getDeck.settings.startTimeInterval,
                }
            });

            if(!DeckModule.isRealDeck(this.getDeck)) {
                this.$refs.form.reset();
            }
        }
    }
}
</script>