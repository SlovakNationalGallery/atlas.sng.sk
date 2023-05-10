<template>
    <router-link
        :to="{ name: 'my_collection' }"
        class="relative transition-colors"
        :class="{ '!border-l-black bg-green': showTooltip, 'opacity-40': !itemStore.viewedCount }"
    >
        <div class="flex h-full items-center justify-end">
            <div class="text-lg font-bold">{{ itemStore.viewedCount }}</div>
            <SvgEye />
        </div>
        <Transition
            enter-active-class="transition-all bg-green"
            enter-from-class="opacity-0 translate-y-2 scale-x-90"
            enter-to-class="opacity-100 translate-y-0 scale-x-100"
        >
            <div
                v-if="showTooltip"
                class="tooltip absolute right-4 top-[52px] z-50 border-2 border-black bg-black shadow-lg"
            >
                <div class="absolute top-0 right-2.5 z-0 -mt-2 h-3 w-3 rotate-45 bg-black"></div>
                <div class="relative h-full w-full whitespace-nowrap bg-green p-2">
                    {{ $t('We added this item to your timeline') }}
                </div>
            </div>
        </Transition>
    </router-link>
</template>

<script setup>
import { useItemStore } from '../stores/ItemStore'
import SvgEye from './svg/Eye.vue'

const props = defineProps(['showTooltip'])
const itemStore = useItemStore()
</script>
