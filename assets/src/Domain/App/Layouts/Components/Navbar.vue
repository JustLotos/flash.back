<template>
    <v-toolbar-items class="hidden-sm-and-down">
        <v-menu v-for="link of menu" :key="link.name">
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" :to="{ name: link.name}" text exact>
                    <v-icon left>{{ link.meta.icon }}</v-icon>{{ link.meta.label }}
                </v-btn>
            </template>
        </v-menu>
    </v-toolbar-items>
</template>

<script lang="ts">
import { Component, Vue} from "vue-property-decorator";
import { RouteConfig } from "vue-router";
import { AppModule } from "../../AppModule";

@Component
export default class Navbar extends Vue {
    get menu(): Array<RouteConfig> { return AppModule.getApp.menu.getNavMenu; }
}
</script>