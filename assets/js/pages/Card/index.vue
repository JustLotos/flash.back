<template>
    <v-container>
        <v-layout justify-center align-center>
            <router-view></router-view>
        </v-layout>
    </v-container>
</template>

<script>
    import CardDetail from "./CardDetail";

    export default {
        name: "Cards",
        components: {CardDetail}
    }
</script>

<style scoped>

</style>