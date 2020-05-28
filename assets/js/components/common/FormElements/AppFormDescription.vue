<template>
    <v-textarea
            v-model="value"
            label="Описание"
            id="description"
            name="description"
            auto-grow
            :rows="rows"
            :row-height="24"
    ></v-textarea>
</template>

<script>
    const EVENT_NAME = 'descriptionChange'.toLowerCase();
    export default {
        name: "AppFormDescription",
        props: [
            'description',
            'errorMessage'
        ],
        model: {
            prop: 'description',
            event: EVENT_NAME
        },
        computed: {
            value: {
                get: function() {
                    return this.description
                },
                set: function(value) {
                    this.$emit(EVENT_NAME, value)
                }
            },
            rows: function () {
                if (this.value && this.value.length) {
                    return Math.ceil(this.value.length / 10) % 10;
                }
                return 1;
            }
        },
    }
</script>

<style scoped>

</style>