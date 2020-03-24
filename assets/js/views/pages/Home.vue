<template>
    <v-container>
        <v-layout row>
            <v-flex xs12>
                <h1>Home</h1>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        data: function () {
            return {}
        },
        created() {
            if (this.$store.getters["user/isAuthenticated"]) {
                this.$router.push({name: 'Dashboard'});
            }
        }
    }
</script>

<style scoped>

</style>