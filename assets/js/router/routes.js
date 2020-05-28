import Vue from 'vue';
import VueRouter from 'vue-router';
import store from "../store/store";
import axios from '../api/common.js';

import DeckRouter from "./modules/deck";
import StudyRouter from "./modules/study";
import CardRouter from "./modules/card";

import Dashboard from "../pages/Dashboard";
import Home from "../pages/Home";
import Profile from "../pages/Profile";
import Logout from "../pages/Logout";
import Register from "../pages/Register/index";
import Login from "../pages/Login";
import NotFound from "../pages/NotFound";
import Review from "../pages/Review";
import {API_URL} from "../api/common";


Vue.use(VueRouter);

let router;
router = new VueRouter({
    mode: 'history',
    routes: [{
        path: '/register',
        name: 'Register',
        label: 'Регистрация',
        icon: 'mdi-account-multiple-plus',
        component: Register,
        menu: true,
        meta: { transitionName: 'slide' }
    }, {
        path: '/login',
        name: 'Login',
        label: 'Войти',
        icon: 'mdi-login',
        component: Login,
        menu: true,
        meta: { transitionName: 'slide' }
    }, {
        path: '/',
        name: 'Home',
        label: 'FlashBack',
        icon: 'mdi-flash',
        component: Home,
    },

    // Маршруты требующиее авторизацию

    {
        path: '/review',
        name: 'Review',
        label: 'Обзор',
        icon: 'mdi-cards-outline',
        component: Review,
        meta: {requiresAuth: true},
        menu: true
    },
    ...StudyRouter,
    ...CardRouter,
    ...DeckRouter, {
        path: '/dashboard',
        name: 'Dashboard',
        label: 'FlashBack',
        icon: 'mdi-flash',
        component: Dashboard,
        meta: {requiresAuth: true}
    },  {
        path: '/profile',
        name: 'Profile',
        label: 'Мой профиль',
        icon: 'mdi-account-circle',
        component: Profile,
        meta: {requiresAuth: true},
        menu: true,
        children: [{
            path: '/logout',
            name: 'Logout',
            label: 'Выйти',
            icon: 'mdi-logout',
            menu: true,
            component: Logout,
        }]
    }, {
        path: '/404',
        name: '404',
        component: NotFound,
    }, {
        path: '*',
        redirect: '/404'
    }
    ]
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters["isAuthenticated"]) {
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


axios.interceptors.request.use(
    config => {
        const token = store.getters['accessToken'];
        if (token) {
            config.headers['Authorization'] = 'Bearer ' + token;
        }
        return config;
    },
    error => Promise.reject(error)
);


axios.interceptors.response.use(
    (response) => { return response },
    function (error) {
        const originalRequest = error.config;

        if (error.response.status === 401 && originalRequest.url === API_URL + '/auth/token/refresh') {
            store.dispatch('logout').then(r => router.push({name: 'Login'}));
            return Promise.reject(error);
        }

        if (
            error.response.status === 401 &&
            !originalRequest._retry &&
            originalRequest.url === API_URL + '/auth/login' &&
            originalRequest.url === API_URL + '/auth/register'
        ) {
            originalRequest._retry = true;
            return store.dispatch('refreshToken')
                .then(response => {
                    if (response.status === 200) {
                        axios.defaults.headers.common['Authorization'] = 'Bearer ' + store.getters['accessToken'];
                        return axios(originalRequest);
                    }
                }).catch((error)=>{
                    store.dispatch('logout').then(r => router.push({name: 'Login'}));
                    return Promise.reject(error);
                });
        }
        return Promise.reject(error);
    }
);


export default router;