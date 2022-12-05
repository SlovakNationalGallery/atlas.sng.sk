<template>
    <div class="flex">
        <div class="shrink-0">
            <ResponsiveImage class="rounded-xl w-16 h-16 object-cover" :image="thumbnail" />
        </div>
        <div class="mx-3 self-center">
            <div class="font-bold">Video</div>
            <div class="text-sm">
                Ako sme dielo inštalovali?
            </div>
        </div>
    </div>
</template>

<script setup>
import ResponsiveImage from './ResponsiveImage.vue'
const props = defineProps(['thumbnail'])
</script>
