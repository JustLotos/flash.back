<template>
    <v-flex v-if="itemsId && itemsId.length">
<!--        <v-text-field-->
<!--            v-if="filter"-->
<!--            v-model="term"-->
<!--            prepend-inner-icon="mdi-magnify"-->
<!--            label="Поиск"-->
<!--        ></v-text-field>-->

        <v-list class="pa0 m-0">
            <v-list-item v-for="id in page" :key="id" class="pa-0">
                <slot name="item" :item="items[id]"></slot>
            </v-list-item>
        </v-list>

        <v-pagination
                v-if="pagination && !!countPages"
                v-model="currentPage"
                :length="countPages"
                :total-visible="buttonsCount"
                prev-icon="mdi-menu-left"
                next-icon="mdi-menu-right"
        ></v-pagination>
    </v-flex>
    <v-flex v-else>
        <v-row justify="center">
            <v-col cols="12">
                <slot name="empty">
                    Элементов нет
                </slot>
            </v-col>
        </v-row>
    </v-flex>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";

@Component
export default class ListObjects extends Vue{
    currentPage: number = 1

    @Prop()
    items;

    @Prop()
    itemsId;

    @Prop()
    pagination

    get page() {
        if(!this.pagination) {
            return this.itemsId;
        }
        if(this.itemsId && this.itemsId.length > 0) {
            return this.itemsId.slice((this.currentPage - 1) * this.perPage, this.currentPage * this.perPage);
        }
        return [];
    }
    get countPages() {
        if(this.itemsId && this.itemsId.length > this.perPage) {
            return Math.ceil(this.itemsId.length/this.perPage);
        }
        return 0;
    }
    get perPage() {
        if(this.pagination && this.pagination.perPage) {
            return this.pagination.perPage;
        }
        return 10;
    }

    get buttonsCount () {
        if(this.pagination && this.pagination.buttonsCount) {
            return this.pagination.buttonsCount;
        }
        return 9;
    }
}
</script>