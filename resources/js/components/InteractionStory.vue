<template>
    <div class="scroll-my-20" :id="active ? 'active-story' : undefined">
        <img v-if="first" class="mx-auto mb-8 h-40" src="../../img/interaction-intro-ester.svg" alt="Ester" />
        <img v-else-if="active" class="h-12 w-12 rounded-xl" src="../../img/avatar-ester.png" alt="Avatar" />

        <div class="my-4 space-y-6" v-html="story.text"></div>

        <div class="my-4" v-for="image in story.images">
            <ResponsiveImageWithSizes class="w-full rounded-xl" :image="image" />
        </div>

        <div class="relative my-4" v-if="story.video_embed">
            <StoryVideoLightbox :story="story"></StoryVideoLightbox>
        </div>

        <button
            :disabled="!active"
            v-show="active || linkId === link.id"
            class="my-4 block flex w-full items-center gap-x-2 rounded-xl border-1 p-3 text-left font-bold leading-8"
            :class="[active ? 'border-green bg-green text-black' : 'border-white/10 text-white']"
            @click="emit('navigate', link)"
            v-for="link in story.links"
        >
            <SvgChatCircle class="flex-none" v-if="!active" />
            {{ link.title }}
        </button>

        <button
            v-if="active && !first"
            class="my-4 block flex w-full items-center gap-x-2 rounded-xl border-1 border-white/10 p-3 text-left font-bold leading-8 text-white"
            @click="emit('undo')"
        >
            {{ $t('Undo') }}
        </button>
    </div>
</template>

<script setup>
import ResponsiveImageWithSizes from './ResponsiveImageWithSizes.vue'
import StoryVideoLightbox from '../components/StoryVideoLightbox.vue'
import SvgChatCircle from './svg/ChatCircle.vue'

const props = defineProps(['story', 'active', 'linkId', 'first'])
const emit = defineEmits(['navigate', 'undo'])
</script>
