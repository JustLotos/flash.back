<template>
    <component :is="this.$root.$route.meta.layout || 'div'">
        <router-view/>
    </component>
</template>
<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import {AuthModule} from "./Domain/Auth/AuthModule";
import {LearnerModule} from "./Domain/Flash/Modules/LearnerModule";
import date from "./Utils/date";
Component.registerHooks(['beforeRouteEnter']);

@Component
export default class App extends Vue {
    async mounted() {
        await AuthModule.INIT_AUTH();


        let start = new Date();
        window.addEventListener('beforeunload',  async (event) => {
            event.preventDefault();
            let end = new Date();
            debugger;
            let response = await LearnerModule.sendSession({
                date: date('Y-m-d\\TH:i:sP', start),
                duration: ((start.getTime() - end.getTime()) / 1000)
            });
            debugger;
        });
    }
}
</script>
<style>
    .centered-input >>> input { text-align: center }
    .text--white {
        color: #FFFFFF !important;
    }
</style>