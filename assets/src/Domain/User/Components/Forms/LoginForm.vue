<template>
    <v-card class="elevation-10">
        <v-form ref="loginForm">
            <v-row justify="center">
                <v-col cols="12" sm="9" class="pa1 text-center">
                    <v-sheet >Введите данные для автоизации</v-sheet>
                    <v-alert v-if="notFound" type="error" transition="fade-transition">Пользователь не найден</v-alert>
                </v-col>
                <v-col cols="12" sm="9" class="pa1">
                    <control-email v-model="data.email" :error="getError.email"/>
                </v-col>
                <v-col cols="12" sm="9" class="pa1">
                    <control-password v-model="data.password" :error="getError.password"/>
                </v-col>
                <v-col cols="12" sm="9" class="pa1">
                    <div class="d-flex justify-center">
                        <v-checkbox v-model="data.rememberMe" :error="getError.rememberMe" label="Запомнить меня"/>
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
import ControlEmail from "../../../App/Components/FormElements/ControlEmail.vue";
import ControlPassword from "../../../App/Components/FormElements/ControlPassword.vue";
import LoginRequest from "../../Entity/API/Login/LoginRequest";
import {UserModule} from "../../UserModule";

@Component({components: { ControlEmail, ControlPassword}})
export default class LoginForm extends Vue {
    @Prop() error: LoginRequest;
    @Prop() notFound: boolean;

    private data: LoginRequest =  {
        email: 'ignashov-roman@mail.ru',
        password: '12345678Ab',
        rememberMe: false
    };

    get getError(): LoginRequest {
      return this.error || { email: '', password: '', rememberMe: false }
    }
    get loading() { return UserModule.isLoading }

    public submit() {
        if(this.$refs.loginForm.validate()) {
            this.$emit('submit', this.data);
        }
    }
}
</script>