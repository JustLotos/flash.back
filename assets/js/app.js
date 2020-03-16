import Vue from 'vue';
import Routes from './routes.js';
import App from './components/Shared/App';
import vuetify from './plugins/vuetify';

const app = new Vue({
    el: '#app',
    router: Routes,
    vuetify: vuetify,
    render: h => h(App),
});

export default app;