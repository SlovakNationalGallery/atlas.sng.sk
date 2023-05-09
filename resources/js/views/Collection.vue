<template>
    <div>
        <Bucketlist :id="bucketlistId" v-if="bucketlistId" />
        <Timeline class="m-4" />
    </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useItemStore } from '../stores/ItemStore'
import Bucketlist from '../components/Bucketlist.vue'
import Timeline from '../components/Timeline.vue'

const route = useRoute()
const itemStore = useItemStore()
const bucketlistId = import.meta.env.VITE_DEFAULT_BUCKETLIST

onMounted(async () => {
    if (route.params.id) {
        itemStore.fetch(route.params.id)
    }
})
</script>
