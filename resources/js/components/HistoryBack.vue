<template>
    <slot :back="back"></slot>
</template>

<script setup>
import { useRouter } from 'vue-router'
import { useHistoryStore } from '../stores/HistoryStore'

const router = useRouter()
const historyStore = useHistoryStore()
const surveyStore = useSurveyStore()

const back = () => {
    if (historyStore.getState().back) {
        router.back()
    } else {
        router.push({ name: 'home' })
    }

    surveyStore.backNavigated()
}
</script>
