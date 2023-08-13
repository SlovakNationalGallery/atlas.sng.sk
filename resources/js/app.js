import './bootstrap'

import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import { i18nVue } from 'laravel-vue-i18n'
import { createPinia } from 'pinia'
import * as Sentry from '@sentry/vue'

import App from './App.vue'
import Collection from './views/Collection.vue'
import Interaction from './views/Interaction.vue'
import ItemDetail from './views/ItemDetail.vue'
import SectionDetail from './views/SectionDetail.vue'
import PlaceDetail from './views/PlaceDetail.vue'
import RewardDetail from './views/RewardDetail.vue'
import LockedItemDetail from './views/LockedItemDetail.vue'
import { useHistoryStore } from './stores/HistoryStore'
import { useLocaleStore } from './stores/LocaleStore'

const routes = [
    {
        name: 'home',
        path: '/',
        component: Interaction,
        meta: {
            title: 'Atlas SNG',
        },
    },
    {
        name: 'locked_item_detail',
        path: '/locked_item_detail/:id',
        component: LockedItemDetail,
        meta: {
            title: 'Locked artwork detail'
        }
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
        path: '/group/:id',
        component: SectionDetail,
        meta: {
            title: 'Artwork group detail',
        },
    },
    {
        name: 'section_item_detail',
        path: '/group/:section_id/:id',
        component: ItemDetail,
        meta: {
            title: 'Group › Artwork detail',
        },
    },
    {
        name: 'story',
        path: '/story/:id',
        component: Interaction,
        meta: {
            title: 'Story',
        },
    },
    {
        name: 'my_collection',
        path: '/collection',
        component: Collection,
        meta: {
            title: 'My timeline',
        },
    },
    {
        name: 'collection_detail',
        path: '/:id?',
        component: Collection,
        meta: {
            title: 'My timeline',
        },
    },
    {
        name: 'place_detail',
        path: '/place/:id',
        component: PlaceDetail,
        meta: {
            title: 'Place detail',
        },
    },
    {
        name: 'reward_detail',
        path: '/reward/:id',
        component: RewardDetail,
    },
]

const history = createWebHistory()
const router = createRouter({
    history,
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (to.name === 'home') {
            return savedPosition
        }
        return { top: 0 }
    },
})

const app = createApp(App)

Sentry.init({ app, dsn: import.meta.env.VITE_SENTRY_DSN })

app.use(router)
app.use(createPinia())

const localeStore = useLocaleStore()
app.use(i18nVue, {
    lang: localeStore.locale,
    resolve: (lang) => import(`../lang/${lang}.json`),
})

const historyStore = useHistoryStore()
historyStore.set(history)

app.mount('#app')
