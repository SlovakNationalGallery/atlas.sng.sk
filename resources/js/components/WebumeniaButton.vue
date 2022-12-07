<template>
    <a :href="props.url" target="_blank" class="bg-green/30 border-2 border-black p-2.5 rounded-xl block">
        <div class="flex cursor-pointer">
            <div class="grow">
                <div class="flex">
                    <div class="shrink-0">
                        <div class="bg-green flex h-16 items-center justify-center rounded-xl w-16">
                            <SvgSearch />
                        </div>
                    </div>
                    <div class="mx-3 self-center">
                        <div class="font-bold">{{ $t('Open in the online catalogue') }}</div>
                        <div class="text-sm">{{ $t('at Web umenia') }}</div>
                    </div>
                </div>
            </div>
            <SvgArrowSquareOut />
        </div>
    </a>
</template>

<script setup>
import SvgArrowSquareOut from './svg/ArrowSquareOut.vue'
import SvgSearch from './svg/Search.vue'

const props = defineProps(['url'])
</script>
