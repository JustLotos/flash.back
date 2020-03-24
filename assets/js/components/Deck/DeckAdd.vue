<template>
    <v-container>
        <v-layout>
            <v-flex xs12>
                <v-form
                        ref="form"
                        v-model="valid"
                >
                    <v-card>
                        <v-card-title>Добавление новой колоды</v-card-title>
                        <v-card-text>
                            <v-text-field
                                    v-model="name.value"
                                    :rules="name.rules"
                                    label="Название"
                                    required
                            ></v-text-field>
                        </v-card-text>

                        <v-card-text>
                            <v-text-field
                                    v-model="description.value"
                                    label="Описание"
                                    required
                            ></v-text-field>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="submitForm">Добавить</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-form>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        name: "DeckAdd",
        data: function () {
            return {
                valid: false,
                name: {
                    value: '',
                    rules: [
                        v => !!v || 'Имя обязательно для колоды',
                    ]
                },
                description: {
                    value: '',
                },
            }
        },
        methods: {
            submitForm: function () {
                //#TODO Логика валидации и отправки формы
                this.$emit('close-dialog');
            }
        }
    }
</script>

<style scoped>

</style>