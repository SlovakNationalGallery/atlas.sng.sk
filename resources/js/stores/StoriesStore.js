import { useStorage } from '@vueuse/core'
import { defineStore } from 'pinia'

export const useStoriesStore = defineStore('StoriesStore', {
    state: () => ({
        stories: useStorage('stories', []),
        selectedLinkIds: useStorage('selectedLinkIds', []),
        peekCodePanel: useStorage('peekCodePanel', true),
    }),
    actions: {
        addStory(story) {
            this.stories.push(story)
        },
        selectLink(link) {
            this.selectedLinkIds.push(link.id)
        },
    },
})
