<template>
    <v-text-field
        validate-on-blur
        v-model="value"
        label="Название"
        name="name"
        full-width
        type="text"
        :rules="rules"
        :error-messages="errorMessage"
        class="ma-0 pa-0"
    ></v-text-field>
</template>

<script>
    const EVENT_NAME = 'nameChange'.toLowerCase();
    export default {
        name: "AppFormName",
        props: [
            'name',
            'errorMessage'
        ],
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
                    v => !!v || 'Название обязательено для заполнения',
                ],
            }
        }
    }
</script>

<style scoped>

</style>