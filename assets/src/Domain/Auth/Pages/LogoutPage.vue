<template></template>
<script lang="ts">
import {Component, Vue} from "vue-property-decorator";
import {AuthModule} from "../AuthModule";
@Component
export default class LogoutPage extends Vue {
    beforeRouteEnter (to, from, next) {
        AuthModule.logout();
        next({name: "Home"})
    }
}
</script>