import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useStoriesStore = defineStore('StoriesStore', {
    state: () => ({
        stories: ref([]),
        selectedLinks: ref([]),
        active: ref(null),
        peekCodePanel: ref(true),
    }),
    actions: {
        addStory(story) {
            this.stories.push(story)
            this.active = story
        },
        selectLink(link) {
            this.selectedLinks.push(link)
            this.active = null
        },
    },
})
