<template>
    <div class="bg-black grow px-4 pb-bar space-y-4 text-base text-white">
        <template v-for="(interaction, i) in interactionStore.interactionsWithData" :key="i">
            <InteractionStory
                v-if="interaction.type === 'story'"
                :story="interaction.data"
                :linkId="interaction.linkId"
                :active="false"
                class="my-4"
            />
            <InteractionItemFavourited
                v-else-if="interaction.type === 'itemFavourited'"
                :item="interaction.data"
                class="my-4"
            />
            <InteractionItemViewed
                v-else-if="interaction.type === 'itemViewed'"
                :item="interaction.data"
                class="my-4"
            />
            <InteractionSectionViewed
                v-else-if="interaction.type === 'sectionViewed'"
                :section="interaction.data"
                class="my-4"
            />
        </template>
        <InteractionStory
            ref="activeStoryRef"
            v-if="interactionStore.activeStory"
            :story="interactionStore.activeStory"
            :active="true"
            @navigate="navigate"
            class="my-4"
        />
    </div>

    <CodePanel />
</template>

<script setup>
import { nextTick, onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import CodePanel from '../components/CodePanel.vue'
import InteractionItemFavourited from '../components/InteractionItemFavourited.vue'
import InteractionItemViewed from '../components/InteractionItemViewed.vue'
import InteractionSectionViewed from '../components/InteractionSectionViewed.vue'
import InteractionStory from '../components/InteractionStory.vue'
import { useInteractionStore } from '../stores/InteractionStore'
import { useStoryStore } from '../stores/StoryStore'

const interactionStore = useInteractionStore()
const storyStore = useStoryStore()
const route = useRoute()
const activeStoryRef = ref(null)

const navigate = (link) => {
    interactionStore.selectLink(link)
    loadStory(link.story_id)
}

const scrollActiveIntoView = () => {
    if (activeStoryRef.value) {
        activeStoryRef.value.$el.scrollIntoView({
            behavior: 'smooth',
            block: 'start',
        })
    }
}

const loadStory = async (id) => {
    storyStore.get(id) || (await storyStore.load(id))
    interactionStore.activeStoryId = id
    nextTick(scrollActiveIntoView)
}

onMounted(async () => {
    if (!interactionStore.activeStory && interactionStore.lastInteractionStory) {
        loadStory(interactionStore.lastInteractionStory)
    } else if (!interactionStore.activeStory) {
        loadStory(route.params.id || import.meta.env.VITE_DEFAULT_STORY)
    } else {
        loadStory(interactionStore.activeStoryId)
    }

    nextTick(scrollActiveIntoView)
})
</script>
