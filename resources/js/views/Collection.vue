<template>
    <Header :code="'111111111'">{{ $t('My collection') }}</Header>

    <div class="h-full border-black p-4 pb-24 border-t-2">
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
                    <div class="text-sm text-gray-dark">{{ $t('Enter a new artwork code') }}</div>
                </div>
            </div>
        </router-link>
        <hr class="h-0.5 bg-gray-soft border-0 mt-6 mb-2">
        <button class="py-4 w-full active:text-gray-dark" @click="toggleModal">
            {{ $t('Clear collection') }}
        </button>
    </div>
    <div class="w-full md:max-w-lg h-24 fixed bottom-0 bg-white">
        <div class="p-4">
            <div class="flex space-x-4">
                <ConfirmButton class="bg-black text-white" @click="shareCollection" :disabled="loading">
                    <span v-if="loading">{{ $t('Loading...') }}</span>
                    <span v-else>{{ $t('Share collection link') }}</span>
                </ConfirmButton>
            </div>
        </div>
    </div>
    <CardModal @close="toggleModal" :visible="modalActive"></CardModal>
</template>

<script setup>
import {ref, onMounted} from 'vue'
import { useRoute } from 'vue-router'
import { useItemsStore } from '../stores/ItemsStore'
import ConfirmButton from '../components/ConfirmButton.vue'
import Header from '../components/Header.vue'
import ThumbRow from '../components/ThumbRow.vue'
import CardModal from '../components/CardModal.vue'

const route = useRoute()
const itemsStore = useItemsStore()
const modalActive = ref(false)
const loading = ref(false)
const toggleModal = () => {
    modalActive.value = !modalActive.value;
};

const shareCollection = () => {
    loading.value = true
    axios.post('/api/collections', {
        'items': itemsStore.items
      })
      .then((res) => {
        // todo
        console.log("podarilo sa! url je: " + res.data.url)
      })
      .catch((err) => {
        console.log(err)
      }).finally(() => {
        loading.value = false
      })
};

onMounted(async () => {
    if (route.params.id) {
        itemsStore.fetch(route.params.id)
    }
})

</script>