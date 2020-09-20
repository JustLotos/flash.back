import Router from "../App/Router";
import {AxiosError} from "axios";
import {RawLocation} from "vue-router/types/router";
import {UserModule} from "./UserModule";

Router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.auth)) {
        if (!UserModule.isAuthenticated) {
            next({name: "Login", query: { redirect: to.fullPath }});
        }
    }
    next();
});

export function handle404Exception(error: AxiosError, route: RawLocation) {
    if( error.response?.status == 404) {
        console.log(error.response.data);
        return Router.push(route);
    }
}

export const router = Router;