<template>
    <div class="fixed inset-0 z-50 flex justify-center items-center" v-if="visible">
        <div class="bg-black opacity-70 absolute inset-0 cursor-zoom-out" @click="emit('close')" />
        <div class="relative mx-4 bg-white w-full max-w-2xl bg-white rounded-xl">
            <img src="/images/koller.jpg" srcset="/images/koller@2x.jpg 2x" alt="U.F.O.-naut J.K." class="w-full rounded-t-xl" />
            <div class="px-4 py-6">
                <h3 class="font-bold text-lg mb-2">{{ $t('What does Július Koller see?') }}</h3>
                <div class="">
                    {{ $t('Invasion of Czechoslovakia inspired the artist to create an UFO-themed alter-ego.') }}
                </div>
                <div class="mt-4" v-html="$t('Insert the <b>code by the artwork</b> and find out more.')"></div>
                <ConfirmButton class="bg-black text-white my-4" @click="emit('close')">{{ $t('OK') }}</ConfirmButton>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import ConfirmButton from '../components/ConfirmButton.vue'
const props = defineProps({
    visible: Boolean,
})
const emit = defineEmits(['close'])
</script>
