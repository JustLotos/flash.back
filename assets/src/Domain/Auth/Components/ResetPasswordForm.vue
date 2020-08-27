<template>
    <v-card class="elevation-10">
        <v-form ref="resetForm">
            <v-row justify="center">
                <v-col cols="12" sm="9" class="text-center">
                    <v-sheet>Введите данные для восстановления</v-sheet>
                </v-col>
                <v-col cols="12" sm="9" class="pa1">
                    <control-email v-model="payloads.email" :error="getErrors.email"></control-email>
                </v-col>
                <v-col cols="12" sm="9" class="pa1">
                    <control-password v-model="payloads.password" :error="getErrors.password"></control-password>
                </v-col>
                <v-col cols="12" sm="9" class="pa1">
                    <control-confirm
                        v-model="payloads.plainPassword"
                        :error="getErrors.plainPassword"
                        :field="payloads.password"
                        label="Подтверждение пароля"
                    ></control-confirm>
                </v-col>
            </v-row>
            <v-divider></v-divider>
            <v-card-actions class="justify-center">
                <v-btn class="pa2 text-center primary" @click="resetPassword" :loading="loading">Отправить запрос</v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>


<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import {RegisterRequest} from "../types";
import {AuthModule} from "../AuthModule";
import ControlEmail from "../../App/Components/FormElements/ControlEmail";
import ControlPassword from "../../App/Components/FormElements/ControlPassword";
import ControlConfirm from "../../App/Components/FormElements/ControlConfirm";

@Component({components: { ControlEmail, ControlPassword, ControlConfirm}})
export default class RegisterForm extends Vue  {
    payloads: RegisterRequest = {email: '', password: '', plainPassword: ''};
    @Prop() errors: RegisterRequest;

    get getErrors(): RegisterRequest {
        return this.errors || {email: '', password: '', plainPassword: ''}
    }

    get loading() {return AuthModule.isLoading;}

    resetPassword() {
        if(this.$refs.resetForm.validate()) {
            this.$emit('reset', this.payloads)
        }
    }

}
</script>