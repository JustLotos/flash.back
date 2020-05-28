<template>
    <v-card class="elevation-10">
        <v-toolbar color="primary" class="text-center" dark flat>
            <v-toolbar-title class="fill-width text-center">Регистрация</v-toolbar-title>
        </v-toolbar>
        <v-form ref="registerForm">
            <v-card-text>
                <v-row justify="center">
                    <v-col cols="12" lg="8" class="pa0">
                        <app-form-email v-model="email" :error-message="emailErrorMessage"></app-form-email>
                    </v-col>
                    <v-col cols="12" lg="8" class="pa0">
                        <app-form-password v-model="password" :error-message="passwordErrorMessage"></app-form-password>
                    </v-col>
                    <v-col cols="12" lg="8" class="pa0">
                        <app-form-plain-password
                            v-model="plainPassword"
                            :password="password"
                            :error-message="plainPasswordErrorMessage"
                        ></app-form-plain-password>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions class="justify-center">
                <v-btn class="pa2" color="primary" @click="performRegister()" :loading="isLoading">Зарегистрироваться</v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>

<script>
    import { mapGetters } from 'vuex';
    import AppFormEmail from "../../components/common/FormElements/AppFormEmail";
    import AppFormPassword from "../../components/common/FormElements/AppFormPassword";
    import AppFormPlainPassword from "../../components/common/FormElements/AppFormPlainPassword";

    export default {
        name: "RegisterForm",
        components: {AppFormPlainPassword, AppFormPassword, AppFormEmail},
        data: function () {
            return {
                email: "",
                password: "",
                plainPassword: "",
                rememberMe: false,
            }
        },
        computed: {
            emailErrorMessage: function() {
                if(this.errors && this.errors.hasOwnProperty('email')) {
                    return this.errors.email
                }
                return '';
            },
            passwordErrorMessage: function() {
                if(this.errors && this.errors.hasOwnProperty('password')) {
                    return this.errors.password
                }
                return '';
            },
            plainPasswordErrorMessage: function(prop) {
                if(this.errors && this.errors.hasOwnProperty('plain_password')) {
                    return this.errors.plain_password
                }
                return '';
            },
            ...mapGetters({
                errors: 'errorsRegister',
                isLoading: 'isLoading',
            }),
        },
        methods: {
            async performRegister() {
                if (this.$refs.registerForm.validate()) {
                    await this.$store.dispatch("register", {
                        email: this.email,
                        password: this.password,
                        plain_password: this.plainPassword
                    }).then(() => {
                        let redirect = this.$route.query.redirect;
                        if (typeof redirect !== "undefined") {
                            this.$router.push({path: redirect});
                        } else {
                            this.$router.push({name: "Dashboard"});
                        }
                    }).catch((error) => {
                        console.log("Ошибка регистрации: " + JSON.parse(error));
                    });
                }
            }
        },
    }
</script>
<style scoped></style>