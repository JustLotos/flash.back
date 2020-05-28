<template>
    <v-content>
        <transition name="fade" duration="2000">
            <router-view></router-view>
        </transition>

<!--        <back-button></back-button>-->
    </v-content>
</template>

<script>
    const DEFAULT_TRANSITION = 'fade'
    import BackButton from "../common/BackButton";
    export default {
        data () {
            return {
                transitionName: DEFAULT_TRANSITION
            }
        },
        name: "AppContent",
        components: {BackButton},
        created() {
            this.$router.beforeEach((to, from, next) => {
                let transitionName = to.meta.transitionName || from.meta.transitionName;

                if (transitionName === 'slide') {
                const toDepth = to.path.split('/').length;
                const fromDepth = from.path.split('/').length;
                transitionName = toDepth < fromDepth ? 'slide-right' : 'slide-left';
                }

                this.transitionName = transitionName || DEFAULT_TRANSITION;
                next();
            });
        },

        beforeRouteUpdate (to, from, next) {
            const toDepth = to.path.split('/').length;
            const fromDepth = from.path.split('/').length;
            this.transitionName = toDepth < fromDepth ? 'slide-right' : 'slide-left';
            next();
        },
    }
</script>

<style scoped>

</style>