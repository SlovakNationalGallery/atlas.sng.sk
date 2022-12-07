<template>
    <Thumbnail>
        <template #image>
            <ResponsiveImageWithSizes
                class="h-full object-cover w-full"
                :image="{ src: item.image_src, srcset: item.image_srcset }"
            />
        </template>
        <template #title>{{ item.title }}</template>
        <template #description>{{ item.author }}<br />{{ item.dating }}</template>
    </Thumbnail>
</template>

<script setup>
import ResponsiveImage from './ResponsiveImage.vue'
import ResponsiveImageWithSizes from './ResponsiveImageWithSizes.vue'
import Thumbnail from './Thumbnail.vue'

const props = defineProps(['item'])
</script>
