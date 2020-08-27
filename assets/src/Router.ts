import Vue from "vue";
import Router, {RouteConfig} from 'vue-router'
import {AppRoutes} from "./Domain/App/AppRoutes";
import {AuthRoutes} from "./Domain/Auth/AuthRoutes";
import {FlashRoutes} from "./Domain/Flash/FlashRoutes";

Vue.use(Router);

export const routes: Array<RouteConfig> = [
    ...AppRoutes,
    ...FlashRoutes,
    ...AuthRoutes,
    {
        path: '*', redirect: '/',
        meta: { menu: false, auth: false }
    }
];

export default new Router({
    mode: 'history',
    base: process.env.APP_HOST,
    routes: routes
});


