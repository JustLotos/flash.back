import Vue from 'vue';
import ElementUI from 'element-ui';
import {VuetifyCustom} from "./Plugins/Vuetify";
import i18n from "./Plugins/I18n/I18n";
import {Router} from "./Domain/User/Guard.ts";
import App from './App.vue';
import {Store} from "./Domain/App/Store.ts";
import {AppModule} from "./Domain/App/AppModule";
import {RouterApi} from "./Domain/App/RouterAPI";

Vue.config.productionTip = false;
Vue.use(ElementUI, {
    size: AppModule.size,
    i18n: (key: string, value: string) => i18n.t(key, value)
})

const app =  new Vue({
    el: '#app',
    i18n: i18n,
    router: Router,
    routerApi: RouterApi,
    vuetify: VuetifyCustom,
    store: Store,
    render: h => h(App),
});

export default app;