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
        </v-layout>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex';
    import DeckListItem from "./DeckListItem";

    export default {
        name: 'DeckList',
        components: {DeckListItem},
        data: function() {
            return {
                searchTerm: null
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
        created() {
//          this.methods.getDecks();
        },
        methods: {
            // async getDecks(){
            //     await this.$store.dispatch("DeckStore/findAll");
            // }
        }
    }
</script>

<style scoped>

</style>