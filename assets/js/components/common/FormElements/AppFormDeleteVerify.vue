<template>
    <v-text-field
            class="centered-input"
            validate-on-blur
            id="name"
            v-model="value"
            label="Название"
            name="name"
            full-width
            type="text"
            :rules="rules"
            :error-messages="errorMessage"
    ></v-text-field>
</template>

<script>
    const EVENT_NAME = 'deleteVerify'.toLowerCase();
    export default {
        name: "AppFormDeleteVerify",
        props: {
            name: {
                type: String,
                default: ''
            },
            errorMessage: {
                type: String,
                default: ''
            }
        },
        model: {
            prop: 'name',
            event: EVENT_NAME
        },
        computed: {
            value: {
                get: function() {
                    return this.name
                },
                set: function(value) {
                    this.$emit(EVENT_NAME, value)
                }
            }
        },
        data: function () {
            return {
                rules: [
                    v => v.toLowerCase() === this.deck.name.toLowerCase().trim()
                        || 'Введенное имя не совпадает с именем колоды',
                ],
            }
        }
    }
</script>

<style scoped>

</style>