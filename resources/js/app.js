require('./bootstrap')

import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import { i18nVue } from 'laravel-vue-i18n'
import { createPinia } from 'pinia'

import App from './App.vue'
import Collection from './views/Collection.vue'
import Home from './views/Home.vue'
import ItemDetail from './views/ItemDetail.vue'
import SectionDetail from './views/SectionDetail.vue'
import Story from './views/Story.vue'
import { HEADER_CODES } from './consts'

const routes = [
    {
        name: 'home',
        path: '/',
        component: Home,
        meta: {
            code: HEADER_CODES.NONE,
            title: 'SNG Codes',
        },
    },
    {
        name: 'item_detail',
        path: '/detail/:id',
        component: ItemDetail,
        meta: {
            code: HEADER_CODES.ITEM,
            title: 'Artwork detail',
        },
    },
    {
        name: 'section_detail',
        path: '/section/:id',
        component: SectionDetail,
        meta: {
            code: HEADER_CODES.ITEM,
            title: 'Detail zbierky',
        },
    },
    {
        name: 'section_item_detail',
        path: '/section/:section_id/:id',
        component: ItemDetail,
        meta: {
            code: HEADER_CODES.ITEM,
            title: 'Detail diela zbierky',
            back: (from) => ({
                name: 'section_detail',
                params: { id: from.params.section_id },
            }),
        },
    },
    {
        name: 'item_edit',
        path: '/edit/:id',
        component: ItemDetail,
        meta: {
            edit: true,
            code: HEADER_CODES.NONE,
            title: 'Artwork detail',
        },
    },
    {
        name: 'story',
        path: '/story/:id?',
        component: Story,
        meta: {
            title: 'Story',
            id: process.env.MIX_DEFAULT_STORY,
        },
    },
    {
        name: 'my_collection',
        path: '/collection',
        component: Collection,
        meta: {
            code: HEADER_CODES.FULL,
            title: 'My collection',
        },
    },
    {
        name: 'collection_detail',
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
