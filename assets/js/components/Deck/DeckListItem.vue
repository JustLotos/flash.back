<template>
    <v-card color="primary" class="white--text">
        <v-container fluid>
            <v-layout>
                <v-flex xs4 md3>
                    <v-img
                            class="white--text align-end"
                            height="175px"
                            src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                    >
                    </v-img>
                </v-flex>
                <v-flex xs8 md9>
                    <v-card-title>
                        <div>
                            <h3 class="card-header">{{ deck.name }}</h3>
                            <p class="card-subtitle">{{ deck.description }}</p>
                        </div>
                    </v-card-title>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn class="primary">Перейти <v-icon>{{ 'mdi-chevron-right' }}</v-icon></v-btn>
                    </v-card-actions>

                    <v-layout class="position-relative">
                        <v-btn
                                top
                                right
                                absolute
                                @click="editDeckModal = !editDeckModal"
                        >
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>
                    </v-layout>
                </v-flex>


                <v-dialog v-model="editDeckModal" max-width="750px">
                    <v-container>
                        <v-layout justify-center align-center class="position-relative">
<!--                            <deck-update/>-->
                            <v-btn absolute top right icon dark @click="dialog = false">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </v-layout>
                </v-dialog>
            </v-layout>
        </v-container>
    </v-card>
</template>

<script>
    import DeckUpdate from "./DeckUpdate";

    export default {
        name: 'DeckListItem',
        components: {
            DeckUpdate
        },
        props: {
            deck: {
                type: Object,
                required: true
            },

        },
        data: function () {
            return {
                editDeckModal: false
            };
        },
    }
</script>

<style scoped>

</style>