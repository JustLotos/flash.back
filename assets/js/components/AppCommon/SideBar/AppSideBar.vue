<template>

</template>

<script>
    export default {
        name: "AppSideBar",
        props: [
            'drawer',
            'links',
            'appName'
        ],
        computed: {
            getDrawerState: {
                get: function() {
                    return this.$props.drawer;
                },
                set: function (drawer) {
                    this.$props.drawer = drawer;
                }
            }
        }
    }
</script>

<style scoped>

</style>