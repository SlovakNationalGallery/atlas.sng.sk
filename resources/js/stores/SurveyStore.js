import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'
import { createPopup } from '@typeform/embed'
import '@typeform/embed/build/css/popup.css'

const { toggle } = createPopup('<form-id>')

export const useSurveyStore = defineStore('SurveyStore', {
    state: () => ({
        interactionCounter: useStorage('interactionCounter', 0),
        codeVerificationCounter: useStorage('codeVerificationCounter', 0),
        isSurveyDone: useStorage('isSurveyDone', false),
    }),
    actions: {
        backNavigated() {
            if (this.codeVerificationCounter >= 2) {
                this.openTypeForm()
            }
        },
        interactionNavigated() {
            this.interactionCounter++
            if (this.interactionCounter >= 4) {
                this.openTypeForm()
            }
        },
        codeVerified() {
            this.codeVerificationCounter++
        },
        openTypeForm() {
            if (this.isSurveyDone) {
                return
            }

            window.setTimeout(() => {
                this.isSurveyDone = true
            }, 1000)
        },
    },
})
