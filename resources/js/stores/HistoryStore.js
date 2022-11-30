import { defineStore } from 'pinia'

export const useHistoryStore = defineStore('HistoryStore', {
    state: () => ({
        history: null,
    }),
    actions: {
        set(history) {
            this.history = history
        },
        getState() {
            return this.history?.state
        },
    },
})
