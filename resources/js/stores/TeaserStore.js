import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'

export const useTeaserStore = defineStore('TeaserStore', {
    state: () => ({
        isDone: useStorage('isDone', false),
    }),
    actions: {
        done() {
            this.isDone = true
        },
    },
})
