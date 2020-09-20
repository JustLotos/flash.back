<template>
    <v-app-bar app clipped-left dark color="primary">
        <v-app-bar-nav-icon class="hidden-md-and-up" @click.stop="toggleSideBar"/>
        <div class="text-center">
            <v-btn large  color="primary" @click="handleLogoRedirect">
                <v-icon left>{{ logo.meta.icon }}</v-icon> {{ logo.meta.label }}
            </v-btn>
        </div>
        <v-spacer/>
        <navbar/>
    </v-app-bar>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import Navbar from './Navbar.vue';
import { AppModule } from "../../AppModule";
import { UserModule } from "../../../User/UserModule";
import { RouteConfig } from "vue-router";

@Component({components: {Navbar}})
export default class BaseHeader extends Vue {
    logo: RouteConfig = AppModule.getApp.logo;

    private toggleSideBar() {
        return AppModule.getApp.sidebar.toggleStatus();
    }

    handleLogoRedirect() {
        if (this.$route.name !== this.$router.resolve({name: 'Home'}).resolved.name &&
            this.$route.name !== this.$router.resolve({name: 'Dashboard'}).resolved.name
        ) {
          debugger;
            if(UserModule.isAuthenticated) { return this.$router.push({name: 'Dashboard'}) }
            return this.$router.push({name: 'Home'});
        }
    }
}
</script>