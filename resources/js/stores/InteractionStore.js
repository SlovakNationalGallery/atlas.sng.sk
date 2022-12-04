import { useStorage } from '@vueuse/core'
import { defineStore } from 'pinia'
import { useStoryStore } from './StoryStore'

export const useInteractionStore = defineStore('InteractionStore', {
    state: () => ({
        interactions: useStorage('interactions', []),
        peekCodePanel: useStorage('peekCodePanel', false),
        cursor: useStorage('cursor', -1),
    }),
    getters: {
        active() {
            if (this.cursor > -1) {
                return this.interactions[this.cursor]
            }
        },
        activeStory() {
            if (this.active && this.active.type === 'story') {
                const storiesStore = useStoryStore()
                return storiesStore.get(this.active.id)
            }
        },
        lastStory() {
            return this.stories[this.stories.length - 1]
        },
        stories() {
            const storiesStore = useStoryStore()
            return this.interactions
                .filter((interaction) => interaction.type === 'story')
                .map((interaction) => storiesStore.get(interaction.id))
        },
    },
    actions: {
        addStory(id) {
            const length = this.interactions.push({
                type: 'story',
                id,
            })
            this.cursor = length - 1
        },
        addItemViewed(id) {
            this.interactions.push({
                type: 'itemViewed',
                id,
            })
        },
        addItemFavourited(id) {
            const lastInteraction = this.interactions[this.interactions.length - 1]
            if (lastInteraction.type === 'itemViewed' && lastInteraction.id === id) {
                this.interactions.pop()
            }

            this.interactions.push({
                type: 'itemFavourited',
                id,
            })
        },
        addSectionViewed(id) {
            this.interactions.push({
                type: 'sectionViewed',
                id,
            })
        },
        selectLink(id) {
            this.active.linkId = id
            this.cursor = -1
        },
        clear() {
            this.interactions = []
        },
    },
})
