<template>
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
            <v-flex xs8 sm7 md6 lg4>
                <login-form @login="handle"></login-form>
                <v-card-actions class="mt-5">
                    <v-row justify="center" class="flex-wrap">
                        <v-card flat>
                            <span>Еще не зарегестрированы?</span>
                            <v-btn text link :to="{name: 'Register'}" color="primary">Присоедениться!</v-btn>
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
import LoginForm from "../Components/LoginForm.vue";

Component.registerHooks(['beforeRouteEnter']);
@Component({components: {LoginForm}})
export default class LoginPage extends Vue{
    beforeRouteEnter (to, from, next) {
        AuthModule.isAuthenticated ? this.handle() : next();
    }

    private handle() {
        this.$root.$router.push({name: 'Dashboard'});
    }
}
</script>