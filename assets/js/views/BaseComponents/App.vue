<template>
    <v-app id="inspire">
        <AppHeader v-bind:drawer="drawer"/>

        <AppContent></AppContent>

        <AppFooter />
    </v-app>
</template>

<script>
    import AppHeader from "./AppHeader";
    import AppContent from "./AppContent";
    import AppFooter from "./AppFooter";
    import axios from "axios";

    export default {
        name: "App",
        created() {
            let comp = this;

            // #TODO авторизация при перезагрузке страницы
            this.$store.dispatch("UserStore/onRefreshApp");
            //     .then(function (result) {
            //         if(!result) {
            //             //comp.$router.push({path: "/login"})
            //         }
            //     });

            axios.interceptors.response.use(undefined, (err) => {
                return new Promise(() => {
                    if (err.response.status === 401) {
                        this.$router.push({name: 'Login'})
                    }
                    throw err;
                });
            });
        },
        data: () => ({
            drawer: false,
        }),
        components: {
            AppFooter,
            AppContent,
            AppHeader
        }
    }
</script>

<style scoped>

</style>