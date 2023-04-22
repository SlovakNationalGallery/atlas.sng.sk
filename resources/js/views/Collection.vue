<template>
    <div class="p-4">
        <Timeline />
    </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useItemStore } from '../stores/ItemStore'
import Timeline from '../components/Timeline.vue'

const route = useRoute()
const itemStore = useItemStore()

onMounted(async () => {
    if (route.params.id) {
        itemStore.fetch(route.params.id)
    }
})
</script>
