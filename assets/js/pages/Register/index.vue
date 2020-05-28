<template>
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
            <v-flex xs11 sm7 md5>
                <register-form></register-form>
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

<script>
    import {mapGetters} from "vuex";
    import RegisterForm from "./RegisterForm";

    export default {
        components: {RegisterForm},
        computed: {
        ...mapGetters({
                hasError: 'isAuthenticated',
                isLoading: 'isLoading',
            }),
        },
        created() {
            //#TODO в beforeEnter
            let redirect = this.$route.query.redirect;

            if (this.isAuthenticated) {
                if (typeof redirect !== "undefined") {
                    this.$router.push({path: redirect});
                } else {
                    this.$router.push({name: "Dashboard"});
                }
            }
        },
    }
</script>

<style scoped>
    .fill-width{
        width: 100%;
    }
</style>