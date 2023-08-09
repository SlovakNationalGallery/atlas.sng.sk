import { useStorage } from '@vueuse/core'
import { defineStore } from 'pinia'
import { useStoryStore } from './StoryStore'

export const useInteractionStore = defineStore('InteractionStore', {
    state: () => ({
        interactions: useStorage('interactions', []),
        peekCodePanel: useStorage('peekCodePanel', true),
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
        viewedItemIds() {
            return new Set(
                this.interactions
                    .filter((interaction) => interaction.type === 'itemViewed')
                    .map((interaction) => interaction.id)
                    .slice()
                    .reverse()
            )
        },
        viewedItemsCount() {
            return this.viewedItemIds.size
        },
    },
    actions: {
        isItemViewed(id) {
            return this.viewedItemIds.has(id)
        },
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
        addSectionViewed(id) {
            this.interactions.push({
                type: 'sectionViewed',
                id,
            })
        },
        addPlaceViewed(id) {
            this.interactions.push({
                type: 'placeViewed',
                id,
            })
        },
        selectLink(interaction, link) {
            const index = this.interactions.indexOf(interaction)
            this.interactions[index].linkId = link.id
            this.cursor = -1
        },
        lastStoryIndex(from) {
            let index = typeof from !== 'undefined' ? from : this.cursor
            while (this.interactions[index].type !== 'story' && index > 0) {
                index--
            }
            return index
        },
        setPreviousActive(interaction) {
            const index = this.interactions.indexOf(interaction)
            this.cursor = this.lastStoryIndex(index - 1)
            this.active.linkId = undefined
            return this.active
        },
        remove(interaction) {
            const toDelete = this.interactions.indexOf(interaction)
            this.interactions.splice(toDelete, 1)
            if (toDelete <= this.cursor) {
                this.cursor = this.lastStoryIndex(this.cursor - 1)
            }
        },
        isVisited(id) {
            return this.stories.some((interaction) => interaction.id === id)
        },
        hasVisitedAllLinks(id) {
            const storyStore = useStoryStore()
            const story = storyStore.get(id)
            return story?.links.every((link) => this.isVisited(link.story_id))
        },
        clear() {
            this.interactions = []
        },
    },
})
