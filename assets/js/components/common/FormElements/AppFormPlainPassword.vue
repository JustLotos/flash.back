<template>
    <v-text-field
            validate-on-blur
            id="plainPassword"
            label="Подтерждение пароля"
            name="plainPassword"
            v-model="value"
            prepend-icon="mdi-lock"
            :rules="rules"
            :type="show ? 'text' : 'password'"
            :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
            :error-messages="errorMessage"
            @click:append="show = !show"
    ></v-text-field>
</template>

<script>
    const EVENT_NAME = 'plainPasswordChange'.toLowerCase();
    export default {
        name: "AppFormPlainPassword",
        props: [
            'plainPassword',
            'password',
            'errorMessage'
        ],
        model: {
            prop: 'passwordConfirm',
            event: EVENT_NAME
        },
        computed: {
            value: {
                get: function() {
                    return this.passwordConfirm
                },
                set: function(value) {
                    this.$emit(EVENT_NAME, value)
                }
            }
        },
        data: function () {
            return {
                show: false,
                rules: [
                    v => !!v || 'Это поле обязательно для заполнения',
                    v => v === this.password || 'Пароли не совпадают',
                ],
            }
        },
        watch: {
            value: function (value) {
                console.log(this.password);
            }
        }
    }
</script>

<style scoped>

</style>