import {RouteConfig} from "vue-router";
import BaseLayout from "../App/Layouts/BaseLayout.vue";
import CardDetailPage from "./Pages/Card/CardDetailPage.vue";
import ReviewPage from "./Pages/Card/ReviewPage.vue";
import DecksPage from "./Pages/Deck/DecksPage.vue";
import DeckPage from "./Pages/Deck/DeckPage.vue";
import ProfilePage from "./Pages/Learner/ProfilePage.vue";
import PreparePage from "./Pages/Repeat/PreparePage.vue";
import RepeatPage from "./Pages/Repeat/RepeatPage.vue";

export const FlashRoutes: Array<RouteConfig> = [
    {
        path: '/profile', name: 'Profile', component: ProfilePage,
        meta: { auth: true, menu: true, layout: BaseLayout, icon: 'mdi-account-circle', label: 'Мой профиль'},
    },
    // {
    //     path:'/decks', name: 'Decks', component: DecksPage,
    //     meta: { auth: true, menu: true, layout: BaseLayout, icon: 'mdi-folder', label: 'Колоды', },
    // },
    // {
    //     path:'/deck/:id', name: 'Deck', component: DeckPage, props: true,
    //     meta: { auth: true, menu: false, layout: BaseLayout },
    // },
    // {
    //     path: '/card/:id', name: 'Card', component: CardDetailPage, props: true,
    //     meta: { auth: true, menu: false, layout: BaseLayout },
    // },
    // {
    //     path: '/review', name: 'Review', component: ReviewPage,
    //     meta: {  auth: true, menu: true, layout: BaseLayout, icon: 'mdi-cards-outline', label: 'Обзор' },
    // },
    // {
    //     path: '/study', name: 'prepare', component: PreparePage,
    //     meta: {  auth: true, menu: true, layout: BaseLayout, icon: 'mdi-teach', label: 'Настройка' },
    // },
    // {
    //     path: '/study/:id', name: 'train', component: RepeatPage, props: true,
    //     meta: {  auth: true, menu: true, layout: BaseLayout, icon: 'mdi-teach', label: 'Повторение' },
    // },
]