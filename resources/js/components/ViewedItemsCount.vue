<template>
    <router-link :to="{ name: 'my_collection' }" class="relative">
        <div class="flex h-full items-center justify-end">
            <div class="mr-1 text-lg font-bold">{{ interactionStore.viewedItemsCount }}</div>
            <SvgEye :class="{ '!fill-green': interactionStore.viewedItemsCount }" />
        </div>
        <Transition
            enter-active-class="transition-all"
            enter-from-class="opacity-0 translate-y-2 scale-x-90"
            enter-to-class="opacity-100 translate-y-0 scale-x-100"
        >
            <div
                v-if="showTooltip"
                class="absolute right-0.5 top-[52px] z-50 whitespace-nowrap border-2 border-black bg-green p-2 p-2 font-medium shadow-lg"
            >
                {{ $t('Artworks you explore are saved to your timeline') }}
            </div>
        </Transition>
    </router-link>
</template>

<script setup>
import { useInteractionStore } from '../stores/InteractionStore'
import { useItemStore } from '../stores/ItemStore'
import SvgEye from './svg/Eye.vue'

const props = defineProps(['showTooltip'])
const interactionStore = useInteractionStore()
const itemStore = useItemStore()
</script>
