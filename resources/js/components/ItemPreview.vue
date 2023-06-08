<template>
    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4"
        @click="emit('close')"
    >
        <div class="relative max-h-full md:max-w-lg" @click="emit('close')">
            <img :src="item.image_src" :alt="item.title" class="w-full rounded-t-xl object-contain" />
            <button
                class="absolute top-0 right-0 cursor-pointer rounded-tr-xl bg-white p-1.5"
                @click.stop="emit('close')"
            >
                <SvgClose />
            </button>
            <div class="px-4 py-6 bg-white rounded-b-xl">
                <h2 class="text-1.5xl font-bold">{{ item.title }}</h2>
                <h3 class="text-lg text-gray-dark">{{ item.author }}<br />{{ item.dating }}</h3>
                <div class="my-4 space-y-4" v-html="item.description"></div>
                <ConfirmButton class="mt-4" @click="emit('close')">{{ $t('Close') }}</ConfirmButton>
            </div>
        </div>
    </div>
</template>

<script setup>
import SvgClose from './svg/Close.vue'
import ConfirmButton from './ConfirmButton.vue'

const props = defineProps(['item'])
const emit = defineEmits(['close'])
</script>
