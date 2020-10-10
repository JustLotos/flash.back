import {RouteConfig} from "vue-router";
import DeckPage from "./Pages/DeckPage.vue";
import DecksPage from "./Pages/DecksPage.vue";
import BaseLayout from "../../App/Layouts/BaseLayout.vue";

export const FlashRoutes: Array<RouteConfig> = [
{
    path:'/deck/:id', name: 'Deck', component: DeckPage, props: true,
    meta: { auth: true, menu: false, layout: BaseLayout },
},
{
    path:'/decks', name: 'Decks', component: DecksPage,
    meta: { auth: true, menu: true, layout: BaseLayout, icon: 'mdi-folder', label: 'Коллекция' },
}
]


