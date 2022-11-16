<template>
    <div v-if="!surveyStore.isDone" class="border-black p-4 border-t-2">
        <h3 class="text-base font-bold mb-3">
            {{ $t('Help us improve the app for you!') }}
        </h3>
        <div class="mb-4">
            {{ $t('Did you enjoy your experience? What would you change to make it better for you?') }}
            {{ $t('Let us know in the brief survey below!') }}
        </div>
        <ConfirmButton @click="getFeedback" class="bg-white text-black">
            {{ $t('Give feedback') }} (3 min)
        </ConfirmButton>
    </div>
</template>

<script setup>
import { useSurveyStore } from '../stores/SurveyStore'
import { getActiveLanguage } from 'laravel-vue-i18n'
import { SURVEY_SK, SURVEY_EN } from '../consts'
import ConfirmButton from '../components/ConfirmButton.vue'

const surveyStore = useSurveyStore()

const getFeedback = () => {
    surveyStore.done()
    if (getActiveLanguage() == 'sk') {
        window.open(SURVEY_SK, '_blank').focus()
    } else {
        window.open(SURVEY_EN, '_blank').focus()
    }
}
</script>
