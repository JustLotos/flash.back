<template>
    <v-layout align-center justify-center>
        <v-flex sm10 md8 lg6>
            <v-toolbar color="primary" dark flat>
                <v-toolbar-title>Восстановление</v-toolbar-title>
            </v-toolbar>
            <reset-password-form @reset="handle" :errors="errors"></reset-password-form>
            <v-card-actions class="mt-5">
                <v-row justify="center" class="flex-wrap">
                    <v-card flat class="transparent">
                        <span class="text--white">Есть учетная запись?</span>
                        <v-btn text link :to="{name: 'Login'}" color="primary">Войти</v-btn>
                    </v-card>
                </v-row>
            </v-card-actions>
        </v-flex>
        <modal v-model="modal"><v-alert type="success">{{modalMessage}}</v-alert></modal>
    </v-layout>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {AuthModule} from "../AuthModule";
import ResetPasswordForm from "../Components/ResetPasswordForm.vue";
import {AppModule} from "../../App/AppModule";
import Modal from  "../../App/Components/Modal";
import {RegisterRequest} from "../types";

@Component({components: {ResetPasswordForm, Modal}})
export default class RegisterPage extends Vue{
    modal: boolean = false;
    modalMessage: string = '';
    errors: RegisterRequest = {email: '', password: '', plainPassword: ''};

    beforeRouteEnter (to, from, next) {
        AuthModule.isAuthenticated ? next(AppModule.getRedirectOnUnguardedPath) : next();
    }

    private handle(payloads: RegisterRequest) {
        AuthModule.resetPassword(payloads)
            .then(() => {
                this.modal = !this.modal;
                this.modalMessage = 'Письмо уже отправелно!, поверьте ваш email';
            })
            .catch((error: AxiosError) => {
                if(error.response?.data.errors) {
                    this.errors = error.response?.data.errors;
                }
                console.log(error.response);
            });
    }
}
</script>