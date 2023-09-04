<template>
    <Thumbnail>
        <template #image>
            <ResponsiveImageWithSizes
                class="h-full w-full rounded-xl object-cover"
                :image="{ src: item.image_src, srcset: item.image_srcset }"
            />
        </template>
        <template #title>{{ item.title }}</template>
        <template #description>{{ item.author }}<br />{{ getItemDating(item) }}</template>
    </Thumbnail>
</template>

<script setup>
import ResponsiveImageWithSizes from './ResponsiveImageWithSizes.vue'
import Thumbnail from './Thumbnail.vue'
import { getItemDating } from '../helpers'
const props = defineProps(['item'])
</script>
