import { defineStore } from 'pinia'
import { getActiveLanguage } from 'laravel-vue-i18n'
import { useStorage } from '@vueuse/core'

export const useDetailStore = defineStore('DetailStore', {
    state: () => ({
        item: useStorage('item', null),
    }),
    actions: {
        async addItem(itemId) {
            const response = await axios.get(`/api/items/${itemId}`)
            const item = response.data.data
            this.item = item
            return item
        },
    },
})
