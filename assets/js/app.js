import Vue from 'vue';
import routes from './router/routes.js';
import vuetify from './plugins/vuetify';
import store from "./store/store.js";
import App from "./components/AppCommon/App";

const app = new Vue({
    el: '#app',
    router: routes,
    vuetify: vuetify,
    store: store,
    render: h => h(App),
});

export default app;