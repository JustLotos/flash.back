import router from "../../Router";
import {AuthModule} from "./AuthModule";

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.auth)) {
        if (!AuthModule.isAuthenticated) {
            next({name: "Login", query: { redirect: to.fullPath }});
        }
    }
    next();
});

export default router;