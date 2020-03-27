<template>
    <v-container>
        <v-layout justify-center align-center>
            <router-view></router-view>
        </v-layout>
    </v-container>
</template>

<script>
    import DeckList from "../../components/Deck/DeckList";
    import DeckAdd from "../../components/Deck/DeckAdd";
    export default {
        name: "Decks",
        components: {DeckList},
        data: function () {
            return {
                dialog: false
            }
        },
        methods: {

        }
    }
</script>

<style scoped>

</style>