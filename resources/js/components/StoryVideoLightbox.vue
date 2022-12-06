<template>
    <a href="#" @click.prevent="visible = true">
        <ResponsiveImage class="rounded-xl w-full object-cover cursor-pointer" :image="story.video_thumbnail" />
        <button
            class="bg-green rounded-xl px-3 py-2 bottom-3 right-3 absolute flex items-center appearance-none text-[16px] text-black font-medium">
            <SvgPlay class="mr-2" />
            {{ $t('Play video') }} ({{ story.video_duration }})
        </button>
    </a>
    <div class="fixed inset-0 z-50 items-center" v-if="visible" @click="visible = false">
        <div class="bg-black opacity-70 absolute inset-0 cursor-zoom-out" @click="visible = false" />
        <div class="h-full max-w-full p-4 relative md:max-w-lg"
            :class="['aspect-w-' + story.video_aspect_ratio.width, 'aspect-h-' + story.video_aspect_ratio.height]"
            @click.stop="visible = false">
            <iframe class="rounded-xl w-full h-full" :src="story.video_embed" frameborder="0" allow="autoplay;"
                allowfullscreen></iframe>
            <div class="absolute cursor-pointer p-1 bg-white top-0 right-0" @click.stop="visible = false">
                <SvgClose />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import ResponsiveImage from './ResponsiveImage.vue'
import SvgClose from './svg/Close.vue'
import SvgPlay from './svg/Play.vue'

const props = defineProps(['story'])
const visible = ref(false)
</script>
