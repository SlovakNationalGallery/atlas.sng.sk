const { getActiveLanguage } = require('laravel-vue-i18n')

window.axios = require('axios')

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.axios.interceptors.request.use((config) => {
    config.headers.common['X-locale'] = getActiveLanguage()
    return config
})
