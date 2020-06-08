<template>
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
            <h1 class="text-center">Это главная вкладка приложения</h1>
            <p class="text-center">и скоро тут появятся виджеты</p>
        </v-layout>
    </v-container>
</template>
<script lang="ts">
import {Component, Vue} from "vue-property-decorator";
@Component
export default class Dashboard extends Vue{}
</script>