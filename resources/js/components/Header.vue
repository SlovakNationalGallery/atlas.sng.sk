<template>
    <div class="border-black border-t-2 flex items-center">
        <router-link to="/">
            <div class="p-2.5 border-r-2" :class="[code ? 'border-r-transparent' : 'bg-green border-r-black']">
                <svg v-if="code" class="w-[10px] h-[18px] ml-2 fill-none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 16.5L1.5 9L9 1.5"
                        class="stroke-2 stroke-black [stroke-linecap:round] [stroke-linejoin:round]" />
                </svg>
                <svg v-else class="h-[26px] w-[26px] fill-black" viewBox="0 0 32 32">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0 8.54668V17.0934H7.45332H14.9066V23.4533V29.8133H8.54677H2.1869L2.17911 24.5544L2.17132 19.2955L1.08566 19.2874L0 19.2793V25.6396V32H16H32V16V0H16H0V8.54668ZM14.9066 8.54668V14.9066H8.54668H2.18672V8.54668V2.18672H8.54668H14.9066V8.54668ZM29.8057 7.76901C29.81 10.8308 29.803 13.3359 29.7902 13.3359C29.7775 13.3359 27.2585 10.8273 24.1925 7.76125L18.6179 2.18659L24.2079 2.19436L29.7979 2.20212L29.8057 7.76901ZM22.6833 9.33205L28.2579 14.9066H22.6602H17.0626V9.33205C17.0626 6.26603 17.073 3.75746 17.0857 3.75746C17.0984 3.75746 19.6174 6.26603 22.6833 9.33205ZM29.8133 19.7267V22.36H24.5467H19.2801V23.4532V24.5465L24.539 24.5543L29.7979 24.5621L29.8058 27.1877L29.8136 29.8133H23.4381H17.0626V23.4739C17.0626 19.9872 17.0718 17.1252 17.0831 17.1139C17.0944 17.1026 19.9633 17.0934 23.4585 17.0934H29.8133V19.7267Z" />
                </svg>
            </div>
        </router-link>
        <h1 class="pl-3 grow text-xl text-center">
            {{ $t($route.meta.title) }}
        </h1>
        <router-link to="/collection" class="relative">
            <div class="flex px-4 py-2 h-full border-black border-l-2 border-l-transparent transition-colors"
                :class="{ 'border-l-black bg-green': isActive, 'opacity-40': !count }">
                <div class="font-bold text-base pr-1">{{ count }}</div>
                <svg class="stroke-black stroke-2 w-[29px] h-[25px]" :class="[count ? 'fill-green' : 'fill-white']">
                    <path
                        d="M15.7127 23.4877L25.8377 13.3627C28.3252 10.8627 28.6877 6.77517 26.3377 4.16267C25.7483 3.50431 25.0309 2.97302 24.2293 2.60128C23.4277 2.22953 22.5587 2.02513 21.6754 2.00056C20.7921 1.97599 19.9131 2.13177 19.0921 2.45839C18.271 2.785 17.5252 3.27559 16.9002 3.90017L15.0002 5.81267L13.3627 4.16267C10.8627 1.67517 6.77517 1.31267 4.16267 3.66267C3.50431 4.25203 2.97302 4.96943 2.60128 5.77105C2.22953 6.57266 2.02513 7.44166 2.00056 8.32493C1.97599 9.20821 2.13177 10.0872 2.45839 10.9083C2.785 11.7293 3.27559 12.4751 3.90017 13.1002L14.2877 23.4877C14.4773 23.6755 14.7333 23.7808 15.0002 23.7808C15.267 23.7808 15.5231 23.6755 15.7127 23.4877Z"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <Transition enter-active-class="transition-all bg-green"
                enter-from-class="opacity-0 translate-y-2 scale-x-90"
                enter-to-class="opacity-100 translate-y-0 scale-x-100">
                <div v-if="isActive"
                    class="tooltip absolute right-4 top-[52px] z-50 shadow-lg bg-black border-black border-2">
                    <div class="absolute w-3 h-3 top-0 right-[10px] -mt-2 rotate-45 bg-black z-0"></div>
                    <div class="w-full h-full bg-green relative p-2 whitespace-nowrap">
                        {{ $t('Saved! Tap this icon to view your collection.') }}
                    </div>
                </div>
            </Transition>
        </router-link>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { useItemsStore } from '../stores/ItemsStore'
import { useRouter } from 'vue-router'
import { HEADER_CODES } from '../consts'
import { useDetailStore } from '../stores/DetailStore'

const router = useRouter()
const itemsStore = useItemsStore()
const detailStore = useDetailStore()

const count = computed(() => itemsStore.count)
const isActive = ref(false)

const code = computed(() => {
    const code = router.currentRoute.value.meta?.code
    if (code === HEADER_CODES.FULL) {
        return '111111111'
    }
    if (code === HEADER_CODES.NONE) {
        return null
    }

    if (code === HEADER_CODES.ITEM) {
        return detailStore.item?.code
    }

    return null
})

const displayTooltip = () => {
    isActive.value = true
    setTimeout(() => {
        isActive.value = false
    }, 3000)
}

itemsStore.$onAction(({ name: actionName }) => {
    if (actionName === 'add') {
        displayTooltip()
    }
})
</script>
