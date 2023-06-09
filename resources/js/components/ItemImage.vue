<template>
    <div :class="{ hidden: !isLoading }" class="aspect-[4/3] w-full animate-pulse bg-gray-soft" v-bind="$attrs"></div>
    <img
        :class="{ hidden: isLoading }"
        class="aspect-[4/3] w-full object-cover object-top"
        :style="{ objectPosition: 'center ' + offsetTop + 'px' }"
        :alt="alt"
        :src="src"
        :srcset="srcset"
        sizes="1px"
        onload="window.requestAnimationFrame(function(){if(!(size=getBoundingClientRect().width))return;onload=null;sizes=Math.ceil(size/window.innerWidth*100)+'vw';});"
        @load="imageLoaded"
        v-bind="$attrs"
    />
</template>

<script setup>
import { defineProps, ref } from 'vue'
const props = defineProps(['alt', 'offsetTop', 'src', 'srcset'])
const isLoading = ref(true)

const imageLoaded = () => {
    isLoading.value = false
}
</script>
