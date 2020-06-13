<template>
    <v-layout justify-center align-center>
        <v-card color="light">
            <v-form ref="form">
                <v-row justify="center" align="center" class="pa-2">
                    <v-col cols="12" sm="10" offset="2">
                        <v-toolbar dense elevation="0">
                            <v-toolbar-title>Настройка повторения</v-toolbar-title>
                        </v-toolbar>
                    </v-col>

                    <v-col cols="12" sm="auto" style="min-width: 560px">
                        <v-select persistent-hint return-object single-line
                            item-text="name" item-value="id" label="Выберите коллекцию"
                            v-model="selectActiveItem"
                            :items="getSelectItems"
                            :error-messages="error"
                        ></v-select>
                    </v-col>
                </v-row>

                <v-card-actions>
                    <v-row justify="center" align="center">
                        <v-btn @click="start">Учить</v-btn>
                    </v-row>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-layout>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import {DeckModule} from "../../Modules/DeckModule";
import {ISelectItem} from "../../../App/types";

@Component
export default class PreparePage extends Vue{
    selectActiveItem: ISelectItem = {name: null, id: null};
    error: string = '';
    get getSelectItems(): Array<ISelectItem> {
        return this.getDecksId.map((deckId: number)=>{
            return {id: deckId, name: this.getDecks[deckId].name}
        });
    }

    start() {
        console.log(this.selectActiveItem);
        if(this.selectActiveItem.id) {
            this.$root.$router.push({ name: 'RepeatDiscrete', params: { id: this.selectActiveItem.id}});
        } else {
            this.error = 'Для повторения необходимо выбрать колоду';
        }
    }

    get getDecks() {
        return DeckModule.getDecks;
    }
    get getDecksId() {
        return DeckModule.getDecksId;
    }

    get getValidationRules() {
        return [ v => !!v || '' ]
    }
    beforeRouteEnter(to, from, next) {
        if(!DeckModule.isUploadedList) {
            DeckModule.fetchAll().then(() => {next()})
                .catch((error)=>{ console.log("Ошибка извлечения колоды" + JSON.stringify(error))});
        } else {
            next()
        }
    }
}
</script>