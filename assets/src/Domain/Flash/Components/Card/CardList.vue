<template>
    <list-objects :items="getCards" :items-id="getCardsId">
        <template v-slot:item="{item}">
            <card-list-row v-if="item" :card="item"></card-list-row>
        </template>
    </list-objects>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import CardModule from "../../Modules/CardModule";
@Component({components: {ListObjects, CardListRow}})
export default class CardList extends Vue{
    @Prop() cardsId: Array<number>;

    get getCardsId(): Array<number> {
        return this.cardsId || [];
    }

    get getCards() {
        return {};
    }
}
</script>