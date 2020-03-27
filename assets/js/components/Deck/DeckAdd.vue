<template>
    <deck-form
        :form="form"
        :deck="deck"
        @add="onDeckAdd"
    ></deck-form>
</template>

<script>
    import DeckForm from "./DeckForm";
    export default {
        name: "DeckAdd",
        components: {DeckForm},
        data: function () {
            return {
                form: {
                    title: 'Новая колода',
                    actionName: 'Добавить',
                    eventName: 'add'
                },
                deck: {
                    name: '',
                    description: ''
                }
            }
        },
        methods: {
            onDeckAdd: function (payload) {
                console.log(payload);
            }
        }
    }
</script>

<style scoped>
    .centered-input >>> input {
        text-align: center
    }
</style>