<template>
    <v-dialog v-model="modal" :max-width="width">
        <v-container>
            <v-layout justify-center align-center style="position: relative">
                <v-flex xs10 :class="style" class="justify-center align-center">
                    <slot></slot>
                    <v-btn absolute top right icon dark @click="modalToggle">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-flex>
            </v-layout>
        </v-container>
    </v-dialog>
</template>

<script>
    const SHORT = 'short';
    const WIDE = 'wide';
    const EVENT_NAME = 'modalChange'.toLowerCase();
    export default {
        name: "Modal",
        props: {
            modal: {
                type: Boolean,
                required: true,
            },
            type: {
                type: String,
                default: 'SHORT'
            }
        },
        model: {
            prop: 'modal',
            event: EVENT_NAME
        },
        computed: {
            value: {
                get: function() {
                    return this.modal
                },
                set: function(value) {
                    this.$emit(EVENT_NAME, value)
                }
            },
            width: function () {
                if(this.type === this.WIDE) {
                    return '900px';
                }
                return '700px';
            }
        },
        methods: {
            modalToggle: function () {
                this.value =  !this.value;
            },
        },
        data: function () {
            return {
                SHORT: SHORT,
                WIDE: WIDE,
                style: {
                    xs6: this.type === this.SHORT,
                    xs10: this.type === this.WIDE
                }
            }
        }
    }
</script>
<style scoped></style>