import { onUnmounted, ref, computed } from 'vue'
import { storeToRefs } from 'pinia'
import { useStorage } from '@vueuse/core'
import { createPopup } from '@typeform/embed'
import '@typeform/embed/build/css/popup.css'
import { getActiveLanguage } from 'laravel-vue-i18n'
import { useInteractionStore } from '../stores/InteractionStore'

export function useSurvey() {
    const interactionStore = useInteractionStore()
    const { viewedItemsCount, stories } = storeToRefs(interactionStore)
    const isDone = ref(useStorage('isSurveyDone', false))
    const wasExited = ref(useStorage('wasSurveyExited', false))
    const SURVEY_ID = getActiveLanguage() === 'sk' ? import.meta.env.VITE_SURVEY_SK : import.meta.env.VITE_SURVEY_EN

    const shouldLaunch = computed(() => (viewedItemsCount.value > 1 || stories.value.length > 4) && !wasExited.value)
    function done() {
        isDone.value = true
    }
    function exit() {
        wasExited.value = true
    }

    const { toggle, unmount } = createPopup(SURVEY_ID, { onClose: exit, onSubmit: done })

    onUnmounted(unmount)
    return { toggle, done, exit, shouldLaunch, isDone }
}
