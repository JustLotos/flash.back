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
import DeckAdd from "../components/Deck/DeckAdd";
import DeckList from "../components/Deck/DeckList";
import DeckUpdate from "../components/Deck/DeckUpdate";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes:[
        {
            path:'/login',
            name:'Login',
            label: 'Войти',
            icon: 'mdi-login',
            component:Login,
        },
        {
            path:'/register',
            name:'Register',
            label: 'Регистрация',
            icon: 'mdi-account-multiple-plus',
            component:Register,
        },
        {
            path:'/dashboard',
            name:'Dashboard',
            label: 'FlashBack',
            icon: 'mdi-flash',
            component:Dashboard,
            meta: { requiresAuth: true }
        },
        {
            path:'/',
            name:'Home',
            label: 'FlashBack',
            icon: 'mdi-flash',
            component:Home,
        },
        {
            path:'/decks/',
            name:'Decks',
            label: 'Учить',
            icon: 'mdi-teach',
            component:Decks,
            meta: { requiresAuth: true },
            children: [
                {
                    path:'',
                    name:'deck-cget',
                    label: 'Колоды',
                    icon: 'mdi-code-array',
                    component: DeckList,
                },
                {
                    path:'add',
                    name:'deck-add',
                    label: 'Добавить',
                    icon: 'mdi-plus',
                    component: DeckAdd,
                },
                {
                    path:':id/update',
                    name:'deck-update',
                    label: 'Изменить',
                    icon: 'mdi-plus',
                    component: DeckUpdate,
                    props: true
                }
            ]
        },
        {
            path:'/profile',
            name:'Profile',
            label: 'Мой профиль',
            icon: 'mdi-account-circle',
            component:Profile,
            meta: { requiresAuth: true },
            children: [
                {
                    path:'/logout',
                    name:'Logout',
                    label: 'Выйти',
                    icon: 'mdi-logout',
                    component: Logout,
                }
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