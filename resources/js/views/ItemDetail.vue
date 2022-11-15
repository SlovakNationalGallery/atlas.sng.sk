<template>
    <div class="bg-gray-softest aspect-w-4 aspect-h-3 border-black border-b-2 relative" v-if="item">
        <ItemImageMovable v-if="$route.meta.edit" :item="item"></ItemImageMovable>
        <ItemImageLightbox v-else :item="item"></ItemImageLightbox>
    </div>
    <div class="h-full border-black px-4 pb-24 pt-8 relative" v-if="item">
        <div class="bg-black rounded-md p-1.5 inline-block -top-8 absolute" v-if="item.code">
            <img class="h-9 w-9" :src="`/img/${item.code}.svg`" :alt="item.code" />
        </div>
        <h2 class="text-xl font-bold">{{ item.title }}</h2>
        <h3 class="text-gray-dark text-base">{{ item.author }} · {{ item.dating }}</h3>
        <div class="py-4" v-html="item.description"></div>
        <Collapsible :open="i === 0" v-for="(authority, i) in item.authorities" :key="authority.id" class="mb-4">
            <template v-slot:summary>
                <AuthoritySummary :authority="authority" />
            </template>
            <template v-slot:content v-if="authority.biography">
                <AuthorityDetails :authority="authority" />
            </template>
        </Collapsible>
        <WebumeniaButton :url="item.webumenia_url" class="mb-4" />
    </div>
    <div class="w-full md:max-w-lg h-24 fixed bottom-0 bg-gradient-to-t from-white to-transparent pointer-events-none">
        <div class="p-4 pt-8">
            <div class="flex space-x-4 pointer-events-auto">
                <ConfirmButton class="bg-white" @click="returnHome">{{ $t('Find another') }}</ConfirmButton>
                <ConfirmButton v-if="item && itemsStore.exists(item.id)" class="bg-white text-red border-red"
                    @click="itemsStore.remove(item.id)">{{ $t('Remove') }}</ConfirmButton>
                <ConfirmButton v-else class="bg-green" @click="itemsStore.add(item)">
                    <svg class="mr-3 w-[25px] h-[22px] stroke-black stroke-2 fill-green">
                        <path class="[stroke-linecap:round] [stroke-linejoin:bevel]"
                            d="M13.7382 19.5758L13.7416 19.5724L21.3354 11.9786L21.3371 11.9768C23.5245 9.77851 23.9117 6.11062 21.7475 3.70364C21.215 3.109 20.5669 2.62911 19.8427 2.29327C19.1181 1.95727 18.3327 1.77252 17.5344 1.75032C16.736 1.72811 15.9415 1.86892 15.1994 2.16412C14.4573 2.45933 13.7832 2.90275 13.2183 3.46727L13.2157 3.46986L12.5005 4.18977L11.9818 3.6671L11.9818 3.66709L11.9773 3.66264C9.779 1.4753 6.1111 1.08803 3.70413 3.25224C3.10948 3.78478 2.6296 4.43291 2.29376 5.15709C1.95776 5.88162 1.77301 6.66706 1.75081 7.46541C1.7286 8.26376 1.8694 9.05825 2.16461 9.80034L3.09379 9.43071L2.16461 9.80034C2.45982 10.5424 2.90324 11.2165 3.46776 11.7815L3.46802 11.7817L11.2586 19.5724L11.2621 19.5758C11.5915 19.9021 12.0364 20.0851 12.5001 20.0851C12.9638 20.0851 13.4088 19.9021 13.7382 19.5758Z" />
                    </svg>
                    {{ $t('Save') }}
                </ConfirmButton>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useDetailStore } from '../stores/DetailStore'
import { useItemsStore } from '../stores/ItemsStore'
import AuthorityDetails from '../components/AuthorityDetails.vue'
import AuthoritySummary from '../components/AuthoritySummary.vue'
import Collapsible from '../components/Collapsible.vue'
import ConfirmButton from '../components/ConfirmButton.vue'
import ItemImageLightbox from '../components/ItemImageLightbox.vue'
import ItemImageMovable from '../components/ItemImageMovable.vue'
import WebumeniaButton from '../components/WebumeniaButton.vue'

const router = useRouter()
const route = useRoute()
const itemsStore = useItemsStore()
const detailStore = useDetailStore()
const item = ref(null)

onMounted(async () => {
    item.value = await detailStore.addItem(route.params.id)
})

const returnHome = () => {
    router.push({
        name: 'home',
    })
}
</script>
