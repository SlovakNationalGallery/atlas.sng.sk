import { useStorage } from '@vueuse/core'
import { defineStore } from 'pinia'
import { useItemStore } from './ItemStore'
import { useSectionStore } from './SectionStore'
import { useStoryStore } from './StoryStore'

export const useInteractionStore = defineStore('InteractionStore', {
    state: () => ({
        interactions: useStorage('interactions', []),
        activeStoryId: useStorage('activeStoryId', null),
        peekCodePanel: useStorage('peekCodePanel', false),
    }),
    getters: {
        interactionsWithData() {
            const stores = {
                story: useStoryStore(),
                itemViewed: useItemStore(),
                itemFavourited: useItemStore(),
                sectionViewed: useSectionStore(),
            }

            return this.interactions.map((interaction) => {
                const data = stores[interaction.type].get(interaction.id)
                return { ...interaction, data }
            })
        },
        activeStory() {
            const storiesStore = useStoryStore()
            return storiesStore.get(this.activeStoryId)
        },
        lastInteractionStory() {
            return this.interactionStories[this.interactionStories.length - 1]
        },
        interactionStories() {
            const storiesStore = useStoryStore()
            return this.interactions
                .filter((interaction) => interaction.type === 'story')
                .map((interaction) => storiesStore.get(interaction.id))
        },
    },
    actions: {
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
        selectLink(link) {
            this.interactions.push({
                type: 'story',
                id: this.activeStoryId,
                linkId: link.id,
            })
            this.activeStoryId = null
        },
        clear() {
            this.interactions = []
        },
    },
})
