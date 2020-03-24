<template>
    <v-footer  padless >
        <v-row class="flex primary" >
            <v-col class="text-center" >
<!--                #TODO доделать ссылку на сторонний сайт-->
                <v-btn
                        v-for="service in services"
                        :key="service.name"
                        class="mx-4"
                        icon
                        text
                        color="white"
                        v-bind:to="service.link"
                >
                    <v-icon size="24px">{{ service.icon }}</v-icon>
                </v-btn>
            </v-col>
        </v-row>
    </v-footer>
</template>

<script>

    import {mdiGithub} from "@mdi/js";

    export default {
        name: 'AppFooter',
        props: [
            'appName'
        ],
        data: () => ({
            services: [
                { name:'github', icon: mdiGithub, link: 'https://github.com/JustLotos/flash.back' },
            ],
        }),
    }
</script>
<style scoped>

</style>