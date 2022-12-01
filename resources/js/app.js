import './bootstrap'

import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import { i18nVue } from 'laravel-vue-i18n'
import { createPinia } from 'pinia'

import App from './App.vue'
import Collection from './views/Collection.vue'
import ItemDetail from './views/ItemDetail.vue'
import SectionDetail from './views/SectionDetail.vue'
import Story from './views/Story.vue'
import { useHistoryStore } from './stores/HistoryStore'

const routes = [
    {
        name: 'home',
        path: '/',
        component: Story,
        meta: {
            title: 'Atlas SNG',
            id: import.meta.env.VITE_DEFAULT_STORY,
        },
    },
    {
        name: 'item_detail',
        path: '/detail/:id',
        component: ItemDetail,
        meta: {
            title: 'Artwork detail',
        },
    },
    {
        name: 'section_detail',
        path: '/section/:id',
        component: SectionDetail,
        meta: {
            title: 'Section detail',
        },
    },
    {
        name: 'section_item_detail',
        path: '/section/:section_id/:id',
        component: ItemDetail,
        meta: {
            title: 'Section › Artwork detail',
        },
    },
    {
        name: 'item_edit',
        path: '/edit/:id',
        component: ItemDetail,
        meta: {
            edit: true,
            title: 'Artwork detail',
        },
    },
    {
        name: 'story',
        path: '/story/:id',
        component: Story,
        meta: {
            title: 'Story',
        },
    },
    {
        name: 'my_collection',
        path: '/collection',
        component: Collection,
        meta: {
            title: 'My collection',
        },
    },
    {
        name: 'collection_detail',
        path: '/:id?',
        component: Collection,
        meta: {
            title: 'My collection',
        },
    },
]

const history = createWebHistory()
const router = createRouter({
    history,
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

const historyStore = useHistoryStore()
historyStore.set(history)
