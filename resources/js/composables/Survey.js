import { onUnmounted } from 'vue'
import { createPopup } from '@typeform/embed'
import '@typeform/embed/build/css/popup.css'
import { getActiveLanguage } from 'laravel-vue-i18n'
import { useSurveyStore } from '../stores/SurveyStore'

export function useSurvey() {
    const surveyStore = useSurveyStore()
    const SURVEY_ID = getActiveLanguage() === 'sk' ? import.meta.env.VITE_SURVEY_SK : import.meta.env.VITE_SURVEY_EN
    const { toggle, unmount } = createPopup(SURVEY_ID, { onClose: surveyStore.exit, onSubmit: surveyStore.done })
    onUnmounted(unmount)
    return { toggle }
}
