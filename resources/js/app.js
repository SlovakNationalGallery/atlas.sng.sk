require('./bootstrap');

import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import { i18nVue } from 'laravel-vue-i18n'

import App from './App.vue'
import Home from './views/Home.vue'
import Detail from './views/Detail.vue'

const routes = [
    { path: '/', component: Home },
    { path: '/detail/:id', component: Detail },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

const app = createApp(App)
app.use(router)
app.use(i18nVue, {
        resolve: lang => import(`../lang/${lang}.json`),
    })
app.mount('#app')

