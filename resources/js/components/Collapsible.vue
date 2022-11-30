<template>
    <div class="border-2 border-black p-2.5 rounded-xl">
        <div @click="open = !open" class="flex" :class="{ 'cursor-pointer': $slots.content }">
            <div class="grow">
                <slot name="summary"></slot>
            </div>
            <div v-if="$slots.content">
                <SvgDownArrow :class="{ 'rotate-180': open }" />
            </div>
        </div>
        <div class="mt-3" v-if="$slots.content" v-show="open">
            <slot name="content"></slot>
        </div>
    </div>
</template>

<script setup>
import SvgDownArrow from './svg/DownArrow.vue'

const props = defineProps(['open'])
</script>
