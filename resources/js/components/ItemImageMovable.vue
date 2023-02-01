<template>
    <ItemImage
        :offset-top="offsetTop"
        :alt="alt"
        :src="src"
        :srcset="srcset"
        class="cursor-move"
        @mousemove.stop.prevent="move"
        @mousedown.stop.prevent="moveStart"
        draggable="false"
    ></ItemImage>
    <div
        class="absolute bottom-0 right-0 h-10 w-12 border-1 border-black bg-white px-2 py-1 text-right"
        :class="{ 'bg-red': ratioImg <= 0.75 && offsetTop != 0 }"
    >
        {{ offsetTop }}
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import ItemImage from './ItemImage.vue'

const props = defineProps(['alt', 'offsetTop', 'src', 'srcset'])
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
    offsetTop.value = props.offsetTop
    startOffsetTop.value = props.offsetTop
    let img = new Image()
    img.src = props.src
    img.onload = function () {
        ratioImg.value = img.height / img.width
    }
})

window.addEventListener('mouseup', moveEnd)
</script>
