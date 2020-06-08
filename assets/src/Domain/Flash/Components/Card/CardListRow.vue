<template>
    <v-hover open-delay="0.3s" v-slot:default="{ hover }">
        <v-btn
            block
            depressed
            x-large
            light
            class="mb-1 pa0"
            :elevation="hover ? 24 : 0"
            :class="{ 'on-hover': hover }"
            :to="getLink()"
        >{{card.name}}</v-btn>
    </v-hover>
</template>

<script>
    export default {
        name: "CardListRow",
        props: ['card'],
        methods: {
            getLink: function () {
                if(this.card && this.card.id) {
                    return { name: 'card', params: {id: this.card.id} };
                }
                return {};
            }
        }
    }
</script>

<style scoped>

</style>