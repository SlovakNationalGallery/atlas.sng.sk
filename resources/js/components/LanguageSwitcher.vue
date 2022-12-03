<template>
    <div class="bg-black flex items-center mx-2.5 px-1 py-0.5 rounded-full text-white">
        <button
            @click="switchLanguage('sk')"
            class="px-1 uppercase"
            :class="{ 'text-green': localeStore.locale === 'sk' }"
        >
            SK
        </button>
        <svg class="h-[20px] w-[1px] fill-gray-dark">
            <rect y="0.5" width="1" height="20" rx="0.5" />
        </svg>
        <button
            @click="switchLanguage('en')"
            class="px-1 uppercase"
            :class="{ 'text-green': localeStore.locale === 'en' }"
        >
            EN
        </button>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import { useItemsStore } from '../stores/ItemsStore'
import { useLocaleStore } from '../stores/LocaleStore'

const router = useRouter()
const itemsStore = useItemsStore()
const localeStore = useLocaleStore()

const switchLanguage = (locale) => {
    itemsStore.clearItemsFromState()
    localeStore.locale = locale
    router.go()
}
</script>
