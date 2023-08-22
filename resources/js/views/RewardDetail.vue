<template>
    <div v-if="bucketlist">
        <div class="relative w-full border-b-2 border-black bg-gray-softest">
            <ImageLightbox
                :alt="bucketlist.title"
                :src="bucketlist.image.src"
                :srcset="bucketlist.image.srcset"
            />
        </div>
        <div class="relative h-full border-black p-4">
            <h2 class="mb-4 text-1.5xl font-bold">{{ bucketlist.title }}</h2>
            <div class="space-y-4 markdown" v-html="bucketlist.text"></div>
        </div>

        <Teleport to="#title">{{ $t(':title set', { title: bucketlist.title }) }}</Teleport>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import { useBucketlistStore } from '../stores/BucketlistStore'
import ImageLightbox from '../components/ImageLightbox.vue'

const route = useRoute()
const bucketlistStore = useBucketlistStore()
const bucketlist = ref(null)

onMounted(async () => {
    const id = route.params.id
    bucketlist.value = await bucketlistStore.load(id)
})
</script>
