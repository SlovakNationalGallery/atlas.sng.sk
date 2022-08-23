<template>
    <Header :code="'111111111'">{{ $t('My collection') }}</Header>
    <Survey />
    <div class="border-black p-4 border-t-2">
        <div v-for="item in itemsStore.itemsIds" :key="item">
            <ThumbRow :item-id="item" />
        </div>

        <router-link to="/">
            <div class="flex my-4">
                <div class="h-24 w-24 border-black border-2 flex items-center justify-center">
                    <svg class="w-9 h-9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5 16h22M16 5v22"
                            stroke="#2F3152"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>
                <div class="py-2 px-4">
                    <h2 class="text-base pb-1">{{ $t('Add new artwork') }}</h2>
                    <div class="text-sm text-gray-dark">
                        {{ $t('Enter a new artwork code') }}
                    </div>
                </div>
            </div>
        </router-link>
        <div v-if="itemsStore.items.length !== 0">
            <hr class="h-0.5 bg-gray-soft border-0 mt-6 mb-2" />
            <button class="py-4 w-full active:text-gray-dark" @click="toggleModal">
                {{ $t('Clear collection') }}
            </button>
        </div>
    </div>
    <div class="mt-auto w-full md:max-w-lg bg-green border-black border-t-2">
        <div class="p-4">
            <div class="flex flex-col">
                <h3
                    class="text-base font-bold mb-4"
                    v-html="$t('Your collection will stay here even after you close the app. Get back to it later.')"
                ></h3>
                <ul class="list-disc list-outside mb-4 ml-4">
                    <li>
                        {{ $t('Send the link to your e-mail or share it with friends.') }}
                    </li>
                    <li>{{ $t('The link never expires.') }}</li>
                </ul>
                <ConfirmButton
                    v-if="!shareUrl"
                    class="bg-black text-white"
                    @click="shareCollection"
                    :disabled="loading"
                >
                    <span v-if="loading">{{ $t('Loading...') }}</span>
                    <span v-else>{{ $t('Share collection link') }}</span>
                </ConfirmButton>
                <ConfirmButton v-else class="bg-black text-white" @click="shareUrlDialog(true)">
                    <div class="flex justify-center items-center">
                        <svg
                            class="mr-2"
                            width="25"
                            height="24"
                            viewBox="0 0 25 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M6.5 15C8.15685 15 9.5 13.6569 9.5 12C9.5 10.3431 8.15685 9 6.5 9C4.84315 9 3.5 10.3431 3.5 12C3.5 13.6569 4.84315 15 6.5 15Z"
                                stroke="white"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M17 21.75C18.6569 21.75 20 20.4069 20 18.75C20 17.0931 18.6569 15.75 17 15.75C15.3431 15.75 14 17.0931 14 18.75C14 20.4069 15.3431 21.75 17 21.75Z"
                                stroke="white"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M17 8.25C18.6569 8.25 20 6.90685 20 5.25C20 3.59315 18.6569 2.25 17 2.25C15.3431 2.25 14 3.59315 14 5.25C14 6.90685 15.3431 8.25 17 8.25Z"
                                stroke="white"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M14.4782 6.87189L9.02197 10.3781"
                                stroke="white"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M9.02197 13.6219L14.4782 17.1281"
                                stroke="white"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                        <div>{{ shareUrl }}</div>
                    </div>
                </ConfirmButton>
            </div>
        </div>
    </div>
    <CardModal @close="toggleModal" :visible="modalActive">
        <h3 class="font-bold text-2xl my-4">{{ $t('Remove all artworks?') }}</h3>
        <div class="text-base">{{ $t('This cannot be undone') }}</div>
        <div class="flex space-x-3">
            <ConfirmButton class="bg-black text-white my-4" @click="removeCollection">{{ $t('Remove') }}</ConfirmButton>
            <ConfirmButton class="my-4" @click="toggleModal">{{ $t('Close') }}</ConfirmButton>
        </div>
    </CardModal>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useItemsStore } from '../stores/ItemsStore'
import ConfirmButton from '../components/ConfirmButton.vue'
import Header from '../components/Header.vue'
import ThumbRow from '../components/ThumbRow.vue'
import CardModal from '../components/CardModal.vue'
import Survey from '../components/Survey.vue'

const route = useRoute()
const itemsStore = useItemsStore()
const modalActive = ref(false)
const loading = ref(false)
const shareUrl = ref('')

const toggleModal = () => {
    modalActive.value = !modalActive.value
}

const removeCollection = () => {
    toggleModal()
    itemsStore.removeAll()
}

const shareCollection = async () => {
    loading.value = true
    shareUrl.value = await itemsStore.getCollectionLink()
    shareUrlDialog()
    loading.value = false
}

const shareUrlDialog = (openLink = false) => {
    if (navigator.share) {
        navigator.share({
            title: 'Moja kolekcia · ' + document.title,
            // text: shareUrl.value,
            url: shareUrl.value,
        })
    } else if (openLink) {
        window.open(shareUrl.value, '_blank').focus()
    }
}

onMounted(async () => {
    if (route.params.id) {
        itemsStore.fetch(route.params.id)
    }
})
</script>
