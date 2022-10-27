<template>
    <ItemImage
        :item="item"
        :offset-top="offsetTop"
        class="cursor-move"
        @mousemove.stop.prevent="move"
        @mousedown.stop.prevent="moveStart"
        draggable="false"
    ></ItemImage>
    <div class="absolute bottom-0 right-0 bg-white border-1 border-black px-2 py-1 w-12 h-10 text-right" :class="{ 'bg-red': (ratioImg <= 0.75 && offsetTop!=0)}">
        {{ offsetTop }}
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import ItemImage from './ItemImage.vue'

const props = defineProps(['item'])
const isMoving = ref(false)
const startPosY = ref(0)
const startOffsetTop = ref(0)
const offsetTop = ref(0)
const ratioImg = ref(1)

const move = (event) => {
    if (isMoving.value) {
        offsetTop.value = startOffsetTop.value + (event.pageY - startPosY.value)
    }
}

const moveStart = (event) => {
    isMoving.value = true
    startPosY.value = event.pageY
}

const moveEnd = (event) => {
    isMoving.value = false
    startOffsetTop.value = offsetTop.value
}

onMounted(async () => {
    offsetTop.value = props.item.offset_top
    startOffsetTop.value = props.item.offset_top
    let img = new Image()
    img.src = props.item.image_src;
    img.onload = function () {
        ratioImg.value = img.height / img.width
    }
})

window.addEventListener('mouseup', moveEnd)
</script>
