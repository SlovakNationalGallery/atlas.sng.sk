<template>
    <div role="link" class="relative" @click.prevent="visible = true">
        <ItemImage :item="item" :offset-top="item.offset_top"></ItemImage>
        <button class="rounded-xl bg-black/70 py-1 px-2 absolute bottom-3 right-3 text-white text-sm flex items-center">
            <SvgArrowsOut class="mr-2" />
            <span>{{ $t('Enlarge') }}</span>
        </button>
    </div>
    <div class="fixed inset-0 z-50 flex justify-center items-center" v-if="visible" @click="visible = false">
        <div class="bg-black opacity-70 absolute inset-0 cursor-zoom-out" @click="visible = false" />
        <div class="relative max-h-full w-full md:max-w-lg" @click.stop="visible = false">
            <img :src="item.image_src" />
            <div class="absolute cursor-pointer p-1 bg-white top-0 right-0" @click.stop="visible = false">
                <SvgClose />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import ItemImage from './ItemImage.vue'
import SvgArrowsOut from './svg/ArrowsOut.vue'
import SvgClose from './svg/Close.vue'

const props = defineProps(['item'])
const visible = ref(false)
</script>
