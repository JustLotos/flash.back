<template>
    <v-app-bar app clipped-left dark color="primary">
        <v-app-bar-nav-icon class="hidden-md-and-up" @click.stop="toggleSideBar"/>
        <div class="text-center">
            <v-btn large  color="primary" @click="handleLogoRedirect">
                <v-icon left>{{ logo.icon }}</v-icon> {{ logo.label }}
            </v-btn>
        </div>
        <v-spacer/>
        <navbar/>
    </v-app-bar>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import Navbar from './Navbar.vue';
import {Link} from "../../types";
import {AppModule} from "../../AppModule";
import {AuthModule} from "../../../Auth/AuthModule";

@Component({components: {Navbar}})
export default class BaseHeader extends Vue {
    logo: Link = { path: '/', label: 'FlashBack', icon: 'mdi-home'};

    private toggleSideBar() {
        AppModule.ToggleSideBar(false);
    }

    handleLogoRedirect() {
        if (
            this.$root.$route.name !== this.$root.$router.resolve({name: 'Home'}).resolved.name &&
            this.$root.$route.name !== this.$root.$router.resolve({name: 'Dashboard'}).resolved.name
        ) {
            if(AuthModule.isAuthenticated) {
                return this.$root.$router.push({name: 'Dashboard'});
            }
            return this.$root.$router.push({name: 'Home'});
        }

    }
}
</script>