<template>
    <Header :code="1">{{ $t('My collection') }}</Header>

    <div class="h-full border-black p-4 border-t-2">
        <div v-for="(item, index) in itemsStore.items">
            <ThumbRow :item-id="item"></ThumbRow>
        </div>

        <router-link to="/">
            <div class="flex my-4">
                <div class="h-24 w-24 border-black border-2 flex items-center justify-center">
                    <svg class="w-9 h-9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 16h22M16 5v22" stroke="#2F3152" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div class="py-2 px-4">
                    <h2 class="text-base pb-1">{{ $t('Add new artwork') }}</h2>
                    <div class="text-sm text-gray-dark">{{ $t('Tap and enter a new artwork code') }}</div>
                </div>
            </div>
        </router-link>
        <hr class="h-0.5 bg-gray-soft border-0 mt-6 mb-2">
        <button class="py-4 w-full active:text-gray-dark">
            {{ $t('Clear collection') }}
        </button>
    </div>
    <div class="w-full h-24 fixed bottom-0">
        <div class="p-4">
            <div class="flex space-x-4">
                <ConfirmButton class="bg-black text-white">{{ $t('Share collection link') }}</ConfirmButton>
            </div>
        </div>
    </div>
</template>

<script setup>
    import {ref, onMounted} from 'vue'
    import { useRoute } from 'vue-router'
    import { getActiveLanguage } from 'laravel-vue-i18n';
    import { useItemsStore } from '../stores/ItemsStore'
    import ConfirmButton from '../components/ConfirmButton.vue'
    import Header from '../components/Header.vue'
    import ThumbRow from '../components/ThumbRow.vue'

    const itemsStore = useItemsStore()

</script>