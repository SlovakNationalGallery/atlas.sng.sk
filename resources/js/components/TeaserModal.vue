<template>
    <div class="fixed inset-0 z-50 flex justify-center items-center" v-if="visible">
        <div class="bg-black opacity-70 absolute inset-0 cursor-zoom-out" @click="emit('close')" />
        <div class="relative mx-4 bg-white w-full max-w-2xl bg-white rounded-xl">
            <img src="/images/dusan-vyklad.jpg" alt="Výklad kurátora Dušana Burana" class="w-full rounded-t-xl" />
            <div class="px-4 py-6">
                <h3 class="font-bold text-lg mb-2">{{ $t('Curator\'s insight in your pocket') }}</h3>
                <div class="">
                    {{ $t('How does the Gothic altar work? Why are some statues missing their hands? What is the purpose of gilding?') }}
                </div>
                <div class="mt-4" v-html="$t('Find simple <b>codes in the exhibition</b> and discover the secrets of medieval artistic workshops.')"></div>
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
