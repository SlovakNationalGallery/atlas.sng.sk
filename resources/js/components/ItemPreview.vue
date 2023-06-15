<template>
    <div
        class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black/70 p-4 outline-none"
        @click="emit('close')"
    >
        <div
            :class="{ 'bg-white': isLoading }"
            class="relative max-h-full w-full rounded-xl md:max-w-lg"
            @click="emit('close')"
        >
            <div
                :class="{ hidden: !isLoading }"
                class="w-full animate-pulse rounded-t-xl bg-gray-soft"
                :style="{ aspectRatio: item.image_aspect_ratio }"
            ></div>
            <img
                :class="{ hidden: isLoading }"
                class="w-full rounded-t-xl"
                :alt="item.title"
                :src="item.image_src"
                :srcset="item.image_srcset"
                @load="imageLoaded"
            />
            <button
                class="absolute top-0 right-0 cursor-pointer rounded-tr-xl bg-white p-1.5"
                @click.stop="emit('close')"
            >
                <SvgClose />
            </button>
            <div class="rounded-b-xl bg-white px-4 py-6">
                <h2 class="text-1.5xl font-bold">{{ item.title }}</h2>
                <h3 class="text-lg text-gray-dark">{{ item.author }}<br />{{ item.dating }}</h3>
                <WebumeniaButton :url="item.webumenia_url" class="my-4" />
                <ConfirmButton class="mt-4" @click="emit('close')">{{ $t('Close') }}</ConfirmButton>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, ref } from 'vue'
import SvgClose from './svg/Close.vue'
import ConfirmButton from './ConfirmButton.vue'
import WebumeniaButton from './WebumeniaButton.vue'

const props = defineProps(['item'])
const emit = defineEmits(['close'])
const isLoading = ref(true)

const imageLoaded = () => {
    isLoading.value = false
}
</script>
