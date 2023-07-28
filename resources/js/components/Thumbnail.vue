<template>
    <div class="relative box-content flex h-24 overflow-hidden rounded-xl">
        <div class="w-24 flex-none">
            <slot name="image"></slot>
        </div>
        <div class="min-w-0 grow p-3">
            <div class="mb-1 flex items-center">
                <h2 class="mr-2 grow truncate text-lg font-medium leading-6">
                    <slot name="title"></slot>
                </h2>
                <slot name="icon"> </slot>
            </div>
            <div class="text-sm" :class="{ truncate: truncateDescription }">
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
