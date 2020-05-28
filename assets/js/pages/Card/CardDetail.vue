<template>
    <v-flex>
        <v-row justify="space-around">
            <v-col cols="12" md="10">
                <v-card :elevation="18" class="pa-12" >
                    <v-card-title>{{card.name}}</v-card-title>
                    <v-divider></v-divider>
                    <v-row>
                        <v-card-subtitle>Содержимое карточки</v-card-subtitle>
                        <v-col cols="12" v-if="this.card.records">
                            <v-card-text>Ключ</v-card-text>
                            {{this.card.records[0].content}}
                        </v-col>
                        <v-col cols="12" v-if="this.card.records">
                            <v-card-text>Значение</v-card-text>
                            {{this.card.records[1].content}}
                        </v-col>
                    </v-row>

                    <v-speed-dial v-model="fab" :direction="'left'" top right style="position: absolute" class="mt-5">
                        <template v-slot:activator>
                            <v-btn v-model="fab" elevation="0">
                                <v-icon v-if="fab">mdi-close</v-icon>
                                <v-icon v-else>mdi-dots-horizontal</v-icon>
                            </v-btn>
                        </template>
                        <v-btn class="mb-2" @click="deleteModalToggle">
                            <v-icon>mdi-delete</v-icon>
                        </v-btn >
                        <v-btn @click="editModalToggle">
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>
                        <v-btn>
<!--                            #TODO Настройки карты -->
                            <v-icon>mdi-cogs</v-icon>
                        </v-btn>
                    </v-speed-dial>
                </v-card>
            </v-col>
        </v-row>

        <v-dialog v-model="editModal" max-width="750px">
            <v-container>
                <v-layout justify-center align-center style="position: relative">
                    <card-update v-if="card.id" :id="card.id" :card="card" @card-edit="editModalToggle"></card-update>
                    <v-btn absolute top right icon dark @click="editModalToggle">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-layout>
            </v-container>
        </v-dialog>

        <v-dialog v-model="deleteModal" max-width="750px">
            <v-container>
                <v-layout justify-center align-center style="position: relative">
                    <card-delete :id="card.id"></card-delete>
                    <v-btn absolute top right icon dark @click="deleteModalToggle">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-layout>
            </v-container>
        </v-dialog>

    </v-flex>
</template>

<script>
    import store from "../../store/store";
    import CardDelete from "../../components/daemons/Card/CardDelete";
    import CardUpdate from "../../components/daemons/Card/CardUpdate";
    export default {
        name: "CardDetail",
        components: {CardUpdate, CardDelete},
        props: {
            id: {
                required: true
            }
        },
        data: function (){
            return {
                card: {},
                fab: false,
                editModal: false,
                deleteModal: false,
            }
        },
        methods: {
            setCard(card) {
                this.card = card;
            },
            editModalToggle: function () {
                this.editModal = !this.editModal;
            },
            deleteModalToggle: function () {
                this.deleteModal =  !this.deleteModal;
            },
        },
        beforeRouteEnter: async function (to , from , next) {
            await store.dispatch('CardStore/getOne', {id: to.params.id});
            let card = store.getters['CardStore/cards'][to.params.id];
            next(vm => vm.setCard(card));
        }
    }
</script>

<style scoped>

</style>