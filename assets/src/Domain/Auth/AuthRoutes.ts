import {RouteConfig} from "vue-router";
import BaseLayout from "../App/Layouts/BaseLayout.vue";
import RegisterPage from "./Pages/RegisterPage.vue";
import LogoutPage from "./Pages/Logout.vue";
import LoginPage from "./Pages/LoginPage.vue";
import ResetPasswordPage from "./Pages/ResetPasswordPage.vue";

export const AuthRoutes: Array<RouteConfig> = [
    {
        path: '/login', name: 'Login', component: LoginPage,
        meta: { label: 'Войти', icon: 'mdi-login', menu: true, auth: false, layout: BaseLayout}
    },
    {
        path: '/register', name: 'Register', component: RegisterPage,
        meta: { label: 'Регистрация', icon: 'mdi-account-multiple-plus', menu: true, auth: false, layout: BaseLayout}
    },
    {
        path: '/logout', name: 'Logout', component: LogoutPage,
        meta: { label: 'Выйти', icon: 'mdi-logout', menu: true, auth: true, layout: BaseLayout},
    },
    {
        path: '/reset/password', name: 'ResetPassword', component: ResetPasswordPage,
        meta: { label: 'Восстановить пароль', icon: 'mdi-logout', menu: false, auth: false, layout: BaseLayout},
    },
];