import { getActiveLanguage } from 'laravel-vue-i18n'
import axios from 'axios'

window.axios = axios

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.axios.interceptors.request.use((config) => {
    config.headers.common['X-locale'] = getActiveLanguage()
    return config
})
