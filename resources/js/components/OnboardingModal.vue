<template>
    <div
        class="fixed inset-0 z-50 flex justify-center items-center"
        v-if="visible"
    >
        <div
            class="bg-black opacity-70 absolute inset-0 cursor-zoom-out"
            @click="emit('close')"
        />
        <div class="relative mx-4 bg-white w-full max-w-2xl bg-white rounded-xl px-4 py-6">
            <h3 class="font-bold text-2xl my-4">{{ $t('Collect art') }}</h3>
            <div class="text-base mb-4">{{ $t('Save interesting artworks from the exhibition to your mobile device.') }}</div>
            <div class="text-base">{{ $t('Insert the code located by the artwork into the grid. Press save in the artwork profile to collect it.') }}</div>
            <ConfirmButton class="bg-black text-white my-4">{{ $t('Next') }}</ConfirmButton>
            <!-- <ConfirmButton class="bg-black text-white my-4" @click="emit('close')">{{ $t('Close') }}</ConfirmButton> -->
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import ConfirmButton from '../components/ConfirmButton.vue'
const props = defineProps({
    'visible': Boolean
});
const emit = defineEmits(['close']);
</script>