<template>
    <v-container>
        <v-layout>
            <v-flex xs12>
                <v-form
                        ref="form"
                        v-model="valid"
                >
                    <v-card>
                        <v-flex xs10 offset-xs1>
                            <v-card-title primary-title class="justify-center">Добавление новой колоды</v-card-title>
                            <v-card-text>
                                <v-text-field
                                        autofocus
                                        v-model="name.value"
                                        :rules="name.rules"
                                        label="Название"
                                        required
                                        validate-on-blur
                                        class="centered-input"
                                ></v-text-field>
                            </v-card-text>

                            <v-card-text>
                                <v-textarea
                                        v-model="description.value"
                                        label="Описание"
                                        hint="Это поле не обязательно для заполнения"
                                        class="centered-input"
                                        auto-grow
                                        :rows="1"
                                        :row-height="24"
                                ></v-textarea>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="submitForm">Добавить</v-btn>
                            </v-card-actions>
                        </v-flex>
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
    .centered-input >>> input {
        text-align: center
    }
</style>