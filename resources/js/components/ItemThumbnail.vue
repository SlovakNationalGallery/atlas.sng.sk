<template>
    <div class="flex">
        <div class="h-24 w-24 flex-none border-black border-2 flex items-center justify-center bg-gray-softest">
            <ItemImage :item="item" />
        </div>
        <div class="py-2 px-4 shrink">
            <h2 class="text-base pb-1">{{ item.title }}</h2>
            <div class="text-sm text-gray-dark">{{ item.author }} · {{ item.dating }}</div>
        </div>
    </div>
</template>

<script setup>
import ItemImage from './ItemImage.vue'

const props = defineProps(['item'])
</script>
