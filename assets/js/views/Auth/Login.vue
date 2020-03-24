<template>
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
            <v-flex xs11 sm7 md5>
                <v-card class="elevation-24">
                    <v-toolbar color="primary" class="text-center" dark flat>
                        <v-toolbar-title class="fill-width text-center">Авторизация</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-form ref="formLogin" v-model="valid">
                            <v-row justify="center">
                                <v-col cols="12" lg="10">
                                    <template v-if="hasError" class="row col">
                                        <v-alert type="error" class="text-center">
                                            {{ notFoundUser }}
                                        </v-alert>
                                    </template>
                                </v-col>
                                <v-col cols="12" lg="8">
                                    <v-text-field
                                        validate-on-blur
                                        id="email"
                                        v-model="email"
                                        label="E-mail адресс"
                                        name="email"
                                        type="email"
                                        prepend-icon="mdi-email"
                                        :rules="emailRules"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" lg="8">
                                    <v-text-field
                                            validate-on-blur
                                            id="password"
                                            label="Пароль"
                                            name="password"
                                            v-model="password"
                                            prepend-icon="mdi-lock"
                                            :rules="passwordRules"
                                            :type="showPassword ? 'text' : 'password'"
                                            :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                            @click:append="showPassword = !showPassword"
                                    ></v-text-field>
                                    <v-col justify="center">
                                        <v-row justify="center" class="flex-wrap">
                                            <v-checkbox
                                                    v-model="rememberMe"
                                                    :label="`Запомнить меня`">
                                            </v-checkbox>
                                        </v-row>
                                    </v-col>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-row justify="center" class="flex-wrap">
                            <v-card>
                                <v-btn color="primary" @click="performLogin()">Войти</v-btn>
                            </v-card>
                        </v-row>
                    </v-card-actions>
                    <v-card-actions>
                        <v-row justify="center" class="flex-wrap">
                            <v-card flat>
                                <span>Нет учетной записи?</span>
                                <v-btn text link :to="registerLink" color="primary">Создать аккаунт</v-btn>
                            </v-card>
                        </v-row>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        data: function () {
            return {

                registerLink: {name: 'Register'},
                showPassword: false,

                // Поля формы
                email: "ignashov-roman@mail.ru",
                rememberMe: false,
                password: "123456",

                // Валидация
                valid: false,
                emailRules: [
                    v => !!v || 'E-mail обязателен для заполнения',
                    v => /.+@.+\..+/.test(v) || 'E-mail должен быть валидным',
                ],
                passwordRules: [
                    v => !!v || 'Пароль обязателен для заполнения',
                   // v => (v && v.length >= 6) || 'Name must be less than 10 characters',
                ],

            }
        },
        computed: {
            notFoundUser: function() {
                if(this.errors.hasOwnProperty('entity')) {
                    return this.errors.entity
                }
                return '';
            },

            ...mapGetters('UserStore',{
                isLoading: 'isLoading',
                isAuthenticated: 'isAuthenticated',
                hasError: 'hasErrorLogin',
                errors: 'errorsLogin',
            }),
        },
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
        methods: {
            async performLogin() {
                let loginPayload = {
                    email: this.$data.email,
                    password: this.$data.password,
                    rememberMe: this.$data.rememberMe
                };

                let redirect = this.$route.query.redirect;

                await this.$store.dispatch("UserStore/login", loginPayload);

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