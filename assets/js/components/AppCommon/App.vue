<template>
    <v-app id="inspire">
        <AppHeader
                v-bind:drawer="drawer"
                v-bind:links="links"
                v-bind:app-name="appName"
        />

        <AppContent></AppContent>

        <AppFooter v-bind:app-name="appName" />
    </v-app>
</template>

<script>
    import AppSideBar from "./SideBar/AppSideBar";
    import AppHeader from "./Header/AppHeader";
    import AppContent from "./Content/AppContent";
    import AppFooter from "./Footer/AppFooter";

    export default {
        name: "App",
        data: () => ({
            drawer: false,
            appName: 'FlashBack',
            links: [
                {
                    title: 'Войти',
                    name: 'login',
                    icon: 'mdi-login',
                    url: '/login'
                },
                {
                    title: 'Регистрация',
                    name: 'register',
                    icon: 'mdi-lock-open',
                    url: '/register'
                },
                {
                    title: 'Выйти',
                    name: 'logout',
                    icon: 'mdi-logout',
                    url: '/logout'
                },
                {
                    title: 'Учить',
                    name: 'learn',
                    icon: 'mdi-teach',
                    url: '/decks'
                },
                // {
                //     title: 'Мой кабинет',
                //     name: 'profile',
                //     icon: 'mdi-account-circle',
                //     url: '/profile'
                // },

            ]
        }),
        methods: {
        },
        components: {
            AppFooter,
            AppContent,
            AppHeader
        }
    }
</script>

<style scoped>

</style>