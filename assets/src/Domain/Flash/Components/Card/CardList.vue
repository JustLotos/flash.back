<template>
    <list-objects :items="cards" :items-id="cardsId" pagination="true">
        <template v-slot:item="{item}">
            <card-list-row v-if="item" :card="item"></card-list-row>
        </template>
    </list-objects>
</template>

<script>
    import CardListRow from "./CardListRow";
    import {mapGetters} from 'vuex';
    import ListArray from "../../common/ListArray";
    import ListObjects from "../../common/ListObjects";
    export default {
        components: {ListObjects, ListArray, CardListRow},
        props: {
            cardsId: {
                required: true
            }
        },
        computed: {
            cards: function () {
                if(this.cardsId) {
                    return this.$store.getters['CardStore/getCardsById'](this.cardsId);
                }
            }
        },
    }
</script>

<style scoped>

</style>