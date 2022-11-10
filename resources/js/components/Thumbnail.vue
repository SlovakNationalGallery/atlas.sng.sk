<template>
    <div class="border-2 border-black box-content flex h-24 overflow-hidden rounded-xl">
        <div class="flex-none w-24">
            <slot name="image"></slot>
        </div>
        <div class="border-black border-l-2 grow min-w-0 p-3">
            <div class="flex mb-1 items-center">
                <h2 class="grow mr-2 text-base truncate">
                    <slot name="title"></slot>
                </h2>
                <svg class="fill-none h-[18px] mr-1 shrink-0 w-[10px]">
                    <path
                        class="stroke-2 stroke-black [stroke-linecap:round] [stroke-linejoin:round]"
                        d="M0.999999 1.47168L8.5 8.97168L1 16.4717"
                    />
                </svg>
            </div>
            <div class="text-gray-dark text-sm" :class="{ truncate: truncateDescription }">
                <slot name="description"></slot>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    truncateDescription: {
        type: Boolean,
        default: true,
    },
})
</script>
