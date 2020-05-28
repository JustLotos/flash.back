<template>
    <v-hover v-slot:default="{ hover }">
        <div class="position-relative">
            <v-fade-transition>
                <v-btn
                    v-if="hover"
                    class="position-absolute"
                    mode=""
                    color="primary"
                    transition
                    dark large absolute bottom left fab
                    @click="redirect"
                >
                    <v-icon>mdi-menu-left</v-icon>
                </v-btn>
            </v-fade-transition>
        </div>
    </v-hover>
</template>

<script>
    export default {
        name: "BackButton",
        props: ['route'],
        methods: {
            redirect: function () {
                this.$router.go(-1);
            }
        }
    }
</script>

<style scoped>
    .position-relative{
        position: fixed;
        top: 50%;
        height: 300px;
        width: 200px;
        border-radius: 50%;
        margin-left: 30px;
        margin-top: -150px;
        z-index: 999;
    }
    .position-absolute{
        position: absolute;
        top: 0;
        margin-top: 110px;
        margin-left: -150px;
        left: 100%;
    }
</style>