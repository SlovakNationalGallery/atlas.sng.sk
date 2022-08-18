<template>
    <div class="border-black border-t-2 flex items-center">
        <router-link to="/">
            <div class="bg-black p-2">
                <img v-if="code" class="h-9 w-9" :src="`/img/${code}.svg`" :alt="code" />
                <svg v-else class="h-9 w-9" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8.54668V17.0934H7.45332H14.9066V23.4533V29.8133H8.54677H2.1869L2.17911 24.5544L2.17132 19.2955L1.08566 19.2874L0 19.2793V25.6396V32H16H32V16V0H16H0V8.54668ZM14.9066 8.54668V14.9066H8.54668H2.18672V8.54668V2.18672H8.54668H14.9066V8.54668ZM29.8057 7.76901C29.81 10.8308 29.803 13.3359 29.7902 13.3359C29.7775 13.3359 27.2585 10.8273 24.1925 7.76125L18.6179 2.18659L24.2079 2.19436L29.7979 2.20212L29.8057 7.76901ZM22.6833 9.33205L28.2579 14.9066H22.6602H17.0626V9.33205C17.0626 6.26603 17.073 3.75746 17.0857 3.75746C17.0984 3.75746 19.6174 6.26603 22.6833 9.33205ZM29.8133 19.7267V22.36H24.5467H19.2801V23.4532V24.5465L24.539 24.5543L29.7979 24.5621L29.8058 27.1877L29.8136 29.8133H23.4381H17.0626V23.4739C17.0626 19.9872 17.0718 17.1252 17.0831 17.1139C17.0944 17.1026 19.9633 17.0934 23.4585 17.0934H29.8133V19.7267Z" fill="white"/>
                </svg>

            </div>
        </router-link>
        <h1 class="pl-3 grow text-xl"><slot></slot></h1>
        <router-link to="/collection" class="relative">
            <div class="flex px-4 py-2 h-full border-black" :class="{ 'border-l-2 bg-green': isActive }" v-if="count">
                <div class="font-bold text-xl pr-2">{{ count }}</div>
                <svg class="h-9 w-9" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 22L16 29L28 22" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M4 16L16 23L28 16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M4 10L16 17L28 10L16 3L4 10Z" fill="black" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div v-if="isActive" class="tooltip absolute right-4 top-[52px] z-50 shadow-lg bg-black border-black border-2">
                <div class="absolute w-3 h-3 top-0 right-[10px] -mt-2 rotate-45 bg-black z-0"></div>
                <div class="w-full h-full bg-green relative p-2 whitespace-nowrap">{{ $t("Saved! Tap this icon to view your collection.") }}</div>
            </div>
        </router-link>
    </div>
</template>

<script setup>
    import { computed, ref } from "vue"
    import { useItemsStore } from '../stores/ItemsStore'

    const itemsStore = useItemsStore()
    const count = computed(() => itemsStore.count)
    const isActive = ref(false)

    const props = defineProps({
        code: String
    })

itemsStore.$subscribe((mutation, state) => {
    state.items.length ? isActive.value = true : isActive.value = false
    })
</script>