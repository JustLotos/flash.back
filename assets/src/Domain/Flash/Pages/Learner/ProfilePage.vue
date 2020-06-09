<template>
    <v-container>
        <v-card>
            <v-layout justify-center>
                <v-flex>
                    <v-row>
                        <v-col cols="4">
                            <v-card-actions class="justify-center pa-2">
                                <v-avatar class="profile" color="grey" size="164" tile>
                                    <v-img src="https://cdn.vuetifyjs.com/images/profiles/marcus.jpg"></v-img>
                                </v-avatar>
                            </v-card-actions>
                        </v-col>
                        <v-col cols="8" style="width: 400px">
                            <v-flex>
                                <v-row class="no-gutters">
                                    <v-col cols="24">
                                        <v-card-text class="pa-2" >{{user.role}}</v-card-text >
                                    </v-col>
                                    <v-col cols="24">
                                        <v-card-text class="pa-2">{{user.name.first}} {{user.name.last}}</v-card-text >
                                    </v-col>
                                </v-row>
                                <v-row class="no-gutters">
                                    <v-col cols="24" lg12>
                                        <v-card-text class="pa-2">Электронная почта</v-card-text>
                                    </v-col>
                                    <v-col cols="24" lg12>
                                        <v-card-text class="pa-2">{{user.email}}</v-card-text>
                                    </v-col>
                                </v-row>
                                <v-divider></v-divider>
                                <v-row class="no-gutters">
                                    <v-col cols="24">
                                        <v-card-text class="pa-2">Статус</v-card-text >
                                    </v-col>
                                    <v-col cols="24">
                                        <v-card-text class="pa-2">{{user.status}}</v-card-text >
                                    </v-col>
                                </v-row>
                            </v-flex>
                        </v-col>
                    </v-row>
                </v-flex>
            </v-layout>
        </v-card>
    </v-container>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import { LearnerModule } from "../../Modules/LearnerModule";
import {AuthModule} from "../../../Auth/AuthModule";
import {IProfile} from "../../types";

@Component
export default class ProfilePage extends Vue{
    get user(): IProfile {
        return {
            name: LearnerModule.getName,
            email: AuthModule.getEmail,
            status: AuthModule.getStatus,
            role: AuthModule.getRole
        }
    }

    beforeRouteEnter(to , from , next) {
        if(!LearnerModule.isUploaded) {
            LearnerModule.getProfile()
                .then(next())
                .catch((error)=>{ console.log("Ошибка извлечения пользователя" + JSON.stringify(error))});
        } else {
            next();
        }
    }
}
</script>