import { defineStore } from 'pinia';
import { useStorage } from '@vueuse/core'

export const useSurveyStore = defineStore('SurveyStore', {
    state: () => ({
        isDone: useStorage('isDone', false)
    }),
    actions: {
        done() {
            this.isDone = true
        }
    }
});