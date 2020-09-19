<template>
    <v-card class="elevation-10">
        <v-form ref="registerForm">
            <v-row justify="center">
                <v-col cols="12" sm="9" class="text-center">
                    <v-sheet>Введите данные для регистрации</v-sheet>
                </v-col>
                <v-col cols="12" sm="9" class="pa1">
                    <control-email v-model="data.email" :error="getErrors.email"></control-email>
                </v-col>
                <v-col cols="12" sm="9" class="pa1">
                    <control-password v-model="data.password" :error="getErrors.password"></control-password>
                </v-col>
                <v-col cols="12" sm="9" class="pa1">
                    <control-confirm
                        v-model="data.plainPassword"
                        :error="getErrors.plainPassword"
                        :field="data.password"
                        label="Подтверждение пароля"
                    ></control-confirm>
                </v-col>
            </v-row>
            <v-divider></v-divider>
            <v-card-actions class="justify-center">
                <v-btn class="pa2 text-center primary" @click="register" :loading="loading">Зарегистрироваться</v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import ControlEmail from "../../../App/Components/FormElements/ControlEmail.vue";
import ControlPassword from "../../../App/Components/FormElements/ControlPassword.vue";
import ControlConfirm from "../../../App/Components/FormElements/ControlConfirm.vue";
import {UserModule} from "../../UserModule";
import RegisterByEmailRequest from "../../Entity/API/Register/ByEmail/RegisterByEmailRequest";

@Component({components: { ControlEmail, ControlPassword, ControlConfirm}})
export default class RegisterForm extends Vue  {
    @Prop() errors: RegisterByEmailRequest;

    private data: RegisterByEmailRequest = {
        email: 'test@mail.ru',
        password: '12345678',
        plainPassword: '12345678'
    };

    get loading() { return UserModule.isLoading }

    get getErrors(): RegisterByEmailRequest {
        return this.errors || { email: '', password: '', plainPassword: '' }
    }

    register() {
        if(this.$refs.registerForm.validate()) {
            this.$emit('register', this.data);
        }
    }
}
</script>