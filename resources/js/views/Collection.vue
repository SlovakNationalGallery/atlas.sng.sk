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
                <div class="w-full" v-if="shareUrl">
                    {{ $t('Find your collection on: ') }}
                    <a :href="shareUrl" target="_blank" class="flex items-center py-2 px-3 mb-4 text-[#32B964] bg-[#E4FAE7] hover:bg-[#caf5d0] active:bg-[#caf5d0] rounded-xl">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.59917 5.02012L9.99136 3.62793C10.5808 3.09069 11.3546 2.80122 12.1519 2.81968C12.9492 2.83814 13.7088 3.1631 14.2727 3.72705C14.8367 4.29099 15.1616 5.05054 15.1801 5.84786C15.1985 6.64518 14.9091 7.41896 14.3718 8.0084L12.382 9.99121C12.0952 10.2791 11.7544 10.5075 11.3792 10.6633C11.0039 10.8192 10.6016 10.8994 10.1953 10.8994C9.78894 10.8994 9.38661 10.8192 9.01136 10.6633C8.63611 10.5075 8.29532 10.2791 8.00854 9.99121" stroke="#32B964" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9.40083 12.9798L8.00864 14.372C7.41921 14.9093 6.64543 15.1987 5.84811 15.1803C5.05078 15.1618 4.29123 14.8369 3.72729 14.2729C3.16335 13.709 2.83838 12.9494 2.81992 12.1521C2.80146 11.3548 3.09093 10.581 3.62817 9.99156L5.61802 8.00875C5.90479 7.7209 6.24558 7.4925 6.62083 7.33665C6.99608 7.18081 7.39841 7.10059 7.80474 7.10059C8.21106 7.10059 8.61339 7.18081 8.98864 7.33665C9.36389 7.4925 9.70468 7.7209 9.99146 8.00875" stroke="#32B964" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="pl-2 font-bold">{{ shareUrl }}</span>
                    </a>
                </div>
                <ConfirmButton v-else class="bg-black text-white" @click="shareCollection" :disabled="loading">
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
const shareUrl = ref('')
const toggleModal = () => {
    modalActive.value = !modalActive.value;
};

const shareCollection = () => {
    loading.value = true
    axios.post('/api/collections', {
        'items': itemsStore.items
      })
      .then((res) => {
        console.log("podarilo sa! url je: " + res.data.url)
        shareUrl.value = res.data.url
        if (navigator.share) {
            navigator.share({
                title: 'Moja kolekcia · ' + document.title,
                // text: res.data.url,
                url: res.data.url,
            })
        } else {
            // @todo fallback... modal?
        }
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