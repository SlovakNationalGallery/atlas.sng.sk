<template>
    <div class="flex">
        <div class="shrink-0">
            <ResponsiveImage
                class="h-16 w-16 rounded-xl object-cover"
                :image="thumbnail"
            />
        </div>
        <div class="mx-3 self-center">
            <div class="font-bold">{{ title ?? 'Video' }}</div>
            <div class="text-sm">
                {{ subtitle ?? $t('Behind the scenes of the exhibition') }}
            </div>
        </div>
    </div>
</template>

<script setup>
import ResponsiveImage from './ResponsiveImage.vue'
const props = defineProps(['thumbnail', 'title', 'subtitle'])
</script>
