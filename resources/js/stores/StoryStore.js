import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage } from '@vueuse/core'

export const useStoryStore = defineStore('StoryStore', {
    state: () => ({
        stories: useStorage('stories', {}),
    }),
    actions: {
        get(id) {
            if (id in this.stories) {
                return this.stories[id]
            }
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
