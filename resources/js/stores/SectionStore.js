import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage } from '@vueuse/core'

export const useSectionStore = defineStore('SectionStore', {
    state: () => ({
        sections: useStorage('sections', {}),
    }),
    actions: {
        get(id) {
            if (id in this.sections) {
                return this.sections[id]
            }
        },
        async load(id) {
            const response = await axios.get(`/api/sections/${id}`)
            return (this.sections[id] = response.data.data)
        },
        clearCache() {
            this.sections = {}
        },
    },
})
