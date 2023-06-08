<template>
    <a :href="props.url" target="_blank" class="block rounded-xl border-2 border-black bg-green/30 p-2.5">
        <div class="flex cursor-pointer">
            <div class="grow">
                <div class="flex">
                    <div class="shrink-0">
                        <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-green">
                            <SvgSearch />
                        </div>
                    </div>
                    <div class="mx-3 self-center">
                        <slot>
                            <div class="font-bold">{{ $t('Explore the artwork') }}</div>
                            <div class="text-sm">{{ $t('in the webumenia.sk catalogue') }}</div>
                        </slot>
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
