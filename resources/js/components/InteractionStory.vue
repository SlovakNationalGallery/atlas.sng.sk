<template>
    <div class="scroll-mt-14" :class="{ 'opacity-50': !active }" :id="active ? 'active-story' : undefined">
        <div class="my-4 space-y-6" v-html="story.text"></div>

        <div class="my-4" v-for="image in story.images">
            <ResponsiveImageWithSizes class="rounded-xl w-full" :image="image" />
        </div>

        <div class="my-4" v-if="story.video_thumbnail">
            <ResponsiveImage class="rounded-xl w-full" :image="story.video_thumbnail" />
        </div>

        <button
            :disabled="!active"
            v-show="active || linkId === link.id"
            class="block border-1 border-green cursor-pointer my-4 p-3 rounded-xl text-green text-left w-full"
            @click="emit('navigate', link)"
            v-for="link in story.links"
        >
            {{ link.title }}
        </button>
    </div>
</template>

<script setup>
import ResponsiveImage from './ResponsiveImage.vue'
import ResponsiveImageWithSizes from './ResponsiveImageWithSizes.vue'

const props = defineProps(['story', 'active', 'linkId'])
const emit = defineEmits(['navigate'])
</script>
