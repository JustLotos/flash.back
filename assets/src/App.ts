import Vue from 'vue';
import ElementUI from 'element-ui';
import Vuetify from "./Plugins/Vuetify";
import i18n from "./Plugins/I18n/I18n";
import Router from "./Domain/Auth/Guard.ts";
import App from './App.vue';
import Store from "./Store.ts";
import {AppModule} from "./Domain/App/AppModule";

Vue.config.productionTip = false;
Vue.use(ElementUI, {
    size: AppModule.size,
    i18n: (key: string, value: string) => i18n.t(key, value)
})

const app =  new Vue({
    el: '#app',
    i18n: i18n,
    router: Router,
    vuetify: Vuetify,
    store: Store,
    render: h => h(App),
});
export default app;