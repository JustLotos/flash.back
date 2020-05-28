<template>
    <v-card>
        <v-expansion-panels v-model="panel" accordion multiple active-class="active-class">
            <v-expansion-panel>
                <v-expansion-panel-header>Panel 1</v-expansion-panel-header>
                <v-expansion-panel-content>
                    Some content
                </v-expansion-panel-content>
            </v-expansion-panel>

            <v-expansion-panel>
                <v-expansion-panel-header>Panel 2</v-expansion-panel-header>
                <v-expansion-panel-content>

                </v-expansion-panel-content>
            </v-expansion-panel>
        </v-expansion-panels>

        <!--                <v-treeview-->
        <!--                    v-model="selectDeckTreeItems"-->
        <!--                    :items="deckTreeItems"-->
        <!--                    selectable-->
        <!--                    return-object-->
        <!--                ></v-treeview>-->
    </v-card>
</template>

<script>
    export default {
        name: "ReviewFilter",
        props: [
            'decks',
            'decksId'
        ],
        data: function () {
            return {
                panel: [1, 1]
            }
        },
        methods: {
            deckTreeItems: function () {
                if(this.decksId && this.decks) {
                    let tmp = this.decksId.map((id) => {
                        return {
                            id: id,
                            name: this.decks[id].name
                        }
                    });
                    console.log(tmp);
                    return [{id: 1, name: 'Колоды', children: tmp}]

                }
                console.log([]);
                return [{id: 1, name: 1231, children: []}];
            }
        }
    }
</script>

<style scoped></style>