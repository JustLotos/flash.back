<template>
    <v-text-field
            validate-on-blur
            id="email"
            v-model="value"
            label="E-mail адресс"
            name="email"
            type="email"
            prepend-icon="mdi-email"
            :rules="rules"
            :error-messages="errorMessage"
    ></v-text-field>
</template>

<script>
    const EVENT_NAME = 'emailChange'.toLowerCase();
    export default {
        name: "AppFormEmail",
        props: {
            email: {
                type: String,
                default: ''
            },
            errorMessage: {
                type: String,
                default: ''
            }
        },
        model: {
            prop: 'email',
            event: EVENT_NAME
        },
        computed: {
            value: {
                get: function() {
                    return this.email
                },
                set: function(value) {
                    this.$emit(EVENT_NAME, value)
                }
            }
        },
        data: function () {
            return {
                rules: [
                    v => !!v || 'E-mail обязателен для заполнения',
                    v => /.+@.+\..+/.test(v) || 'E-mail должен быть валидным',
                ],
            }
        }
    }
</script>

<style scoped>

</style>