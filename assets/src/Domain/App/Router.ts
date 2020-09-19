import Vue from "vue";
import Router, {RouteConfig} from 'vue-router'
import {AppRoutes} from "./AppRoutes";
import {UserRoutes} from "../User/UserRoutes";

Vue.use(Router);

export const routes: Array<RouteConfig> = [
    ...AppRoutes,
    ...UserRoutes,
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


