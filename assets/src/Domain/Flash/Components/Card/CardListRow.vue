<template>
    <v-hover open-delay="0.3s" v-slot:default="{ hover }">
        <v-btn block depressed x-large light class="mb-1 pa0"
           :elevation="hover ? 24 : 0"
           :class="{ 'on-hover': hover }"
           :to="{name: 'Card', params: {id: card.id}}"
        >{{getCard.name}}</v-btn>
    </v-hover>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import {ICard} from "../../types";
import {CardModule} from "../../Modules/CardModule";

@Component
export default class CardListRow extends Vue {
    @Prop() card: ICard;

    get getCard(): ICard {
        return this.card || CardModule.getCardDefault;
    }
}
</script>