<template>
    <div>
        <v-navigation-drawer absolute clipped temporary v-model="drawer" app>
            <v-toolbar>
                <v-list class="pa-0">
                    <v-list-item>
                        <v-list-item-avatar>
                            <img
                                    src="https://randomuser.me/api/portraits/men/85.jpg"
                                    alt="Изображение пользователя"
                            >
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>Мой кабинет</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-toolbar>
            <v-list class="pt-0" dense>
                <v-list-item
                    v-for="link of links"
                    :key="link.title"
                    :to="link.url"
                >
                    <v-list-item-action>
                        <v-icon>{{link.icon}}</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>{{link.title}}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar app dark color="primary">
            <v-app-bar-nav-icon
                    class="hidden-md-and-up"
                    @click.stop="drawer = !drawer"
            />
            <div class="text-center">
                <v-btn large  color="primary" v-bind:to="HomePage.url">
                    <v-icon left>{{ HomePage.icon }}</v-icon> {{HomePage.title}}
                </v-btn>
            </div>
            <v-spacer></v-spacer>

            <v-toolbar-items class="hidden-sm-and-down">
                <v-btn
                    v-on:drawer="drawer"
                    v-for="link of links"
                    :key="link.title"
                    :to="link.url"
                    text
                >
                    <v-icon left>{{ link.icon }}</v-icon>
                    {{ link.title }}
                </v-btn>
            </v-toolbar-items>
        </v-app-bar>
    </div>

</template>

<script>
    export default {
        name: "AppHeader",
        props: [
            'links',
            'appName'
        ],
        data: function() {
          return {
              drawer: false,
              HomePage:  { title: this.$props.appName, icon: 'mdi-home', url: '/',  },
          }
        },
        methods: {
            toggleDrawer: function (drawer) {
                this.drawer = !drawer;
            }
        }
    }
</script>

<style scoped>

</style>