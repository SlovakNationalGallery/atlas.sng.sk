<template>
    <div class="box-content flex h-24 overflow-hidden rounded-xl border-2 border-black">
        <div class="w-24 flex-none">
            <slot name="image"></slot>
        </div>
        <div class="min-w-0 grow border-l-2 border-black p-3">
            <div class="mb-1 flex items-center">
                <h2 class="mr-2 grow truncate text-lg font-medium">
                    <slot name="title"></slot>
                </h2>
                <svg class="mr-1 h-[18px] w-[10px] shrink-0 fill-none">
                    <path
                        class="stroke-black stroke-2 [stroke-linecap:round] [stroke-linejoin:round]"
                        d="M0.999999 1.47168L8.5 8.97168L1 16.4717"
                    />
                </svg>
            </div>
            <div class="text-sm text-gray-dark" :class="{ truncate: truncateDescription }">
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
