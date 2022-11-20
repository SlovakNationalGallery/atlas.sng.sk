<template>
    <div class="border-2 border-black p-2.5 rounded-xl">
        <div @click="open = !open" class="flex" :class="{ 'cursor-pointer': $slots.content }">
            <div class="grow">
                <slot name="summary"></slot>
            </div>
            <div v-if="$slots.content">
                <svg class="fill-none h-[24px] w-[24px]" :class="{ 'rotate-180': open }">
                    <path d="M19.5 9L12 16.5L4.5 9"
                        class="stroke-2 stroke-black [stroke-linecap:round] [stroke-linejoin:round]" />
                </svg>
            </div>
        </div>
        <div class="mt-3" v-if="$slots.content" v-show="open">
            <slot name="content"></slot>
        </div>
    </div>
</template>

<script setup>
const props = defineProps(['open'])
</script>
