<template>
    <slot v-if="item" :item="item"></slot>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useItemsStore } from '../stores/ItemsStore'

const props = defineProps(['id'])
const item = ref(null)

onMounted(async () => {
    const itemsStore = useItemsStore()
    item.value = await itemsStore.get(props.id)
})
</script>
