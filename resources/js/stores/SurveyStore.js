import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'

export const useSurveyStore = defineStore('SurveyStore', {
    state: () => ({
        isDone: useStorage('isSurveyDone', false),
    }),
    actions: {
        done() {
            this.isDone = true
        },
    },
})
