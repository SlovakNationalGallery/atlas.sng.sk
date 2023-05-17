<template>
    <Thumbnail class="bg-black/10">
        <template #image>
            <ResponsiveImageWithSizes
                class="h-full w-full object-cover grayscale"
                :image="{ src: item.image_src, srcset: item.image_srcset }"
            />
        </template>
        <template #title>{{ item.title }}</template>
        <template #description>{{ item.exhibition.name }}<br />{{ item.location_formatted }}</template>
    </Thumbnail>
</template>

<script setup>
import ResponsiveImageWithSizes from './ResponsiveImageWithSizes.vue'
import Thumbnail from './Thumbnail.vue'

const props = defineProps(['item'])
</script>
