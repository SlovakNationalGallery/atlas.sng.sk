<template>
    <iframe
        class="w-full rounded-xl"
        :src="props.src"
        frameborder="0"
        allow="autoplay;"
        :style="{ aspectRatio: `${props.width}/${props.height}` }"
        allowfullscreen
        disablepictureinpicture
    ></iframe>
</template>

<script setup>
const props = defineProps(['embed', 'width', 'height'])
</script>
