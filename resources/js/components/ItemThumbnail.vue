<template>
    <Thumbnail>
        <template #image>
            <ResponsiveImageWithSizes
                class="h-full w-full rounded-xl object-cover"
                :image="{ src: item.image_src, srcset: item.image_srcset }"
            />
        </template>
        <template #title>{{ item.title }}</template>
        <template #description>{{ item.author }}<br />{{ item.dating }}</template>
    </Thumbnail>
</template>

<script setup>
import ResponsiveImageWithSizes from './ResponsiveImageWithSizes.vue'
import Thumbnail from './Thumbnail.vue'

const props = defineProps(['item'])
</script>
