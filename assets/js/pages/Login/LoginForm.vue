<template>
    <v-card class="elevation-10">
        <v-toolbar color="primary" dark flat>
            <v-toolbar-title class="fill-width text-center">Авторизация</v-toolbar-title>
        </v-toolbar>
        <v-form ref="loginForm">
            <v-card-text>
                <v-row justify="center">
                    <v-col cols="12" lg="8" class="pa0">
                        <v-alert v-if="authError" type="error" transition="fade-transition">{{authError}}</v-alert>
                    </v-col>
                    <v-col cols="12" lg="8" class="pa0">
                        <app-form-email v-model="email"></app-form-email>
                    </v-col>
                    <v-col cols="12" lg="8" class="pa0">
                        <app-form-password v-model="password"></app-form-password>
                    </v-col>
                    <v-col cols="12" lg="8">
                        <div class="d-flex justify-center">
                            <v-checkbox v-model="rememberMe" :label="`Запомнить меня`"></v-checkbox>
                        </div>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions class="justify-center">
                <v-btn class="pa2" color="primary" @click="performLogin()" :loading="isLoading">Войти</v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>

<script>
    import { mapGetters } from 'vuex';
    import AppFormEmail from "../../components/common/FormElements/AppFormEmail";
    import AppFormPassword from "../../components/common/FormElements/AppFormPassword";

    export default {
        name: "LoginForm",
        components: {AppFormPassword, AppFormEmail},
        data: function () {
            return {
                email: "ignashov-roman@mail.ru",
                password: "12345678",
                rememberMe: false,
            }
        },
        computed: {
            authError: function () {
                if(this.errors && this.errors.hasOwnProperty('message')) {
                    return  'Пароль или логин не верны';
                }
                return false;
            },
            ...mapGetters({
                errors: 'errorsLogin',
                isLoading: 'isLoading',
            })
        },
        methods: {
            async performLogin() {
                if (this.$refs.loginForm.validate()) {
                    await this.$store.dispatch("login", {
                        email: this.$data.email,
                        password: this.$data.password,
                        rememberMe: this.$data.rememberMe
                    }).then(() => {
                        let redirect = this.$route.query.redirect;
                        if (typeof redirect !== "undefined") {
                            this.$router.push({path: redirect});
                        } else {
                            this.$router.push({name: "Dashboard"});
                        }
                    }).catch((error) => {
                        console.log("Ошибка авторизации: " + JSON.parse(error));
                    });
                }
            }
        },
    }
</script>
<style scoped></style>