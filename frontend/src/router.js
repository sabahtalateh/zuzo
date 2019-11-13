import Vue from 'vue'
import Router from 'vue-router'

import About from './views/About'
import Home from './views/Home'
import Catalogue from './views/Catalogue'

Vue.use(Router)

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: Home
        },
        {
            path: '/about',
            component: About
        },
        {
            path: '/catalogue',
            component: Catalogue
        }
    ]
})
