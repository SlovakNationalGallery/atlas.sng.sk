<template>
    <Thumbnail>
        <template #image><ItemImage :item="item" /></template>
        <template #title>{{ item.title }}</template>
        <template #description>{{ item.author }}<br />{{ item.dating }}</template>
    </Thumbnail>
</template>

<script setup>
import ItemImage from './ItemImage.vue'
import Thumbnail from './Thumbnail.vue'

const props = defineProps(['item'])
</script>
