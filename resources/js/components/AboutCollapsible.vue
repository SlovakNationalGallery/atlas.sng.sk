<template>
    <div ref="el">
        <div @click="open = !open" class="flex cursor-pointer p-4 text-xl">
            <div class="grow">
                <slot name="summary"></slot>
            </div>
            <SvgDownArrow :class="{ 'rotate-180': open }" />
        </div>
        <div class="px-4 pb-4" v-show="open">
            <slot name="content"></slot>
        </div>
    </div>
</template>

<script setup>
import { nextTick, ref, watch } from 'vue'
import SvgDownArrow from './svg/DownArrow.vue'

const props = defineProps(['initialOpen'])
const el = ref(null)
const open = ref(props.initialOpen)

watch(open, (value) => {
    if (value) {
        nextTick(() => {
            el.value.scrollIntoView({
                behavior: 'smooth',
            })
        })
    }
})
</script>
