<template>
    <div>
        <v-btn light @click="toggle" elevation="0" block >
            <slot name="label" :value="value"></slot>
        </v-btn>
        <v-slider
            v-show="show"
            class="pa-3"
            v-model="value"
            color="primary"
            thumb-label="always"
            :thumb-size="20"
            persistent-hint
            :hint="hint"
            min="1"
            max="100"
        >
            <template v-slot:prepend>
                <v-icon @click="decrement">mdi-minus</v-icon>
            </template>

            <template v-slot:append>
                <v-icon @click="increment">mdi-plus</v-icon>
            </template>
        </v-slider>
    </div>
</template>

<script>
    const EVENT_NAME = 'sliderChange'.toLowerCase();
    export default {
        name: "AppFormSlider",
        props: [
            'slider',
            'hint',
            'errorMessage'
        ],
        model: {
            prop: 'slider',
            event: EVENT_NAME
        },
        computed: {
            value: {
                get: function() {
                    return this.slider
                },
                set: function(value) {
                    this.$emit(EVENT_NAME, value)
                }
            },
        },
        data: function () {
            return {
                show: false,
                rules: [
                    v => !!v || this.label + ' обязательено для заполнения',
                    v => v > 0 || this.label + ' должно быть положительным',
                    v => v < 10000 || this.label + ' не должно превышать лимит 10000'
                ],
            }
        },
        methods: {
            toggle: function () {
                this.show = !this.show;
            },
            increment: function () {
                this.value++;
            },
            decrement: function () {
                this.value--;
            }
        }
    }
</script>

<style scoped>

</style>