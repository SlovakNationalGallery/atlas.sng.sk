<template>
    <div class="mx-2.5 flex items-center rounded-full bg-black px-1 py-0.5 font-medium text-white">
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
import { useInteractionStore } from '../stores/InteractionStore'
import { useItemStore } from '../stores/ItemStore'
import { useLocaleStore } from '../stores/LocaleStore'
import { useSectionStore } from '../stores/SectionStore'
import { useStoryStore } from '../stores/StoryStore'
import { usePlaceStore } from '../stores/PlaceStore'
import { useBucketlistStore } from '../stores/BucketlistStore'

const router = useRouter()
const interactionStore = useInteractionStore()
const itemStore = useItemStore()
const localeStore = useLocaleStore()
const sectionStore = useSectionStore()
const storyStore = useStoryStore()
const placeStore = usePlaceStore()
const bucketlistStore = useBucketlistStore()

const switchLanguage = (locale) => {
    interactionStore.clear()
    itemStore.clearCache()
    sectionStore.clearCache()
    storyStore.clearCache()
    placeStore.clearCache()
    bucketlistStore.clearCache()
    localeStore.locale = locale
    router.go()
}
</script>
