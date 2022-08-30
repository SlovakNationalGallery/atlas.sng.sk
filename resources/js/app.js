require('./bootstrap')

import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import { i18nVue } from 'laravel-vue-i18n'
import { createPinia } from 'pinia'

import App from './App.vue'
import Home from './views/Home.vue'
import Detail from './views/Detail.vue'
import Collection from './views/Collection.vue'
import { HEADER_CODES } from './consts'

const routes = [
    {
        path: '/',
        component: Home,
        meta: {
            code: HEADER_CODES.NONE,
            title: 'SNG Codes',
        },
    },
    {
        path: '/detail/:id',
        component: Detail,
        meta: {
            code: HEADER_CODES.ITEM,
            title: 'Artwork detail',
        },
    },
    {
        path: '/edit/:id',
        component: Detail,
        meta: {
            edit: true,
            code: HEADER_CODES.NONE,
            title: 'Artwork detail',
        },
    },
    {
        path: '/collection',
        component: Collection,
        meta: {
            code: HEADER_CODES.FULL,
            title: 'My collection',
        },
    },
    {
        path: '/:id?',
        component: Collection,
        meta: {
            code: HEADER_CODES.FULL,
            title: 'My collection',
        },
    },
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
