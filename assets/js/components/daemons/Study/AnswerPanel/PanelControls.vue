<template>
    <v-card-actions>
        <v-btn
            v-if="state === INIT"
            @click="changeState(ANSWER)"
        >Показать</v-btn>

        <rating-buttons
            v-else-if="state === ANSWER"
            @answer="changeState(NEXT)"
            :params="params"
        />

        <v-btn
            v-if="next === NEXT"
            @click="changeState(INIT)"
        >Следующая</v-btn>
    </v-card-actions>
</template>

<script>
    export default {
        name: "PanelControls",
        data: function() {
            return {
                INIT: 'INIT',
                ANSWER: 'ANSWER',
                NEXT: 'NEXT',
                state: this.$data.CLOSE
            }
        },
        methods: {
            changeState(value) {
                this.$data.state = value;
            }
        },
        watch: {
            state(value, prev) {
                if(value === this.$data.INIT) {

                }
            }
        }
    }
</script>

<style scoped>

</style>