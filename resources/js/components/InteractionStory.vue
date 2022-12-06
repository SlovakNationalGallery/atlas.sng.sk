<template>
    <div class="scroll-mt-14" :id="active ? 'active-story' : undefined">
        <img v-if="first" class="mx-auto mb-8 -mt-2 h-40" src="../../img/interaction-intro-ester.svg" alt="Ester" />
        <img v-else-if="active" class="h-12 rounded-xl w-12" src="../../img/avatar-ester.svg" alt="Avatar" />

        <div class="my-4 space-y-6" v-html="story.text"></div>

        <div class="my-4" v-for="image in story.images">
            <ResponsiveImageWithPlaceholder class="rounded-xl w-full" :image="image" />
        </div>

        <div class="my-4" v-if="story.video_thumbnail">
            <ResponsiveImage class="rounded-xl w-full" :image="story.video_thumbnail" />
        </div>

        <button
            :disabled="!active"
            v-show="active || linkId === link.id"
            class="block border-1 flex font-bold gap-x-2 items-center my-4 p-3 rounded-xl text-left w-full"
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
import ResponsiveImage from './ResponsiveImage.vue'
import ResponsiveImageWithPlaceholder from './ResponsiveImageWithPlaceholder.vue'
import SvgChatCircle from './svg/ChatCircle.vue'

const props = defineProps(['story', 'active', 'linkId', 'first'])
const emit = defineEmits(['navigate'])
</script>
