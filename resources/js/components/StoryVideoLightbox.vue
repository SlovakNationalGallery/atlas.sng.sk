<template>
    <div role="link" class="relative" @click="visible = true">
        <ResponsiveImage class="w-full cursor-pointer rounded-xl object-cover" :image="story.video_thumbnail" />
        <button
            class="absolute bottom-3 right-3 flex appearance-none items-center rounded-xl bg-green px-3 py-2 text-base font-medium text-black"
        >
            <SvgPlay class="mr-2" />
            {{ $t('Play video') }} ({{ story.video_duration }})
        </button>
    </div>
    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4"
        v-if="visible"
        @click="visible = false"
    >
        <div class="relative max-h-full w-full md:max-w-sm">
            <ResponsiveVideoEmbed
                :src="story.video_embed"
                :width="story.video_aspect_ratio.width"
                :height="story.video_aspect_ratio.height"
            />
            <button
                class="absolute top-0 right-0 cursor-pointer rounded-tr-xl bg-white p-1.5"
                @click.stop="visible = false"
            >
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
