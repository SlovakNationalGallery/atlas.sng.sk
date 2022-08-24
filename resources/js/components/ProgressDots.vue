<template>
    <div class="flex w-full content-center justify-center">
        <span
            v-for="n in length"
            class="h-2 w-2 bg-white mx-1 rounded-full border-2"
            :class="{ 'bg-black': activeStep === n }"
        >
        </span>
    </div>
</template>

<script setup>
const props = defineProps(['length', 'activeStep'])
</script>
