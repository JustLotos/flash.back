<template>
    <component :is="this.$root.$route.meta.layout || 'div'">
        <router-view/>
    </component>
</template>
<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import {AuthModule} from "./Domain/Auth/AuthModule";
Component.registerHooks(['beforeRouteEnter']);

@Component
export default class App extends Vue {
    async mounted() {
        await AuthModule.INIT_AUTH()
    }
}
</script>
<style>
    .centered-input >>> input { text-align: center }
    .text--white {
        color: #FFFFFF !important;
    }
</style>