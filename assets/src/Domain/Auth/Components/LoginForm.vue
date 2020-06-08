<template>
    <v-card class="elevation-10">
        <v-toolbar color="primary" dark flat>
            <v-toolbar-title>Авторизация</v-toolbar-title>
        </v-toolbar>
        <v-form ref="loginForm">
            <v-row justify="center">
                <v-col cols="12" sm="9" class="pa1 text-center">
                    <v-alert v-if="error" type="error" transition="fade-transition">Пользователь не найден</v-alert>
                    <v-sheet v-else>Введите данные для автоизации</v-sheet>
                </v-col>
                <v-col cols="12" sm="9" class="pa1">
                    <v-text-field
                        v-model="payloads.email"
                        :rules="rules.email"
                        validate-on-blur
                        label="E-mail адресс"
                        type="email"
                        prepend-icon="mdi-email"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="9" class="pa1">
                    <v-text-field
                        v-model="payloads.password"
                        :type="show ? 'text' : 'password'"
                        :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                        @click:append="show = !show"
                        :rules="rules.password"
                        label="Пароль"
                        validate-on-blur prepend-icon="mdi-lock"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="9" class="pa1">
                    <div class="d-flex justify-center">
                        <v-checkbox v-model="payloads.rememberMe" :label="`Запомнить меня`"></v-checkbox>
                    </div>
                </v-col>
            </v-row>
            <v-divider></v-divider>
            <v-card-actions class="justify-center">
                <v-btn class="pa2" color="primary" @click="submit" :loading="loading">Войти</v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import {AxiosError} from "axios";
import {LoginRequest} from "../types";
import {AuthModule} from "../AuthModule";
import {EmailRules, PasswordRules, PlainPasswordRules} from "../../../Utils/ValidationRules";

@Component
export default class LoginForm extends Vue {
    show: boolean = true;
    error: string | null = null;
    payloads: LoginRequest =  {
        email: 'ignashov-roman@mail.ru',
        password: '12345678',
        rememberMe: false
    };
    rules =  {
        password: PasswordRules,
        email: EmailRules
    }

    get loading() {
        return AuthModule.isLoading;
    }

    public submit() {
        if(this.$refs.loginForm.validate()) {
            AuthModule.login(this.payloads)
                .then(() => {this.$emit('login');})
                .catch((error: AxiosError)=>{
                    if(error.response?.data.errors && error.response?.data.errors.auth) {
                        this.error = error.response?.data.errors.auth;
                    }
                    console.log(error.response);
                });
        }
    }
}
</script>