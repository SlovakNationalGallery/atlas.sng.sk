<template>
    <img
        class="h-full object-cover w-full object-top"
        :style="{ objectPosition: 'center ' + offsetTop + 'px' }"
        :alt="`${ item.author }: ${ item.title }`"
        :src="item.image_src"
        :srcset="item.image_srcset"
        sizes="1px"
        onload="window.requestAnimationFrame(function(){if(!(size=getBoundingClientRect().width))return;onload=null;sizes=Math.ceil(size/window.innerWidth*100)+'vw';});"
        @mousemove.stop.prevent="move"
        @mousedown.stop.prevent="moveStart"
        draggable="false"
    />
</template>

<script setup>
    import { ref } from "vue";

    const props = defineProps(['item']);
    const isMoving = ref(false);``
    const startPosY = ref(0);
    const offsetTop = ref(0);

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

    window.addEventListener('mouseup', moveEnd)

</script>
