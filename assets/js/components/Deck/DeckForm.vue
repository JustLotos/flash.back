<template>
    <v-flex xs12 lg10 class="justify-center">
        <v-form ref="form" v-model="valid">
            <v-card>
                <v-flex xs6 offset-xs3 lg6 offset-lg3 >
                    <v-card-title primary-title class="justify-center">{{ form.title }}</v-card-title>
                    <v-card-text>
                        <v-text-field
                                autofocus
                                v-model="deck.name"
                                :rules="name.rules"
                                label="Название"
                                required
                                validate-on-blur
                                class="centered-input"
                        ></v-text-field>
                    </v-card-text>

                    <v-card-text>
                        <v-textarea
                                v-model="deck.description"
                                label="Описание"
                                hint="Это поле не обязательно для заполнения"
                                class="centered-input"
                                auto-grow
                                :rows="1"
                                :row-height="24"
                        ></v-textarea>
                    </v-card-text>

                    <v-card-actions class="justify-center">
                        <v-btn color="primary" @click="submitForm">{{ form.actionName }}</v-btn>
                    </v-card-actions>
                </v-flex>
            </v-card>
        </v-form>
    </v-flex>
</template>

<script>
    export default {
        name: "DeckForm",
        props: {
            form: {
              name: String,
              title: String,
              actionName: String,
              eventName: String,
            },
            deck: {
                name: String,
                description: String
            }
        },
        data: function () {
            return {
                valid: false,
                name: {
                    rules: [
                        v => !!v || 'Имя обязательно для колоды',
                    ]
                },
            }
        },
        methods: {
            submitForm: function () {
                this.$emit(this.form.eventName, this.deck);
            }
        }
    }
</script>

<style scoped>

</style>