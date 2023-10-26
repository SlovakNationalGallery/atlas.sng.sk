import { getActiveLanguage } from 'laravel-vue-i18n'
import axios from 'axios'

window.axios = axios

window.axios.defaults.headers['X-Requested-With'] = 'XMLHttpRequest'
window.axios.interceptors.request.use((config) => {
    config.headers['X-locale'] = getActiveLanguage()
    return config
})
