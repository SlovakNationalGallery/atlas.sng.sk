require('./bootstrap')

import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import { i18nVue } from 'laravel-vue-i18n'
import { createPinia } from 'pinia'

import App from './App.vue'
import Home from './views/Home.vue'
import Detail from './views/Detail.vue'
import Collection from './views/Collection.vue'

const routes = [
    { path: '/', component: Home },
    { path: '/detail/:id', component: Detail },
    { path: '/edit/:id', component: Detail, meta: { edit: true } },
    { path: '/collection', component: Collection },
    { path: '/:id?', component: Collection },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

const getBrowserLocale = () => {
    const navigatorLocale = navigator.languages !== undefined ? navigator.languages[0] : navigator.language

    if (!navigatorLocale) {
        return undefined
    }

    const trimmedLocale = navigatorLocale.trim().split(/-|_/)[0]
    return trimmedLocale
}

const app = createApp(App)
app.use(router)
app.use(i18nVue, {
    lang: getBrowserLocale(),
    resolve: (lang) => import(`../lang/${lang}.json`),
})
app.use(createPinia())
app.mount('#app')
