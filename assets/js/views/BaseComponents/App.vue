<template>
    <v-app id="inspire">
        <AppHeader
                v-bind:drawer="drawer"
                v-bind:links="getNavLinks"
                v-bind:app-name="appName"
        />

        <AppContent></AppContent>

        <AppFooter v-bind:app-name="appName" />
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
            appName: 'FlashBack',
            links: [],
            linksProtected: [
                {
                    title: 'Учить',
                    name: 'learn',
                    icon: 'mdi-teach',
                    url: {name: 'Decks'},
                    protected: true
                },
                {
                    title: 'Мой кабинет',
                    name: 'profile',
                    icon: 'mdi-account-circle',
                    url: {name: "Profile"}
                },
                {
                    title: 'Выйти',
                    name: 'logout',
                    icon: 'mdi-logout',
                    url: {name: 'Logout'},
                    protected: true,
                },

            ],
            linksUnprotected: [
                {
                    title: 'Войти',
                    name: 'login',
                    icon: 'mdi-login',
                    url: {name: 'Login'},
                    protected: false,
                },
                {
                    title: 'Регистрация',
                    name: 'register',
                    icon: 'mdi-account-multiple-plus',
                    url: {name: 'Register'},
                    protected: false
                },
            ]
        }),
        computed: {
          getNavLinks: function () {
              if(this.$store.getters['UserStore/isAuthenticated']){
                  return this.linksProtected;
              }
              else {
                  return this.linksUnprotected;
              }
          }
        },
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