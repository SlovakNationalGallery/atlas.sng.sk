<template>
    <div role="link" class="relative" @click="visible = true">
        <ItemImage :class="imgClass" :offset-top="offsetTop" :alt="alt" :src="src" :srcset="srcset"></ItemImage>
        <button
            class="absolute bottom-3 right-3 flex items-center rounded-xl bg-black/70 py-1 px-2 text-sm font-medium text-white"
        >
            <SvgArrowsOut class="mr-2" />
            <span>{{ $t('Enlarge') }}</span>
        </button>
    </div>
    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4"
        v-if="visible"
        @click="visible = false"
    >
        <div :class="[images.length ? 'h-full' : 'max-h-full', 'relative rounded-xl bg-gray-soft w-full max-w-lg']" :style="{ aspectRatio: imageAspectRatio}" @click.stop>
            <img v-if="!images.length" :src="src" class="rounded-xl object-contain" />
            <ZoomViewer v-else :tileSources="images" />
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
import ItemImage from './ItemImage.vue'
import SvgArrowsOut from './svg/ArrowsOut.vue'
import SvgClose from './svg/Close.vue'
import ZoomViewer from './ZoomViewer.vue'

const props = defineProps(['alt', 'offsetTop', 'src', 'srcset', 'images', 'imageAspectRatio', 'imgClass'])

const visible = ref(false)
</script>
