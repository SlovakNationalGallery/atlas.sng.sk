<template>
    <div role="link" class="relative" @click="visible = true">
        <ItemImage :item="item" :offset-top="item.offset_top"></ItemImage>
        <button class="rounded-xl bg-black/70 py-1 px-2 absolute bottom-3 right-3 text-white text-sm flex items-center">
            <SvgArrowsOut class="mr-2" />
            <span>{{ $t('Enlarge') }}</span>
        </button>
    </div>
    <div class="fixed inset-0 z-50 flex justify-center items-center bg-black/70 p-4" v-if="visible"
        @click="visible = false">
        <div class="relative max-h-full md:max-w-lg" @click.stop="visible = false">
            <img :src="item.image_src" class="rounded-xl object-contain" />
            <button class="absolute cursor-pointer p-1 bg-white top-0 right-0 rounded-tr-xl"
                @click.stop="visible = false">
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

const props = defineProps(['item'])
const visible = ref(false)
</script>
