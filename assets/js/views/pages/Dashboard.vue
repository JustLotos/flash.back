<template>
    <div>
        <DeckList />
    </div>
</template>

<script>
    import DeckList from "../../components/Deck/DeckList";
    export default {
        name: "Dashboard",
        components: {DeckList},
        data: function () {
            return {};
        },
        methods: {
            async getDecks(){
                await this.$store.dispatch("DeckStore/findAll");
            }
        }
    }
</script>

<style scoped>

</style>