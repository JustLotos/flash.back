import router from "../App/Router";
import {AxiosError} from "axios";
import {RawLocation} from "vue-router/types/router";
import {UserModule} from "./UserModule";

router.beforeEach((to, from, next) => {
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
        return router.push(route);
    }
}

export const Router = router;