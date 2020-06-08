<template>
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
            <v-flex xs8 sm7 md6 lg4>
                <reset-password-form @reset="handle" @reset-error="handleError"></reset-password-form>
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
import {AuthModule} from "../AuthModule";
import ResetPasswordForm from "../Components/ResetPasswordForm.vue";

@Component({components: {ResetPasswordForm}})
export default class RegisterPage extends Vue{
    beforeRouteEnter (to, from, next) {
        AuthModule.isAuthenticated ? this.$root.$router.push({name: 'Dashboard'}) : next();
    }

    private handle(message: string) {
        console.log(message);
    }
    private handleError(message: string) {
        console.log(message);
    }
}
</script>

<style scoped>

</style>