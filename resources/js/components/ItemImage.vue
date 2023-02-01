<template>
    <img
        class="aspect-[4/3] w-full object-cover object-top"
        :style="{ objectPosition: 'center ' + offsetTop + 'px' }"
        :alt="alt"
        :src="src"
        :srcset="srcset"
        sizes="1px"
        onload="window.requestAnimationFrame(function(){if(!(size=getBoundingClientRect().width))return;onload=null;sizes=Math.ceil(size/window.innerWidth*100)+'vw';});"
    />
</template>

<script setup>
const props = defineProps(['alt', 'offsetTop', 'src', 'srcset'])
</script>
