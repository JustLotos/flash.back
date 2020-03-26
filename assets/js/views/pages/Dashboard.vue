<template>
    <v-container>
        <v-layout row>
            <v-flex xs12>
                <h1 class="text-center">Это главная вкладка приложения</h1>
                <p class="text-center">и скоро тут появятся виджеты</p>
            </v-flex>
        </v-layout>
    </v-container>
</template>


<script>
    import DeckList from "../../components/Deck/DeckList";
    export default {
        name: "Dashboard",
        components: {DeckList},
        data: function () {
            return {};
        },
        methods: {
            async getDecks(){
                await this.$store.dispatch("DeckStore/findAll");
            }
        }
    }
</script>

<style scoped>

</style>