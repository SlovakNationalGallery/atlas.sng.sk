import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage } from '@vueuse/core'

export const useStoryStore = defineStore('StoryStore', {
    state: () => ({
        stories: useStorage('stories', {}),
    }),
    actions: {
        get(id) {
            if (this.has(id)) {
                return this.stories[id]
            }
        },
        has(id) {
            return id in this.stories
        },
        async load(id) {
            const response = await axios.get(`/api/stories/${id}`)
            return (this.stories[id] = response.data.data)
        },
        clearCache() {
            this.stories = {}
        },
    },
})
