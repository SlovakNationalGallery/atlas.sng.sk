import { createApp } from 'vue'
import { i18nVue } from 'laravel-vue-i18n'

import App from './App.vue'

const app = createApp(App)
app.use(i18nVue, {
        resolve: lang => import(`../lang/${lang}.json`),
    })
app.mount('#app')

require('./bootstrap');
