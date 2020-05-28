<template>
    <v-text-field
            validate-on-blur
            v-model="value"
            :label="label"
            :name="name"
            type="number"
            :rules="rules"
            :error-messages="errorMessage"
    ></v-text-field>
</template>

<script>
    const EVENT_NAME = 'numberChange'.toLowerCase();
    export default {
        name: "AppFormNumber",
        props: [
            'number',
            'name',
            'label',
            'errorMessage'
        ],
        model: {
            prop: 'number',
            event: EVENT_NAME
        },
        computed: {
            value: {
                get: function() {
                    return this.number
                },
                set: function(value) {
                    this.$emit(EVENT_NAME, value)
                }
            }
        },
        data: function () {
            return {
                rules: [
                    v => !!v || this.label + ' обязательено для заполнения',
                    v => v > 0 || this.label + ' должно быть положительным',
                    v => v < 10000 || this.label + ' не должно превышать лимит 10000'
                ],
            }
        }
    }
</script>

<style scoped>

</style>