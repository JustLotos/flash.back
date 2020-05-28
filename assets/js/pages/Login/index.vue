<template>
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
            <v-flex xs11 sm7 md5>
                <login-form></login-form>
                    <v-row justify="center" class="flex-wrap mt-5">
                        <v-card flat>
                            <span>Нет учетной записи?</span>
                            <v-btn text link :to="{name: 'Register'}" color="primary">Создать аккаунт</v-btn>
                        </v-card>
                    </v-row>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import { mapGetters } from 'vuex';
    import LoginForm from "./LoginForm";

    export default {
        components: {LoginForm},
        computed: {
            ...mapGetters([
                'isLoading',
                'isAuthenticated'
            ]),
        },
        created() {
            let redirect = this.$route.query.redirect;

            if (this.isAuthenticated) {
                if (typeof redirect !== "undefined") {
                    this.$router.push({path: redirect});
                } else {
                    this.$router.push({name: "Dashboard"});
                }
            }
        }
    }
</script>

<style scoped>
</style>