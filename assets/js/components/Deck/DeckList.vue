<template>
    <v-container grid-list-md >
        <v-layout row wrap>
            <v-flex xs12 sm10 md8 offset-sm1 offset-md2>
                <v-container>
                    <v-layout>
                        <v-flex>
                            <v-text-field
                                label="Поиск"
                                v-model="searchTerm"
                            >
                            </v-text-field>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-flex>
            <template v-if="filteredDecks.length !== 0">
                <v-flex
                        xs12 sm10 md8 offset-sm1 offset-md2
                        v-for="deck in filteredDecks" :key="decks.id"
                >
                    <DeckListItem :deck="deck"/>
                </v-flex>
            </template>
            <template v-else>
                <v-flex xs12 sm10 md8 offset-sm1 offset-md2>
                    <v-card color="primary" class="white--text">
                        <v-container>
                            <v-layout>
                                <v-flex md8 offset-md2>
                                    <div>Колод нет</div>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card>
                </v-flex>
            </template>

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

            <v-dialog v-model="dialog" max-width="700px">
                <v-container>
                    <v-layout justify-center align-center class="position-relative">
                        <deck-add />
                        <v-btn absolute top right icon dark @click="dialog = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-layout>
                </v-container>

            </v-dialog>

        </v-layout>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex';
    import DeckListItem from "./DeckListItem";
    import DeckAdd from "./DeckAdd";

    export default {
        name: 'DeckList',
        components: {DeckAdd, DeckListItem},
        data: function() {
            return {
                searchTerm: null,
                dialog: false
            }
        },
        computed: {
            ...mapGetters('DeckStore', [
                'decks'
            ]),

            filteredDecks: function () {
                let deckList = this.decks;

                if(this.searchTerm) {
                    return deckList.filter((deck) => deck.name.toLowerCase().indexOf(this.searchTerm.toLowerCase()) >= 0);
                }
                return deckList;
            }
        },
        methods: {
            dialogToggle(value = false) {
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
    .position-relative{
        position: relative;
    }
</style>