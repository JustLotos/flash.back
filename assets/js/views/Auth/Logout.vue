<template>
    
</template>

<script>
    import store from "../../store/store";
    export default {
        name: "Logout",
        beforeRouteEnter (to, from, next) {
            store.dispatch("UserStore/logout");
            next({
                name: "Home",
                query: { redirect: to.fullPath }
            })
        },
    }
</script>

<style scoped>

</style>