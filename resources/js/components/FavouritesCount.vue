<template>
    <router-link :to="{ name: 'my_collection' }" class="relative">
        <div
            class="flex h-full justify-end transition-colors"
            :class="{ 'border-l-black bg-green': showTooltip, 'opacity-40': !count }"
        >
            <div class="font-bold text-base pr-1">{{ count }}</div>
            <svg class="stroke-black stroke-2 w-[29px] h-[25px]" :class="[count ? 'fill-green' : 'fill-white']">
                <path
                    d="M15.7127 23.4877L25.8377 13.3627C28.3252 10.8627 28.6877 6.77517 26.3377 4.16267C25.7483 3.50431 25.0309 2.97302 24.2293 2.60128C23.4277 2.22953 22.5587 2.02513 21.6754 2.00056C20.7921 1.97599 19.9131 2.13177 19.0921 2.45839C18.271 2.785 17.5252 3.27559 16.9002 3.90017L15.0002 5.81267L13.3627 4.16267C10.8627 1.67517 6.77517 1.31267 4.16267 3.66267C3.50431 4.25203 2.97302 4.96943 2.60128 5.77105C2.22953 6.57266 2.02513 7.44166 2.00056 8.32493C1.97599 9.20821 2.13177 10.0872 2.45839 10.9083C2.785 11.7293 3.27559 12.4751 3.90017 13.1002L14.2877 23.4877C14.4773 23.6755 14.7333 23.7808 15.0002 23.7808C15.267 23.7808 15.5231 23.6755 15.7127 23.4877Z"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
        </div>
        <Transition
            enter-active-class="transition-all bg-green"
            enter-from-class="opacity-0 translate-y-2 scale-x-90"
            enter-to-class="opacity-100 translate-y-0 scale-x-100"
        >
            <div
                v-if="showTooltip"
                class="tooltip absolute right-4 top-[52px] z-50 shadow-lg bg-black border-black border-2"
            >
                <div class="absolute w-3 h-3 top-0 right-2.5 -mt-2 rotate-45 bg-black z-0"></div>
                <div class="w-full h-full bg-green relative p-2 whitespace-nowrap">
                    {{ $t('Saved! Tap this icon to view your collection.') }}
                </div>
            </div>
        </Transition>
    </router-link>
</template>

<script setup>
import { computed } from 'vue'
import { useItemsStore } from '../stores/ItemsStore'

const props = defineProps(['showTooltip'])
const itemsStore = useItemsStore()

const count = computed(() => itemsStore.count)
</script>
