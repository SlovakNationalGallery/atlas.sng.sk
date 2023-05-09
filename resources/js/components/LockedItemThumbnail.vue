<template>
    <Thumbnail>
        <template #image>
            <ResponsiveImageWithSizes
                class="h-full w-full object-cover grayscale"
                :image="{ src: item.image_src, srcset: item.image_srcset }"
            />
        </template>
        <template #title>{{ item.exhibition.name }}</template>
        <template #description>{{ item.location_formatted }}</template>
    </Thumbnail>
</template>

<script setup>
import ResponsiveImageWithSizes from './ResponsiveImageWithSizes.vue'
import Thumbnail from './Thumbnail.vue'

const props = defineProps(['item'])
</script>
