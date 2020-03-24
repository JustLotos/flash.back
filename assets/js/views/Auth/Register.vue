<template>
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
            <v-flex xs11 sm7 md5>
                <v-card class="elevation-24">
                    <v-toolbar color="primary" dark flat >
                        <v-toolbar-title class="fill-width text-center">Регистрация</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-form ref="formRegister" v-model="valid">
                            <v-row justify="center">
                                <v-col cols="12" lg="8">
                                    <v-text-field
                                            validate-on-blur
                                            id="email"
                                            v-model="email.value"
                                            label="E-mail"
                                            name="email"
                                            type="email"
                                            prepend-icon="mdi-email"
                                            :rules="email.rules"
                                            :error-messages="emailServerMessage"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" lg="8">
                                    <v-text-field
                                            id="password"
                                            label="Пароль"
                                            name="password"
                                            prepend-icon="mdi-lock-open"
                                            type="password"
                                            v-model="password.value"
                                            :rules="password.rules"
                                            :error-messages="passwordServerMessage"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" lg="8">
                                    <v-text-field
                                            id="passwordConfirm"
                                            label="Повторите пароль"
                                            name="password"
                                            v-model="plainPassword.value"
                                            prepend-icon="mdi-lock"
                                            type="password"
                                            :rules="plainPassword.rules"
                                            :error-messages="plainPasswordServerMessage"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions class="text-center">
                        <v-row justify="center" class="flex-wrap mb-2">
                            <v-card>
                                <v-btn color="primary" @click="performRegister">Зарегестрироваться</v-btn>
                            </v-card>
                        </v-row>
                    </v-card-actions>
                    <v-card-actions>
                        <v-row justify="center" class="flex-wrap">
                            <v-card flat>
                                <span>Есть учетная запись?</span>
                                <v-btn text link :to="{name: 'Login'}" color="primary">Войти</v-btn>
                            </v-card>
                        </v-row>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        created() {
            let redirect = this.$route.query.redirect;

            if (this.isAuthenticated) {
                if (typeof redirect !== "undefined") {
                    this.$router.push({path: redirect});
                } else {
                    this.$router.push({name: "Dashboard"});
                }
            }
        },
        computed: {
            emailServerMessage: function() {
                return this.errors ? this.errors.email : '';
            },
            passwordServerMessage: function () {
                return this.errors ? this.errors.password:''
            },
            plainPasswordServerMessage: function () {
                return this.errors ? this.errors.plain_password:''
            },
            ...mapGetters('UserStore', {
                isLoading: 'isLoading',
                isAuthenticated: 'isAuthenticated',
                hasError: 'hasErrorRegister',
                errors: 'errorsRegister',
            }),
        },
        data: function () {
            return {
                email: {
                    value: "ignashov-roman@mail.ru",
                    rules: [
                        v => !!v || 'E-mail обязателен для заполнения',
                       // v => /.+@.+\..+/.test(v) || 'E-mail должен быть валидным',
                    ],
                },
                password: {
                    value: "12345678",
                    rules: [
                        v => !!v || 'Пароль обязателен для заполнения',
                       // v => (v && v.length >= 8) || 'Name must be less than 10 characters',
                    ]
                },
                plainPassword: {
                    value: "12345678",
                    rules: [
                        v => !!v || 'Подвтерждение пароля обязательно',
                       // v => v === this.password || 'Введенные пароли не совпадают',
                    ],
                    serverMessage:  this.errors ? this.errors.email:''
                },
                valid: false
            }
        },
        methods: {
            async performRegister() {
                let registerPayload = {
                    email: this.email.value,
                    password: this.password.value,
                    plain_password: this.plainPassword.value
                };
                let redirect = this.$route.query.redirect;
                await this.$store.dispatch("UserStore/register", registerPayload);

                if (!this.hasError) {
                    if (typeof redirect !== "undefined") {
                        await this.$router.push({path: redirect});
                    } else {
                        await this.$router.push({name: "Home"});
                    }
                }

            }
        }
    }
</script>

<style scoped>
    .fill-width{
        width: 100%;
    }
</style>