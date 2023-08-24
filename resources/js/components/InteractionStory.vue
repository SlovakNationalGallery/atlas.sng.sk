<template>
    <div class="scroll-my-20" :id="active ? 'active-story' : undefined">
        <img v-if="first" class="markdown mx-auto mb-8 h-40" src="../../img/interaction-intro-ester.svg" alt="Ester" />
        <img
            v-else-if="activeOrTransitioning"
            class="h-12 w-12 rounded-xl object-cover"
            src="../../img/avatar-ester.png"
            alt="Avatar"
        />

        <div class="markdown my-4 space-y-6" v-html="story.text"></div>

        <div class="my-4" v-for="image in story.images">
            <ResponsiveImageWithSizes class="w-full rounded-xl" :image="image" />
        </div>

        <div class="relative my-4" v-if="story.video_embed">
            <StoryVideoLightbox :story="story"></StoryVideoLightbox>
        </div>

        <button
            :disabled="!active"
            v-show="activeOrTransitioning || linkId === link.id"
            class="my-4 flex w-full items-center gap-x-2 rounded-xl border-1 p-3 text-left font-bold leading-8"
            :class="{
                'border-green bg-green': activeOrTransitioning,
                'bg-opacity-20 text-green': activeOrTransitioning && interactionStore.hasVisitedAllLinks(link.story_id),
                'text-black': activeOrTransitioning && !interactionStore.hasVisitedAllLinks(link.story_id),
                'border-white/10 text-white': !activeOrTransitioning,
            }"
            @click="emit('navigate', link)"
            v-for="link in story.links"
        >
            <SvgChatCircle
                class="flex-none"
                v-if="!activeOrTransitioning || interactionStore.hasVisitedAllLinks(link.story_id)"
            />
            {{ link.title }}
        </button>
        <button
            :disabled="!active"
            v-show="activeOrTransitioning && !first"
            class="my-4 flex w-full items-center gap-x-2 rounded-xl text-left text-base leading-8 text-green"
            @click="emit('undo')"
        >
            <SvgArrowUp class="flex-none" />
            {{ $t('Back to the previous step') }}
        </button>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import ResponsiveImageWithSizes from './ResponsiveImageWithSizes.vue'
import StoryVideoLightbox from './StoryVideoLightbox.vue'
import SvgArrowUp from './svg/ArrowUp.vue'
import SvgChatCircle from './svg/ChatCircle.vue'
import { useInteractionStore } from '../stores/InteractionStore'
import { useStoryStore } from '../stores/StoryStore'

const interactionStore = useInteractionStore()

const props = defineProps(['id', 'active', 'linkId', 'first'])
const emit = defineEmits(['navigate', 'undo'])

const transitioning = ref(false)

const storyStore = useStoryStore()
const story = ref()

const activeOrTransitioning = computed(() => {
    return transitioning.value || props.active
})

onMounted(async () => {
    story.value = storyStore.get(props.id) || await storyStore.load(props.id)
})

defineExpose({
    transitioning,
})
</script>
