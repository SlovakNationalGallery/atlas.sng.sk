<template>
    <div class="border-black border-y-2 flex items-center h-12 sticky top-0 w-full z-20 bg-white">
        <HistoryBack v-slot="{ back }">
            <div
                @click="$route.name === 'home' ? (openedAbout = !openedAbout) : back()"
                class="cursor-pointer p-2 h-full border-r-2 flex items-center"
                :class="[
                    $route.name === 'home' ? 'bg-green border-r-black' : 'border-r-transparent',
                    $route.name === 'my_collection' ? 'flex-1' : '',
                ]"
            >
                <SvgBack v-if="$route.name !== 'home'" class="ml-2" />
                <SvgClose v-else-if="openedAbout" />
                <SvgLogo v-else />
            </div>
        </HistoryBack>
        <h1 class="grow px-2 text-xl" :class="{ 'text-center': $route.name !== 'home' }">
            {{ $t(openedAbout ? 'About' : $route.meta.title) }}
            <span v-if="$route.name === 'my_collection'">({{ count }})</span>
        </h1>
        <div class="flex-1 px-3 border-l-2 border-transparent text-right" v-if="$route.name === 'my_collection'">
            <button class="bg-green rounded-xl text-sm px-3 py-1 font-bold" @click="scroll('share')">
                {{ $t('Share') }}
            </button>
        </div>
        <LanguageSwitcher v-else-if="$route.name === 'home'" />
        <FavouritesCount v-else class="border-l-2 border-l-transparent px-4 py-2" :show-tooltip="isActive" />
    </div>

    <About :opened="openedAbout" />
</template>

<script setup>
import { computed, ref } from 'vue'
import { useItemsStore } from '../stores/ItemsStore'
import About from './About.vue'
import FavouritesCount from './FavouritesCount.vue'
import HistoryBack from './HistoryBack.vue'
import LanguageSwitcher from './LanguageSwitcher.vue'
import SvgBack from './svg/Back.vue'
import SvgClose from './svg/Close.vue'
import SvgLogo from './svg/Logo.vue'

const openedAbout = ref(false)

const itemsStore = useItemsStore()

const count = computed(() => itemsStore.count)
const isActive = ref(false)

const displayTooltip = () => {
    isActive.value = true
    setTimeout(() => {
        isActive.value = false
    }, 3000)
}

const scroll = (id) => {
    document.getElementById(id).scrollIntoView({
        behavior: 'smooth',
    })
}

itemsStore.$onAction(({ name: actionName }) => {
    if (actionName === 'add') {
        displayTooltip()
    }
})
</script>
