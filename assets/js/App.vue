<template>
    <v-app id="inspire">
        <app-header/>
        <app-content/>
        <app-footer/>
    </v-app>
</template>

<script>
    import AppHeader from "./components/layout/AppHeader";
    import AppContent from "./components/layout/AppContent";
    import AppFooter from "./components/layout/AppFooter";
    import axios from "axios";

    export default {
        name: "App",
        components: {
            AppFooter,
            AppContent,
            AppHeader
        }
    }
</script>

<style scoped>

</style>