import {RouteConfig} from "vue-router";
import DeckService from "./Deck/DeckService";

export const FlashRoutes: Array<RouteConfig> = [
    ...DeckService,
]