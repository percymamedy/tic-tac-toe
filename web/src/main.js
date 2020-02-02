import Vue from 'vue';
import App from './App.vue';
import store from './store';
import router from './router';
import i18n from './plugins/i18n';

import './plugins';
import './assets/css/app.css';

Vue.config.productionTip = false;

new Vue({
    render: h => h(App),
    router,
    i18n,
    store
}).$mount('#app');
