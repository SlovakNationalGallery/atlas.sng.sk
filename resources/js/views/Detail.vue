<template>
    <div class="bg-gray-softest aspect-w-4 aspect-h-3 border-black border-t-2 border-b-2 relative" v-if="item">
        <ItemImageMovable v-if="$route.meta.edit" :item="item"></ItemImageMovable>
        <ItemImageLightbox v-else :item="item"></ItemImageLightbox>
    </div>
    <div class="h-full border-black px-4 pb-24 pt-8 relative" v-if="item">
        <div class="bg-black rounded-md p-1.5 inline-block -top-8 z-index-0 absolute" v-if="item.code">
            <img class="h-9 w-9" :src="`/img/${item.code}.svg`" :alt="item.code" />
        </div>
        <h2 class="text-xl font-bold">{{ item.title }}</h2>
        <h3 class="text-gray-dark text-base">{{ item.author }} · {{ item.dating }}</h3>
        <div class="py-4" v-html="item.description"></div>
        <a
            :href="item.webumenia_url"
            target="_blank"
            class="flex items-center py-2 px-3 mb-4 text-[#32B964] bg-[#E4FAE7] hover:bg-[#caf5d0] active:bg-[#caf5d0] rounded-xl"
        >
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M8.59917 5.02012L9.99136 3.62793C10.5808 3.09069 11.3546 2.80122 12.1519 2.81968C12.9492 2.83814 13.7088 3.1631 14.2727 3.72705C14.8367 4.29099 15.1616 5.05054 15.1801 5.84786C15.1985 6.64518 14.9091 7.41896 14.3718 8.0084L12.382 9.99121C12.0952 10.2791 11.7544 10.5075 11.3792 10.6633C11.0039 10.8192 10.6016 10.8994 10.1953 10.8994C9.78894 10.8994 9.38661 10.8192 9.01136 10.6633C8.63611 10.5075 8.29532 10.2791 8.00854 9.99121"
                    stroke="#32B964"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
                <path
                    d="M9.40083 12.9798L8.00864 14.372C7.41921 14.9093 6.64543 15.1987 5.84811 15.1803C5.05078 15.1618 4.29123 14.8369 3.72729 14.2729C3.16335 13.709 2.83838 12.9494 2.81992 12.1521C2.80146 11.3548 3.09093 10.581 3.62817 9.99156L5.61802 8.00875C5.90479 7.7209 6.24558 7.4925 6.62083 7.33665C6.99608 7.18081 7.39841 7.10059 7.80474 7.10059C8.21106 7.10059 8.61339 7.18081 8.98864 7.33665C9.36389 7.4925 9.70468 7.7209 9.99146 8.00875"
                    stroke="#32B964"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
            <span class="pl-2 font-bold">{{ $t('Learn more on webumenia.sk') }}</span>
        </a>
    </div>
    <div class="w-full md:max-w-lg h-24 fixed bottom-0 bg-white">
        <div class="p-4 pt-2">
            <div class="flex space-x-4">
                <ConfirmButton class="bg-white" @click="returnHome">{{ $t('Find another') }}</ConfirmButton>
                <ConfirmButton
                    v-if="item && itemsStore.exists(item.id)"
                    class="bg-white text-red border-red"
                    @click="itemsStore.remove(item.id)"
                    >{{ $t('Remove') }}</ConfirmButton
                >
                <ConfirmButton v-else class="bg-green" @click="itemsStore.add(item)">
                    <svg class="mr-3 w-6 h-6 stroke-black stroke-2 fill-green" viewBox="0 0 25 22" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13.7382 19.5758L13.7416 19.5724L21.3354 11.9786L21.3371 11.9768C23.5245 9.77851 23.9117 6.11062 21.7475 3.70364C21.215 3.109 20.5669 2.62911 19.8427 2.29327C19.1181 1.95727 18.3327 1.77252 17.5344 1.75032C16.736 1.72811 15.9415 1.86892 15.1994 2.16412C14.4573 2.45933 13.7832 2.90275 13.2183 3.46727L13.2157 3.46986L12.5005 4.18977L11.9818 3.6671L11.9818 3.66709L11.9773 3.66264C9.779 1.4753 6.1111 1.08803 3.70413 3.25224C3.10948 3.78478 2.6296 4.43291 2.29376 5.15709C1.95776 5.88162 1.77301 6.66706 1.75081 7.46541C1.7286 8.26376 1.8694 9.05825 2.16461 9.80034L3.09379 9.43071L2.16461 9.80034C2.45982 10.5424 2.90324 11.2165 3.46776 11.7815L3.46802 11.7817L11.2586 19.5724L11.2621 19.5758C11.5915 19.9021 12.0364 20.0851 12.5001 20.0851C12.9638 20.0851 13.4088 19.9021 13.7382 19.5758Z"
                            stroke-linecap="round" stroke-linejoin="bevel" />
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
import { useItemsStore } from '../stores/ItemsStore'
import ConfirmButton from '../components/ConfirmButton.vue'
import ItemImageLightbox from '../components/ItemImageLightbox.vue'
import ItemImageMovable from '../components/ItemImageMovable.vue'
import { useDetailStore } from '../stores/DetailStore'

const router = useRouter()
const route = useRoute()
const itemsStore = useItemsStore()
const detailStore = useDetailStore()
const item = ref(null)

onMounted(async () => {
    item.value = await detailStore.addItem(route.params.id)
})

const returnHome = () => {
    router.push('/')
}
</script>
