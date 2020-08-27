import router from "../../Router";
import {AuthModule} from "./AuthModule";
import {AxiosError} from "axios";
import {RawLocation} from "vue-router/types/router";

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.auth)) {
        if (!AuthModule.isAuthenticated) {
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

export default router;