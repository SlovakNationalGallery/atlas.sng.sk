<template>
    <a href="#" @click.prevent="visible = true">
        <ItemImage :item="item" :offset-top="item.offset_top"></ItemImage>
        <button class="rounded-xl bg-black/70 py-1 px-2 absolute bottom-3 right-3 text-white text-sm flex items-center">
            <svg class="mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.75 4.5H19.5V8.25" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M14.25 9.75L19.5 4.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M8.25 19.5H4.5V15.75" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M9.75 14.25L4.5 19.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M19.5 15.75V19.5H15.75" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M14.25 14.25L19.5 19.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M4.5 8.25V4.5H8.25" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M9.75 9.75L4.5 4.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <span>{{ $t('Enlarge') }}</span>
        </button>
    </a>
    <div class="fixed inset-0 z-50 flex justify-center items-center" v-if="visible" @click="visible = false">
        <div class="bg-black opacity-70 absolute inset-0 cursor-zoom-out" @click="visible = false" />
        <div class="relative max-h-full w-full md:max-w-lg" @click.stop="visible = false">
            <img :src="item.image_src" />
            <div class="absolute cursor-pointer p-1 bg-white top-0 right-0" @click.stop="visible = false">
                <svg class="w-9 h-9">
                    <path d="M36 0H0v36h36V0Z" fill="#fff" />
                    <path
                        d="m28.125 7.875-20.25 20.25M28.125 28.125 7.875 7.875"
                        stroke="#000"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import ItemImage from './ItemImage.vue'

const props = defineProps(['item'])
const visible = ref(false)
</script>
