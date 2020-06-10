<template>
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
            <v-flex sm10 md8 lg6>
                <v-toolbar color="primary" dark flat>
                    <v-toolbar-title>Регистрация</v-toolbar-title>
                </v-toolbar>
                <register-form @register="handle" :errors="errors"></register-form>
                <v-card-actions class="mt-5">
                    <v-row justify="center" class="flex-wrap">
                        <v-card flat>
                            <span>Есть учетная запись?</span>
                            <v-btn text link :to="{name: 'Login'}" color="primary">Войти</v-btn>
                        </v-card>
                    </v-row>
                </v-card-actions>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import RegisterForm from "../Components/RegisterForm.vue";
import {AuthModule} from "../AuthModule";
import {AppModule} from "../../App/AppModule";
import {RegisterRequest} from "../types";

Component.registerHooks(['beforeRouteEnter']);
@Component({components: {RegisterForm}})
export default class RegisterPage extends Vue{
    errors: RegisterRequest = {email: '', password: '', plainPassword: ''};

    private handle(payloads: RegisterRequest) {
        AuthModule.register(payloads)
            .then(() => { this.$root.$router.push( AppModule.getRedirectOnUnguardedPath ); })
            .catch((error: AxiosError) => {
                this.errors = error.response?.data.errors
                console.log(error.response);
            });
    }

    beforeRouteEnter (to, from, next) {
        AuthModule.isAuthenticated ? next( AppModule.getRedirectOnUnguardedPath ) : next();
    }
}
</script>