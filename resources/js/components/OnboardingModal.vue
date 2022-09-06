<template>
    <div
        class="md:max-w-lg md:mx-auto fixed inset-0 z-50 flex justify-center items-center overflow-hidden"
        v-if="visible"
    >
        <div class="bg-black opacity-70 absolute inset-0 cursor-zoom-out" @click="close" />
        <Carousel :items-to-show="2.1" :wrap-around="true" class="min-w-[calc(190%)]" ref="myCarousel">
            <Slide :key="0">
                <OnboardingStep
                    :btnFn="next"
                    :title="'Collect art'"
                    :body1="'Save interesting artworks from the exhibition to your mobile device.'"
                    :body2="'Insert the code located by the artwork into the grid. Press save in the artwork profile to collect it.'"
                    :btnText="'Next'"
                    :active-step="1"
                />
            </Slide>
            <Slide :key="1">
                <OnboardingStep
                    :btnFn="next"
                    :title="'Create a collection'"
                    :body1="'Saved artworks are added into your collection. Return to them later to find out more.'"
                    :body2="'The collection will persist even after you close the application.'"
                    :btnText="'Next'"
                    :active-step="2"
                />
            </Slide>
            <Slide :key="3">
                <OnboardingStep
                    :btnFn="close"
                    :title="'Share the collection'"
                    :body1="'Tap the Share button in your collection, and send the link to your e-mail or share it with friends.'"
                    :body2="'The shared link never expires.'"
                    :btnText="'Start collecting'"
                    :active-step="3"
                />
            </Slide>
        </Carousel>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Carousel, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'
import OnboardingStep from '../components/OnboardingStep.vue'

const props = defineProps({
    visible: Boolean,
})

const myCarousel = ref(null)
const emit = defineEmits(['close'])

const next = () => myCarousel.value?.next()
const close = () => emit('close')
</script>
