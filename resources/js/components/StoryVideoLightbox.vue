<template>
    <div role="link" class="relative" @click="visible = true">
        <ResponsiveImage class="rounded-xl w-full object-cover cursor-pointer" :image="story.video_thumbnail" />
        <button
            class="bg-green rounded-xl px-3 py-2 bottom-3 right-3 absolute flex items-center appearance-none text-base text-black font-medium">
            <SvgPlay class="mr-2" />
            {{ $t('Play video') }} ({{ story.video_duration }})
        </button>
    </div>
    <div class="fixed inset-0 z-50 flex justify-center items-center bg-black/70 p-4" v-if="visible"
        @click="visible = false">
        <div class="relative max-h-full w-full md:max-w-sm">
            <ResponsiveVideoEmbed :src="story.video_embed" :width="story.video_aspect_ratio.width"
                :height="story.video_aspect_ratio.height" />
            <button class="absolute cursor-pointer p-1 top-0 right-0 bg-white rounded-tr-xl"
                @click.stop="visible = false">
                <SvgClose />
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import ResponsiveImage from './ResponsiveImage.vue'
import ResponsiveVideoEmbed from './ResponsiveVideoEmbed.vue'
import SvgClose from './svg/Close.vue'
import SvgPlay from './svg/Play.vue'

const props = defineProps(['story'])
const visible = ref(false)
</script>
