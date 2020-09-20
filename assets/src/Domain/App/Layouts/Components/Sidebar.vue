<template>
    <v-navigation-drawer v-model="sidebar.status" class="deep-purple accent-4" app absolute clipped temporary>
        <v-list nav dense>
            <v-list-item v-for="item in menu" :key="item.name" link>
                <v-list-item-icon>
                    <v-icon>{{ item.meta.icon }}</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>{{ item.meta.label }}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { RouteConfig } from "vue-router";
import { AppModule } from "../../AppModule";
import { Sidebar as Sd}  from "../../Entity/Types/Sidebar";

@Component
export default class Sidebar extends Vue {

    get menu(): Array<RouteConfig>{
        return AppModule.getApp.menu.getNavMenu;
    }

    get sidebar(): Sd {
        return AppModule.getApp.sidebar;
    }
}
</script>