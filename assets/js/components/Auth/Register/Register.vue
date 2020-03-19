<template>
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
            <v-flex xs11 sm7 md5>
                <v-card class="elevation-24">
                    <v-toolbar color="primary" dark flat>
                        <v-toolbar-title>Регистрация</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-form ref="form" v-model="valid">
                            <v-text-field
                                id="email"
                                v-model="email"
                                label="E-mail"
                                name="email"
                                type="email"
                                prepend-icon="mdi-email"
                                :rules="emailRules"
                            ></v-text-field>

                            <v-text-field
                                id="password"
                                label="Пароль"
                                name="password"
                                prepend-icon="mdi-lock"
                                type="password"
                                v-model="password"
                                :rules="passwordRules"
                            ></v-text-field>

                            <v-text-field
                                    id="passwordConfirm"
                                    label="Повторите пароль"
                                    name="password"
                                    v-model="passwordConfirmation"
                                    prepend-icon="mdi-lock"
                                    type="password"
                                    :rules="passwordConfirmationRules"
                            ></v-text-field>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="text-center">
                        <v-btn color="primary">Зарегестрироваться</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        data: function () {
            return {
                email: "",
                emailRules: [
                    v => !!v || 'E-mail обязателен для заполнения',
                    v => /.+@.+\..+/.test(v) || 'E-mail должен быть валидным',
                ],
                password: "",
                passwordRules: [
                    v => !!v || 'Пароль обязателен для заполнения',
                    v => (v && v.length >= 6) || 'Name must be less than 10 characters',
                ],
                passwordConfirmation: "",
                passwordConfirmationRules: [
                    v => !!v || 'Подвтерждение пароля обязательно',
                    v => v === this.password || 'Введенные пароли не совпадают',
                ],
                valid: false
            }
        }
    }
</script>

<style scoped>

</style>