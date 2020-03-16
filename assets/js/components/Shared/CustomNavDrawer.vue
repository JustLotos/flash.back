<template>
    <v-navigation-drawer
            temporary
            v-model="drawer"
            app
    >
        <v-list>
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="title">
<!--                        {{ appName }}-->
                    </v-list-item-title>
                    <v-list-item-subtitle>
                        #TODO subtitle
                    </v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

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
</template>

<script>
    export default {
        name: "CustomNavDrawer",
        data: function () {
            return {
                drawer: null,
                links: [
                    { title: 'Home', icon: 'mdi-home', url: '/home',  },
                ]
            }
        }
    }
</script>

<style scoped>

</style>