<template>
    <div>
        <DeckList></DeckList>

        <v-card-text class="placement">

            <v-fab-transition >
                <v-tooltip top>
                    <template v-slot:activator="{ on }">
                        <v-btn  v-on="on"  @click="dialog = !dialog" color="primary" dark absolute top right fab>
                            <v-icon>mdi-plus</v-icon>
                        </v-btn>
                    </template>
                    <span>Добавить новую колоду</span>
                </v-tooltip>
            </v-fab-transition>
        </v-card-text>

        <v-dialog v-model="dialog" max-width="500px">
            <DeckAdd />
        </v-dialog>
    </div>
</template>

<script>
    import DeckList from "../../components/Deck/DeckList";
    import DeckAdd from "../../components/Deck/DeckAdd";
    export default {
        name: "Decks",
        components: {DeckAdd, DeckList},
        data: function () {
            return {
                dialog: false
            }
        },
        methods: {
            dialogToggle(value) {
                this.dialog = value;
            }
        }
    }
</script>

<style scoped>
    .placement{
        position: fixed;
        right: 7%;
        bottom: 7%;
    }
</style>