<template>
    <deck-form
        :form="form"
        :deck="deck"
        @update="onDeckUpdate"
    ></deck-form>
</template>

<script>
    import DeckForm from "./DeckForm";
    import {mapGetters} from 'vuex';

    export default {
        name: "DeckAdd",
        components: {DeckForm},
        // props: [
        //     'id'
        // ],
        computed: {
            ...mapGetters('DeckStore', [
                'decks'
            ]),
            deck: function () {
                // if(this.id) {
                //     return this.decks.find((deck) => {
                //         return this.id === deck.id
                //     });
                // }

                return this.decks.find((deck) => {
                    return this.$route.params.id === deck.id
                });
            }
        },
        data: function () {
            return {
                form: {
                    title: 'Изменить колоду',
                    actionName: 'Изменить',
                    eventName: 'update'
                },
            }
        },
        methods: {
            onDeckUpdate: function (payload) {
            }
        },
    }
</script>

<style scoped>
    .centered-input >>> input {
        text-align: center
    }
</style>