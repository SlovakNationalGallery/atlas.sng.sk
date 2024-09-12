<template>
    <div>
        <Bucketlist :id="bucketlistId" v-if="bucketlistId" class="px-4 py-6" />
        <hr class="border border-gray-soft" />
        <Timeline />
    </div>
</template>

<script setup>
import Bucketlist from '../components/Bucketlist.vue'
import Timeline from '../components/Timeline.vue'
const bucketlistId = import.meta.env.VITE_DEFAULT_BUCKETLIST
</script>
