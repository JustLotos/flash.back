<template>
    <div>
        <v-navigation-drawer absolute clipped temporary v-model="drawer" app>
<!--            <v-toolbar>-->
<!--                <v-list class="pa-0">-->
<!--                    <v-list-item>-->
<!--                        <v-list-item-avatar>-->
<!--                            <img-->
<!--                                    src="https://randomuser.me/api/portraits/men/85.jpg"-->
<!--                                    alt="Изображение пользователя"-->
<!--                            >-->
<!--                        </v-list-item-avatar>-->
<!--                        <v-list-item-content>-->
<!--                            <v-list-item-title>Мой кабинет</v-list-item-title>-->
<!--                        </v-list-item-content>-->
<!--                    </v-list-item>-->
<!--                </v-list>-->
<!--            </v-toolbar>-->
<!--            <v-list class="pt-0" dense>-->
<!--                <v-list-item-->
<!--                    v-for="link of formatLinks"-->
<!--                    :key="link.name"-->
<!--                    :to="{ name: link.name }"-->
<!--                >-->
<!--                    <template v-if="link.children.length">-->
<!--                        <p>вложенное меню</p>-->
<!--                    </template>-->
<!--                    <template v-else>-->
<!--                        <v-list-item-action>-->
<!--                            <v-icon>{{link.icon}}</v-icon>-->
<!--                        </v-list-item-action>-->
<!--                        <v-list-item-content>-->
<!--                            <v-list-item-title>{{link.label}}</v-list-item-title>-->
<!--                        </v-list-item-content>-->
<!--                    </template>-->
<!--                </v-list-item>-->
<!--            </v-list>-->
        </v-navigation-drawer>

        <v-app-bar app clipped-left dark color="primary">
            <v-app-bar-nav-icon
                    class="hidden-md-and-up"
                    @click.stop="drawer = !drawer"
            />
            <div class="text-center">
                <v-btn large  color="primary" v-bind:to="{name: appNavLink.name}">
                    <v-icon left>{{ appNavLink.icon }}</v-icon> {{ appNavLink.label }}
                </v-btn>
            </div>
            <v-spacer></v-spacer>

            <v-toolbar-items class="hidden-sm-and-down">
                <template  v-for="(link, index) of protectedNav">
                    <v-menu :key="index" v-if="link.menu" open-on-hover bottom offset-y>
                        <template v-slot:activator="{ on }">
                            <v-btn v-on="on" :to="{ name: link.name}" text exact>
                                <v-icon left>{{ link.icon }}</v-icon>{{link.label}}
                            </v-btn>
                        </template>

                        <v-list v-if="link.children && link.children.length > 0">
                            <v-list-item v-for="item of link.children" :key="item.name" >
                                <v-btn :to="{ name: item.name }" text exact>
                                    <v-icon left>{{ item.icon }}</v-icon>{{ item.label }}
                                </v-btn>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </template>
            </v-toolbar-items>
        </v-app-bar>

    </div>

</template>

<script>
    export default {
        name: "AppHeader",
        computed: {
            appNavLink: function() {
                let routeName = 'Home';

                if (this.$store.getters['isAuthenticated']) {
                    routeName = 'Dashboard';
                }

                return this.$router.options.routes.find(function (route) {
                    return route.name === routeName;
                });
            },
            filteredNav: function () {
                return this.filterNavTree(this.$router.options.routes);
            },
            protectedNav: function () {
                return this.protectNavTree(this.filteredNav);
            }
        },
        data: function() {
          return {
              drawer: false,
              links: []
          }
        },
        methods: {
            filterNavTree: function (router) {
                return router.filter((route) => {
                    if(!route.name && route.children) {
                        route.name = route.children.find(function (child) {
                            return child.path === '';
                        }).name;
                    }

                    if(route.hasOwnProperty('children')) {
                        route.children = this.filterNavTree(route.children);
                    }

                    return !!route.menu;
                });
            },
            protectNavTree: function (router) {
                return router.filter((route) => {

                    let check = route.meta && !!route.meta.requiresAuth;

                    if(this.$store.getters['isAuthenticated']) {
                        return check;
                    }

                    return !check;
                });
            },
            toggleDrawer: function (drawer) {
                this.drawer = !drawer;
            },
        },
    }
</script>

<style scoped>

</style>