import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from '../components/Home';
import DeckList from "../components/Deck/DeckList";
import Login from "../components/Auth/Login/Login";
import Register from "../components/Auth/Register/Register";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes:[
        { path:'/',             name:'home',        component:Home },
        { path:'/login',        name:'login',       component:Login },
        { path:'/register',     name:'register',    component:Register },
        { path:'/deck/list',    name:'deckList',    component:DeckList, meta: { requiresAuth: true } },
    ]
});

// router.beforeEach((to, from, next) => {
//     if (to.matched.some(record => record.meta.requiresAuth)) {
//         // this route requires auth, check if logged in
//         // if not, redirect to login page.
//         if (store.getters["security/isAuthenticated"]) {
//             next();
//         } else {
//             next({
//                 path: "/login",
//                 query: { redirect: to.fullPath }
//             });
//         }
//     } else {
//         next(); // make sure to always call next()!
//     }
// });

export default router;