<template>
    <div class="p-4">
        <div class="flex flex-col space-y-3">
            <router-link to="/">
                <Thumbnail :truncate-description="false">
                    <template #image>
                        <div class="bg-black flex items-center justify-center h-full w-full">
                            <svg class="fill-none h-[52px] w-[52px]">
                                <circle cx="7.80103" cy="7.79761" r="5.78003" class="stroke-3 stroke-white" />
                                <circle cx="7.80103" cy="25.9978" r="5.78003" class="stroke-3 stroke-white" />
                                <circle cx="7.80103" cy="44.198" r="5.78003" class="stroke-3 stroke-white" />
                                <circle cx="25.9995" cy="8" r="5.5" class="stroke-3 stroke-white" />
                                <circle cx="26.0002" cy="25.9978" r="5.78003" class="stroke-3 stroke-white" />
                                <circle cx="26.0002" cy="44.198" r="5.78003" class="stroke-3 stroke-white" />
                                <circle cx="44.1995" cy="7.79761" r="5.78003" class="stroke-3 stroke-white" />
                                <circle cx="43.9995" cy="26" r="5.5" class="stroke-3 stroke-white" />
                                <circle cx="44.1995" cy="44.198" r="5.78003" class="stroke-3 stroke-white" />
                            </svg>
                        </div>
                    </template>
                    <template #title>{{ $t('Add new artwork') }}</template>
                    <template #description>{{ $t('Enter a new artwork code to add to your collection') }}</template>
                </Thumbnail>
            </router-link>
            <ItemLoader :id="itemId" v-slot="{ item }" v-for="itemId in itemsStore.itemsIds" :key="itemId">
                <router-link :to="{ name: 'item_detail', params: { id: item.id } }">
                    <ItemThumbnail :item="item" />
                </router-link>
            </ItemLoader>
        </div>
        <div v-if="itemsStore.items.length !== 0">
            <button class="pt-6 pb-2 w-full active:text-gray-dark" @click="toggleModal">
                {{ $t('Remove all artworks from collection') }}
            </button>
        </div>
    </div>
    <div class="mt-auto w-full md:max-w-lg bg-green border-black border-t-2" id="share">
        <div class="p-4">
            <div class="flex flex-col">
                <h3 class="text-base font-bold mb-4" v-html="$t('How to revisit collection from home?')">
                </h3>
                <div class="mb-4">
                    {{ $t('Send the collection link to your e-mail or share it with friends.') }}
                    {{ $t('The link does never expire - your collection will stay here even after you close the app.')
                    }}
                    {{ $t('Get back to it later.') }}
                </div>
                <ConfirmButton v-if="!shareUrl" class="bg-black text-white" @click="shareCollection"
                    :disabled="loading">
                    <span v-if="loading">{{ $t('Loading...') }}</span>
                    <span v-else>{{ $t('Share collection link') }}</span>
                </ConfirmButton>
                <ConfirmButton v-else class="bg-black text-white" @click="shareUrlDialog(true)">
                    <div class="flex justify-center items-center">
                        <svg class="mr-2" width="25" height="24" viewBox="0 0 25 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.5 15C8.15685 15 9.5 13.6569 9.5 12C9.5 10.3431 8.15685 9 6.5 9C4.84315 9 3.5 10.3431 3.5 12C3.5 13.6569 4.84315 15 6.5 15Z"
                                stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M17 21.75C18.6569 21.75 20 20.4069 20 18.75C20 17.0931 18.6569 15.75 17 15.75C15.3431 15.75 14 17.0931 14 18.75C14 20.4069 15.3431 21.75 17 21.75Z"
                                stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M17 8.25C18.6569 8.25 20 6.90685 20 5.25C20 3.59315 18.6569 2.25 17 2.25C15.3431 2.25 14 3.59315 14 5.25C14 6.90685 15.3431 8.25 17 8.25Z"
                                stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M14.4782 6.87189L9.02197 10.3781" stroke="white" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9.02197 13.6219L14.4782 17.1281" stroke="white" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div>{{ shareUrl }}</div>
                    </div>
                </ConfirmButton>
            </div>
        </div>
    </div>
    <Survey />
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
import CardModal from '../components/CardModal.vue'
import ConfirmButton from '../components/ConfirmButton.vue'
import ItemLoader from '../components/ItemLoader.vue'
import ItemThumbnail from '../components/ItemThumbnail.vue'
import Survey from '../components/Survey.vue'
import Thumbnail from '../components/Thumbnail.vue'

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
