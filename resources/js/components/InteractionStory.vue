<template>
    <div class="scroll-mt-20" :id="active ? 'active-story' : undefined">
        <img v-if="first" class="mx-auto mb-8 h-40" src="../../img/interaction-intro-ester.svg" alt="Ester" />
        <img v-else-if="active" class="h-12 rounded-xl w-12" src="../../img/avatar-ester.svg" alt="Avatar" />

        <div class="my-4 space-y-6" v-html="story.text"></div>

        <div class="my-4" v-for="image in story.images">
            <ResponsiveImageWithSizes class="rounded-xl w-full" :image="image" />
        </div>

        <div class="my-4 relative" v-if="story.video_embed">
            <StoryVideoLightbox :story="story"></StoryVideoLightbox>
        </div>

        <button
            :disabled="!active"
            v-show="active || linkId === link.id"
            class="block border-1 flex font-bold gap-x-2 items-center leading-8 my-4 p-3 rounded-xl text-left w-full"
            :class="[active ? 'bg-green border-green text-black' : 'border-white/10 text-white']"
            @click="emit('navigate', link)"
            v-for="link in story.links"
        >
            <SvgChatCircle class="flex-none" v-if="!active" />
            {{ link.title }}
        </button>
    </div>
</template>

<script setup>
import ResponsiveImageWithSizes from './ResponsiveImageWithSizes.vue'
import StoryVideoLightbox from '../components/StoryVideoLightbox.vue'
import SvgChatCircle from './svg/ChatCircle.vue'

const props = defineProps(['story', 'active', 'linkId', 'first'])
const emit = defineEmits(['navigate'])
</script>
