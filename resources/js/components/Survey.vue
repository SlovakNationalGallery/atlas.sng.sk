<template>
    <div v-if="!surveyStore.isDone" class="border-black p-4 border-t-2">
        <h3 class="text-lg font-bold mb-3">
            {{ $t('Help us make the app better') }}
        </h3>
        <div class="mb-4">
            {{ $t('How did you like your experience with the app? Did it match your expectations?') }}
            <br />
            {{ $t('Let us know in the brief online survey.') }}
        </div>
        <ConfirmButton @click="getFeedback" class="bg-black text-white">
            {{ $t('Give feedback') }}
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
