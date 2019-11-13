import Vue from 'vue'
import App from './App.vue'
import VueResource from 'vue-resource'

import router from './router';

import './assets/main.scss'

Vue.config.productionTip = false

Vue.use(VueResource)

Vue.http.options.root = 'http://localhost:8000';

new Vue({
    el: '#app',
    router,
    render: h => h(App),
})
