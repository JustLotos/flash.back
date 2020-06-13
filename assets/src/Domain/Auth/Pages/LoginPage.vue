<template>
    <v-layout align-center justify-center>
        <v-flex sm10 md8 lg6>
            <v-toolbar color="primary" dark flat>
                <v-toolbar-title>Авторизация</v-toolbar-title>
            </v-toolbar>
            <login-form @submit="handle" :error="error" ></login-form>
            <v-card-actions class="mt-5">
                <v-row class="text--white">
                    <v-col cols="12" class="pa1 text-center">
                        <span class="text--white">Еще не зарегестрированы?</span>
                        <v-btn text link :to="{name: 'Register'}" color="primary">Присоедениться!</v-btn>
                    </v-col>
                    <v-col cols="12" class="pa1 text-center">
                        <span>Забыли пароль?</span>
                        <v-btn text link :to="{name: 'ResetPassword'}" color="primary">Восстановить!</v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
        </v-flex>
    </v-layout>
</template>
<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {AuthModule} from "../AuthModule";
import LoginForm from "../Components/LoginForm.vue";
import {AppModule} from "../../App/AppModule";
import {LoginRequest} from "../types";

@Component({components: {LoginForm}})
export default class LoginPage extends Vue{
    error: string = '';

    beforeRouteEnter (to, from, next) {
        AuthModule.isAuthenticated ? next(AppModule.getRedirectOnUnguardedPath) : next();
    }

    private handle(payloads: LoginRequest) {
        AuthModule.login(payloads)
            .then(() => { this.$root.$router.push(AppModule.getRedirectOnUnguardedPath) })
            .catch((error: AxiosError)=>{
                if(error.response?.data.errors && error.response?.data.errors.auth) {
                    this.error = error.response?.data.errors.auth;
                }
                console.log(error.response);
            });
    }
}
</script>