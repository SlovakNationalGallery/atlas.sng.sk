<template>
    <div class="grow bg-black px-4 pb-bar text-lg text-white">
        <template v-for="(interaction, i) in interactionStore.interactions" :key="i">
            <InteractionStory
                :ref="(component) => setStoryRef(component, interaction)"
                v-if="interaction.type === 'story'"
                :story="storyStore.get(interaction.id)"
                :linkId="interaction.linkId"
                :active="interaction === interactionStore.active"
                :first="i === 0"
                @navigate="(link) => navigate(interaction, link)"
                @undo="undo"
                class="my-8"
            />
            <InteractionItemFavourited
                v-else-if="interaction.type === 'itemFavourited'"
                :item="itemStore.get(interaction.id)"
                class="my-4"
            />
            <InteractionItemViewed
                v-else-if="interaction.type === 'itemViewed'"
                :item="itemStore.get(interaction.id)"
                class="my-4"
            />
            <InteractionSectionViewed
                v-else-if="interaction.type === 'sectionViewed'"
                :section="sectionStore.get(interaction.id)"
                class="my-4"
            />
        </template>
    </div>

    <CodePanel />
</template>

<script setup>
import { nextTick, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import CodePanel from '../components/CodePanel.vue'
import InteractionItemFavourited from '../components/InteractionItemFavourited.vue'
import InteractionItemViewed from '../components/InteractionItemViewed.vue'
import InteractionSectionViewed from '../components/InteractionSectionViewed.vue'
import InteractionStory from '../components/InteractionStory.vue'
import { useInteractionStore } from '../stores/InteractionStore'
import { useItemStore } from '../stores/ItemStore'
import { useSectionStore } from '../stores/SectionStore'
import { useStoryStore } from '../stores/StoryStore'

const interactionStore = useInteractionStore()
const itemStore = useItemStore()
const sectionStore = useSectionStore()
const storyStore = useStoryStore()
const route = useRoute()
const storyMap = new Map()

const navigate = (interaction, link) => {
    interactionStore.selectLink(interaction, link)
    loadStory(link.story_id)
}

const undo = () => {
    const current = interactionStore.active
    const previous = interactionStore.setPreviousActive(current)
    nextTick(() => {
        storyMap.get(previous).scrollIntoView({
            behavior: 'smooth',
            block: 'end',
        })
    })
    setTimeout(() => {
        interactionStore.remove(current)
    }, 600)
}

const setStoryRef = (component, interaction) => {
    if (component.$el) {
        storyMap.set(interaction, component.$el)
    }
}

const scrollActiveIntoView = () => {
    const el = document.querySelector('#active-story')

    if (el) {
        el.scrollIntoView({
            behavior: 'smooth',
            block: 'start',
        })
    }
}

const loadStory = async (id) => {
    const story = storyStore.get(id) || (await storyStore.load(id))
    interactionStore.addStory(story.id)
    nextTick(scrollActiveIntoView)
}

onMounted(async () => {
    if (route.params.id) {
        interactionStore.clear()
        loadStory(route.params.id)
    } else if (!interactionStore.activeStory) {
        loadStory(interactionStore.lastStory?.id || import.meta.env.VITE_DEFAULT_STORY)
    }

    nextTick(scrollActiveIntoView)
})
</script>
