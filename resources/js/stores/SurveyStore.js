import { defineStore, storeToRefs } from 'pinia'
import { ref, computed } from 'vue'
import { useStorage } from '@vueuse/core'
import { useInteractionStore } from './InteractionStore'

export const useSurveyStore = defineStore('survey', () => {
    const interactionStore = useInteractionStore()
    const { viewedItemsCount, stories } = storeToRefs(interactionStore)
    const isDone = ref(useStorage('isSurveyDone', false))
    const wasExited = ref(useStorage('wasExited', false))
  
    const shouldLaunch = computed(() => (viewedItemsCount.value > 1 || stories.value.length > 4) && !wasExited.value)
    function done() {
        isDone.value = true
    }
    function exit() {
        wasExited.value = true
    }

    return { shouldLaunch, isDone, done, exit }
})
