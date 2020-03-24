import Vue from 'vue';
import VueRouter from 'vue-router';
import store from "../store/store";

import Login from "../views/Auth/Login";
import Logout from "../views/Auth/Logout";
import Register from "../views/Auth/Register";

import Home from "../views/pages/Home";
import Dashboard from "../views/pages/Dashboard";
import Profile from "../views/pages/Profile";
import Decks from "../views/pages/Decks";
import Deck from "../views/pages/Deck";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes:[
        // #TODO здесь должны быть только views
        { path:'/login',        name:'Login',       component:Login },
        { path:'/logout',       name:'Logout',      component:Logout },
        { path:'/register',     name:'Register',    component:Register },
        { path:'/',             name:'Home',        component:Home },
        { path:'/dashboard',    name:'Dashboard',   component:Dashboard,    meta: { requiresAuth: true } },
        { path:'/profile',      name:'Profile',     component:Profile,      meta: { requiresAuth: true } },
        {
            path:'/decks',
            name:'Decks',
            component:Decks,
            meta: { requiresAuth: true },
            children: [
                { path: '/:id', name:'Deck', component: Deck }
            ]
        },
    ]
});

// Guard for auth
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters["UserStore/isAuthenticated"]) {
            next();
        } else {
            next({
                name: "Login",
                query: { redirect: to.fullPath }
            });
        }
    } else {
        next();
    }
});

export default router;