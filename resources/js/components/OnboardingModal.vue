<template>
    <div class="fixed inset-0 z-50 flex justify-center items-center" v-if="visible">
        <div
            class="bg-black opacity-70 absolute inset-0 cursor-zoom-out"
            @click="
                reset(),
                emit('close')
            "
        />

        <OnboardingStep v-if="step == 0">
            <h3 class="font-bold text-2xl my-4">{{ $t('Collect art') }}</h3>
            <div
                class="text-base mb-4"
                v-html="$t('Save interesting artworks from the exhibition to your mobile device.')"
            ></div>
            <div
                class="text-base"
                v-html="
                    $t(
                        'Insert the code located by the artwork into the grid. Press save in the artwork profile to collect it.'
                    )
                "
            ></div>
            <ConfirmButton class="bg-black text-white my-4" @click="next">{{ $t('Next') }}</ConfirmButton>
        </OnboardingStep>

        <OnboardingStep v-if="step == 1">
            <h3 class="font-bold text-2xl my-4">{{ $t('Create a collection') }}</h3>
            <div
                class="text-base mb-4"
                v-html="$t('Saved artworks are added into your collection. Return to them later to find out more.')"
            ></div>
            <div
                class="text-base"
                v-html="$t('The collection will persist even after you close the application.')"
            ></div>
            <ConfirmButton class="bg-black text-white my-4" @click="next">{{ $t('Next') }}</ConfirmButton>
        </OnboardingStep>

        <OnboardingStep v-if="step == 2">
            <h3 class="font-bold text-2xl my-4">{{ $t('Share the collection') }}</h3>
            <div
                class="text-base mb-4"
                v-html="
                    $t(
                        'Tap the Share button in your collection, and send the link to your e-mail or share it with friends.'
                    )
                "
            ></div>
            <div class="text-base font-bold">{{ $t('The shared link never expires.') }}</div>
            <ConfirmButton
                class="bg-black text-white my-4"
                @click="
                    reset(),
                    emit('close')
                "
                >{{ $t('Start collecting') }}</ConfirmButton
            >
        </OnboardingStep>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import ConfirmButton from '../components/ConfirmButton.vue'
import OnboardingStep from '../components/OnboardingStep.vue'

const props = defineProps({
    visible: Boolean,
})

const step = ref(0)

const emit = defineEmits(['close'])

const next = () => {
    step.value++
}
const reset = () => {
    step.value = 0
}
</script>
