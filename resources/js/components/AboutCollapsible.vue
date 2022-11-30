<template>
    <div>
        <div @click="open = !open" class="cursor-pointer flex p-4 text-lg">
            <div class="grow">
                <slot name="summary"></slot>
            </div>
            <SvgDownArrow :class="{ 'rotate-180': open }" />
        </div>
        <div class="px-4" v-show="open">
            <slot name="content"></slot>
        </div>
    </div>
</template>

<script setup>
import SvgDownArrow from './svg/DownArrow.vue'

const props = defineProps(['open'])
</script>
