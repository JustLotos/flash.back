<template>
    <v-card color="light">
        <v-form ref="form" v-model="valid">
            <v-row justify="center" align="center" class="pa-2">
                <v-col cols="12" sm="10" offset="2">
                    <v-toolbar dense elevation="0">
<!--                        <v-app-bar-nav-icon></v-app-bar-nav-icon>-->
                        <v-toolbar-title>Настройка припоминания</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn icon v-if="decksId" >
                            <v-icon>mdi-dots-vertical</v-icon>
                        </v-btn>
                    </v-toolbar>
                </v-col>

                <v-col cols="12" sm="10">
                    <v-overflow-btn
                        v-model="deckId"
                        :items="overflowItems"
                        :rules="rules"
                        segmented
                        single-line
                        editable
                        placeholder="Выберите колоду для повторения"
                        hide-no-data
                        item-value="id"
                        item-text="name"
                    ></v-overflow-btn>
                </v-col>
            </v-row>

            <v-card-actions>
                <v-row justify="center" align="center">
                    <v-btn @click="start">
                        Учить
                    </v-btn>
                </v-row>
            </v-card-actions>
        </v-form>
    </v-card>
</template>

<script>
    import BaseLayout from "../../components/layout/BaseLayout";
    import store from "../../store/store";
    import {mapGetters} from "vuex";
    import StudySettings from "../../components/daemons/Study/StudySettings";
    export default {
        name: "Prepare",
        components: {StudySettings, BaseLayout},
        computed: {
            ...mapGetters('DeckStore', [
                'decks',
                'decksId'
            ]),
            overflowItems: function() {
                return this.decksId.map((id) => {
                    return this.decks[id];
                });
            },
        },
        data: function() {
            return {
                deckId: null,
                valid: false,
                rules: [
                    v => !!v || 'Необходимо выбрать колоду для повторения',
                ]
            }
        },
        methods: {
            async start () {
                if(this.$refs.form.validate()) {
                    await this.$router.push({name: 'train', params: {id: this.deckId}});
                }
            }
        },
        beforeRouteEnter: async function (to , from , next) {
            await store.dispatch('DeckStore/getAll').then(()=>{
                next();
            });
        }
    }
</script>

<style scoped>

</style>