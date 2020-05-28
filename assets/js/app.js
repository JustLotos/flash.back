import Vue from 'vue';
import routes from './router/routes.js';
import vuetify from './plugins/vuetify';
import store from "./store/store.js";
import App from "./App";
import VueI18n from 'vue-i18n'

Vue.use(VueI18n);
Vue.use(vuetify);

export default new Vue({
    el: '#app',
    router: routes,
    vuetify: vuetify,
    store: store,
    VueI18n: VueI18n,
    render: h => h(App),
});