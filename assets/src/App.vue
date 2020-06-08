<template>
    <component :is="this.$root.$route.meta.layout || 'div'">
        <router-view/>
    </component>
</template>
<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import {AuthModule} from "./Domain/Auth/AuthModule";
@Component
export default class App extends Vue {
    constructor() {
        super();
        AuthModule.init();
    }
}
</script>