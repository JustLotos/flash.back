<template>
    <v-card class="elevation-10">
        <v-form ref="loginForm">
            <v-row justify="center">
                <v-col cols="12" sm="9" class="pa1 text-center">
                    <v-alert v-if="getError" type="error" transition="fade-transition">Пользователь не найден</v-alert>
                    <v-sheet v-else>Введите данные для автоизации</v-sheet>
                </v-col>
                <v-col cols="12" sm="9" class="pa1">
                    <control-email v-model="payloads.email"></control-email>
                </v-col>
                <v-col cols="12" sm="9" class="pa1">
                    <control-password v-model="payloads.password"></control-password>
                </v-col>
                <v-col cols="12" sm="9" class="pa1">
                    <div class="d-flex justify-center">
                        <v-checkbox v-model="payloads.rememberMe" label="Запомнить меня"></v-checkbox>
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
import {Component, Prop, Vue} from 'vue-property-decorator';
import {LoginRequest} from "../types";
import {AuthModule} from "../AuthModule";
import ControlEmail from "../../App/Components/FormElements/ControlEmail";
import ControlPassword from "../../App/Components/FormElements/ControlPassword";

@Component({components: { ControlEmail, ControlPassword}})
export default class LoginForm extends Vue {
    @Prop() error: string;
    payloads: LoginRequest =  {
        email: 'ignashov-roman@mail.ru',
        password: '12345678',
        rememberMe: false
    };

    get getError() { return this.error || null }
    get loading() { return AuthModule.isLoading }

    public submit() {
        if(this.$refs.loginForm.validate()) {
            this.$emit('submit', this.payloads);
        }
    }
}
</script>