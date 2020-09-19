<template>
    <component :is="this.$root.$route.meta.layout || 'div'">
        <router-view/>
    </component>
</template>
<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
Component.registerHooks(['beforeRouteEnter']);
@Component
export default class App extends Vue {}
</script>
<style>
    .centered-input >>> input { text-align: center }
    .text--white {
        color: #FFFFFF !important;
    }
</style>