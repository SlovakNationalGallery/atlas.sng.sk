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
            <h3 class="font-bold text-2xl my-4">{{ $t('We are still working on this feature') }}</h3>
            <div class="text-base">{{ $t('Check back again soon.') }}</div>
            <ConfirmButton class="bg-black text-white my-4" @click="emit('close')">{{ $t('Close') }}</ConfirmButton>
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