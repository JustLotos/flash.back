<template>
    <v-container grid-list-md>
        <v-layout row wrap>
            <v-flex xs12 sm10 offset-sm1>

            </v-flex>
            <v-flex xs12 sm10 offset-sm1>

            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        name: "Deck",
        props: {
            id: {
                type: String,
                required: true
            }
        },
        computed: {
            ...mapGetters('DeckStore', [
                'deck'
            ])
        }
    }
</script>

<style scoped>

</style>