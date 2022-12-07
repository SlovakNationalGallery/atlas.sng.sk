<template>
    <iframe class="rounded-xl w-full" :src="props.src" frameborder="0" allow="autoplay;"
        :style="{ aspectRatio: `${props.width}/${props.height}` }" allowfullscreen></iframe>
</template>

<script setup>
const props = defineProps(['embed', 'width', 'height'])
</script>
