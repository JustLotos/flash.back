<template>
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
            <h1 class="text-center text--white">Это главная вкладка приложения</h1>
            <p class="text-center text--white">и скоро тут появятся виджеты</p>
          <a href="/api/v1/cards/">Click!</a>
        </v-layout>
    </v-container>
</template>
<script lang="ts">
import {Component, Vue} from "vue-property-decorator";
@Component
export default class Dashboard extends Vue{}
</script>