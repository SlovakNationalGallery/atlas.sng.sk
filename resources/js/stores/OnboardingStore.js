import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'

export const useOnboardingStore = defineStore('OnboardingStore', {
    state: () => ({
        isDone: useStorage('isDone', false),
    }),
    actions: {
        done() {
            this.isDone = true
        },
    },
})
