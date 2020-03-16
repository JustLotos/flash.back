<template>
    <v-app id="inspire">

        <CustomNavDrawer />

        <v-app-bar app dark color="primary">
            <v-app-bar-nav-icon
                    @click.stop="drawer = !drawer"
                    class="hidden-md-and-up"
            />
            <v-toolbar-title> {{ appName }} </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items class="hidden-sm-and-down">
                <v-btn
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


    </v-app>
</template>

<script>
    import CustomNavDrawer from "./CustomNavDrawer";

    export default {
        name: "App",
        props: {
            source: String,
        },
        data: () => ({
            appName: 'FlashBack',
            links: [
                { title: 'Home', icon: 'mdi-home', url: '/home',  }
            ]
        }),
        components: {
            CustomNavDrawer
        }
    }
</script>

<style scoped>

</style>