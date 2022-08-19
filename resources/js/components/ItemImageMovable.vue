<template>
    <ItemImage
        :item="item"
        :offset-top="offsetTop"
        class="cursor-move"
        @mousemove.stop.prevent="move"
        @mousedown.stop.prevent="moveStart"
        draggable="false"
    ></ItemImage>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import ItemImage from './ItemImage.vue'

const props = defineProps(['item'])
const isMoving = ref(false)
const startPosY = ref(0)
const offsetTop = ref(0)

const move = (event) => {
    if (isMoving.value) {
        offsetTop.value = event.pageY - startPosY.value
        console.log('offsetTop: ' + offsetTop.value)
    }
}

const moveStart = (event) => {
    isMoving.value = true
    startPosY.value = event.pageY
}

const moveEnd = (event) => {
    isMoving.value = false
}

onMounted(async () => {
    offsetTop.value = props.item.offset_top
})

window.addEventListener('mouseup', moveEnd)
</script>
