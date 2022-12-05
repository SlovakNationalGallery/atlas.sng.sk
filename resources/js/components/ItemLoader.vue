<template>
    <slot v-if="item" :item="item"></slot>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useItemStore } from '../stores/ItemStore'

const props = defineProps(['id'])
const item = ref(null)

onMounted(async () => {
    const itemStore = useItemStore()
    item.value = itemStore.get(props.id) || (await itemStore.load(props.id))
})
</script>
