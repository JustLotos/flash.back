<template>
    <v-navigation-drawer v-model="getSidebar" app absolute clipped temporary color="primary">
        <v-list nav dense>
            <v-list-item v-for="item in menu" :key="item.name" link>
                <v-list-item-icon>
                    <v-icon>{{ item.meta.icon }}</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>
                      <router-link
                          :to="item.path"
                          class="navbar__link"
                          @click="sidebar = false"
                      >{{ item.meta.label }}</router-link>
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import { RouteConfig } from "vue-router";
import { AppModule } from "../../AppModule";

@Component
export default class Sidebar extends Vue {
    @Prop()
    sidebar: boolean;

    get menu(): Array<RouteConfig>{
      return AppModule.getApp.menu.getNavMenu;
    }

    get getSidebar() {
      return this.sidebar;
    }
    set getSidebar(value: boolean) {
        this.$emit('change',  value);
    }
}
</script>

<style>
  .navbar__link{
    color: white !important;
    text-decoration: none;
    font-size: 16px;
  }
</style>