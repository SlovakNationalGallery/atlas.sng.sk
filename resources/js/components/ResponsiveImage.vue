<template>
    <img :srcset="props.image.srcset" :src="props.image.src" :width="props.image.width" :height="props.image.height" />
</template>

<script setup>
const props = defineProps(['image'])
</script>
