<template>
    
</template>

<script>
    export default {
        name: "Logout",
        created() {
            this.$store.dispatch("UserStore/logout");
            this.$router.push({name: 'Home'});
        }
    }
</script>

<style scoped>

</style>