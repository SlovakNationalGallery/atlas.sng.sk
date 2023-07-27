<template>
    <div id="viewer" class="absolute inset-0 rounded-xl overflow-hidden"></div>
</template>

<script setup>
import OpenSeaDragon from 'openseadragon'
import { onMounted, onBeforeUnmount, ref } from 'vue'
const props = defineProps(['tileSources'])
const viewer = ref(null)
//TODO: navigation for multiple images

onMounted(() => {
    viewer.value = OpenSeaDragon({
        id: 'viewer',
        tileSources: props.tileSources[0].deep_zoom_url,
        showNavigationControl: false,
        showNavigator: false,
    })
})

onBeforeUnmount(() => {
    if (viewer.value) {
        viewer.value.destroy()
    }
})

</script>