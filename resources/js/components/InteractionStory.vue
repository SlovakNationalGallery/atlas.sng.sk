<template>
    <div class="scroll-mt-14" :class="{ 'opacity-50': !active }" :id="active ? 'active-story' : undefined">
        <div class="my-4">
            <Markdown :source="story.text" />
        </div>

        <div class="my-4" v-for="image in story.images">
            <ResponsiveImageWithPlaceholder class="rounded-xl w-full" :image="image" />
        </div>

        <div class="my-4 relative" v-if="story.video_thumbnail">
            <StoryVideoLightbox :story="story"></StoryVideoLightbox>
        </div>

        <button :disabled="!active" v-show="active || linkId === link.id"
            class="block border-1 border-green cursor-pointer my-4 p-3 rounded-xl text-green text-left w-full font-medium"
            @click="emit('navigate', link)" v-for="link in story.links">
            {{ link.title }}
        </button>
    </div>
</template>

<script setup>
import Markdown from 'vue3-markdown-it'
import ResponsiveImageWithPlaceholder from './ResponsiveImageWithPlaceholder.vue'
import StoryVideoLightbox from '../components/StoryVideoLightbox.vue'

const props = defineProps(['story', 'active', 'linkId'])
const emit = defineEmits(['navigate'])
</script>
