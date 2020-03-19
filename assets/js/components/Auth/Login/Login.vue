<template>
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
            <v-flex xs11 sm7 md5>
                <v-card class="elevation-24">
                    <v-toolbar color="primary" class="text-center" dark flat>
                        <v-toolbar-title >Авторизация</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-form ref="formLogin" v-model="valid">
                            <div v-if="hasError" class="row col">
                                <div class="alert alert-danger" role="alert">
                                    {{ errors }}
                                </div>
                            </div>
                            <v-text-field
                                id="email"
                                v-model="email"
                                label="Введите E-mail"
                                name="email"
                                type="email"
                                prepend-icon="mdi-email"
                                :rules="emailRules"
                            ></v-text-field>

                            <v-text-field
                                id="password"
                                label="И пароль"
                                name="password"
                                v-model="password"
                                prepend-icon="mdi-lock"
                                :rules="passwordRules"
                                :type="showPassword ? 'text' : 'password'"
                                :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                @click:append="showPassword = !showPassword"
                            ></v-text-field>

                            <v-checkbox
                                    v-model="rememberMe"
                                    :label="`Запомнить меня`">
                            </v-checkbox>

                        </v-form>
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-flex>
                            <v-col>
                                <v-btn color="primary" @click="performLogin()">Войти</v-btn>
                            </v-col>
                            <v-col>
                                <v-btn :to="registerLink">Создать аккаунт</v-btn>
                            </v-col>
                        </v-flex>
                    </v-card-actions>

                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        props: {
            source: String,
        },
        data: function () {
            return {
                registerLink: '/register',
                showPassword: true,
                password: "1234567",
                passwordRules: [
                    v => !!v || 'Пароль обязателен для заполнения',
                    v => (v && v.length >= 6) || 'Name must be less than 10 characters',
                ],
                email: "ignashov-roman@mail.ru",
                emailRules: [
                    v => !!v || 'E-mail обязателен для заполнения',
                    v => /.+@.+\..+/.test(v) || 'E-mail должен быть валидным',
                ],
                rememberMe: false,
                valid: false
            }
        },
        computed: {
            isLoading() {
                return this.$store.getters["user/isLoading"];
            },
            hasError() {
                return this.$store.getters["user/hasError"];
            },
            errors() {
                return this.$store.getters["user/error"].message;
            }
        },
        created() {
            let redirect = this.$route.query.redirect;

            if (this.$store.getters["user/isAuthenticated"]) {
                if (typeof redirect !== "undefined") {
                    this.$router.push({path: redirect});
                } else {
                    this.$router.push({path: "/home"});
                }
            }
        },
        methods: {
            submitLoginForm: function () {
                if(this.$refs.formLogin.validate()) {
                    const data = this.performLogin().then(function (data) {

                    });
                }
            },
            async performLogin() {

                let loginPayload = {
                    email: this.$data.email,
                    password: this.$data.password,
                    rememberMe: this.$data.rememberMe
                };

                let redirect = this.$route.query.redirect;

                await this.$store.dispatch("user/login", loginPayload);

                console.log(this.$store.getters["user/error"]);

                if (!this.$store.getters["user/hasError"]) {
                    if (typeof redirect !== "undefined") {
                        await this.$router.push({path: redirect});
                    } else {
                        await this.$router.push({path: "/home"});
                    }
                }
            }

        }
    }
</script>

<style scoped>

</style>