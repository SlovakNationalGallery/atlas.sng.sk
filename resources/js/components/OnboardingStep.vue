<template>
    <div class="flex-col flex mx-1 bg-white h-full max-w-2xl rounded-xl px-4 py-6">
        <div class="flex-1 text-left">
            <h3 class="font-bold text-2xl my-4">{{ $t(props.title) }}</h3>
            <div class="text-lg mb-4" v-html="$t(props.body1)" />
            <div class="text-lg" v-html="$t(props.body2)" />
        </div>
        <ConfirmButton class="flex-none bottom-0 bg-black text-white mt-6 mb-4" @click="btnFn">{{
            $t(btnText)
        }}</ConfirmButton>
        <ProgressDots :length="3" :active-step="activeStep"></ProgressDots>
    </div>
</template>

<script setup>
import ConfirmButton from '../components/ConfirmButton.vue'
import ProgressDots from './ProgressDots.vue'

const props = defineProps(['title', 'body1', 'body2', 'btnFn', 'btnText', 'activeStep'])
</script>