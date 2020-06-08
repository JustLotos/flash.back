<template>
    <v-card class="elevation-10">
        <v-toolbar color="primary" dark flat>
            <v-toolbar-title>Восстановление доступа</v-toolbar-title>
        </v-toolbar>
        <v-form ref="registerForm">
            <v-row justify="center">
                <v-col cols="12" sm="9" class="text-center">
                    <v-sheet>Введите данные</v-sheet>
                </v-col>
                <v-col cols="12" sm="9" class="pa1">
                    <v-text-field
                        v-model="payloads.email"
                        :error-messages="errorPayloads.email"
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
                        :error-messages="errorPayloads.password"
                        @click:append="show = !show"
                        :rules="rules.password"
                        label="Новый пароль" validate-on-blur prepend-icon="mdi-lock"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="9" class="pa1">
                    <v-text-field v-model="payloads.plainPassword"
                        :type="plainShow ? 'text' : 'password'"
                        :append-icon="plainShow ? 'mdi-eye' : 'mdi-eye-off'"
                        :error-messages="errorPayloads.plainPassword"
                        :rules="rules.plainPassword"
                        @click:append="plainShow = !plainShow"
                        validate-on-blur label="Подтерждение пароля" prepend-icon="mdi-lock"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-divider></v-divider>
            <v-card-actions class="justify-center">
                <v-btn class="pa2 text-center primary" @click="resetPassword" :loading="loading">Подтвердить</v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>

<script lang="ts">
import {Component, Vue} from "vue-property-decorator";
import {RegisterRequest} from "../types";
import {AuthModule} from "../AuthModule";
import {PasswordRules, PlainPasswordRules, EmailRules} from "../../../Utils/ValidationRules";

@Component
export default class RegisterForm extends Vue  {
    payloads: RegisterRequest = {email: 'ignashov-roman@mail.ru', password: '12341234', plainPassword: '12341234'};
    errorPayloads: RegisterRequest = {email: '', password: '', plainPassword: ''};
    show: boolean = false;
    plainShow: boolean = false;

    rules =  {
        password: PasswordRules,
        plainPassword: PlainPasswordRules,
        email: EmailRules
    }

    get loading() {
        return AuthModule.isLoading;
    }

    resetPassword() {
        if(this.$refs.registerForm.validate()) {
            AuthModule.resetPassword(this.payloads)
                .then(() => { this.$emit('reset', 'Письмо уже отправелно!, поверьте ваш email') })
                .catch((error: AxiosError) => {
                    if(error.response?.data.errors)
                        this.errorPayloads = error.response?.data.errors
                    else {
                        this.$emit('reset-error', 'Письмо уже отправелно!, поверьте ваш email');
                    }
                    console.log(error.response);
                });
        }
    }

}
</script>