<template>
    <Header :code="(item!==null) ? item.code : '000000000'">{{ $t('Artwork detail') }}</Header>
    <div class="bg-gray-softest h-48 border-black border-t-2 border-b-2 relative">
        <ItemImageLightbox v-if="item" :item="item"></ItemImageLightbox>
        <svg class="absolute bottom-3 left-3 w-8" fill="none" viewBox="0 0 32 35" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#a)" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
            <path d="m21 6h5v5"/>
            <path d="m19 13 7-7"/>
            <path d="M11 26H6V21"/>
            <path d="m13 19-7 7"/>
            <path d="m26 21v5h-5"/>
            <path d="m19 19 7 7"/>
            <path d="m6 11v-5h5"/>
            <path d="m13 13-7-7"/>
            </g>
            <defs>
            <filter id="a" x="-4" y="0" width="40" height="40" color-interpolation-filters="sRGB" filterUnits="userSpaceOnUse">
            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
            <feColorMatrix in="SourceAlpha" result="hardAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/>
            <feOffset dy="4"/>
            <feGaussianBlur stdDeviation="2"/>
            <feComposite in2="hardAlpha" operator="out"/>
            <feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
            <feBlend in2="BackgroundImageFix" result="effect1_dropShadow_2433_18536"/>
            <feBlend in="SourceGraphic" in2="effect1_dropShadow_2433_18536" result="shape"/>
            </filter>
            </defs>
        </svg>

    </div>
    <div class="h-full border-black p-4 pb-24" v-if="item">
        <h2 class="text-xl font-bold">{{ item.title }}</h2>
        <h3 class="text-gray-dark text-base">{{ item.author }} · {{ item.dating }}</h3>
        <div class="py-4" v-html="item.description"></div>
        <a :href="item.webumenia_url" target="_blank" class="flex items-center py-2 px-3 mb-4 text-[#32B964] bg-[#E4FAE7] hover:bg-[#caf5d0] active:bg-[#caf5d0] rounded-xl">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8.59917 5.02012L9.99136 3.62793C10.5808 3.09069 11.3546 2.80122 12.1519 2.81968C12.9492 2.83814 13.7088 3.1631 14.2727 3.72705C14.8367 4.29099 15.1616 5.05054 15.1801 5.84786C15.1985 6.64518 14.9091 7.41896 14.3718 8.0084L12.382 9.99121C12.0952 10.2791 11.7544 10.5075 11.3792 10.6633C11.0039 10.8192 10.6016 10.8994 10.1953 10.8994C9.78894 10.8994 9.38661 10.8192 9.01136 10.6633C8.63611 10.5075 8.29532 10.2791 8.00854 9.99121" stroke="#32B964" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M9.40083 12.9798L8.00864 14.372C7.41921 14.9093 6.64543 15.1987 5.84811 15.1803C5.05078 15.1618 4.29123 14.8369 3.72729 14.2729C3.16335 13.709 2.83838 12.9494 2.81992 12.1521C2.80146 11.3548 3.09093 10.581 3.62817 9.99156L5.61802 8.00875C5.90479 7.7209 6.24558 7.4925 6.62083 7.33665C6.99608 7.18081 7.39841 7.10059 7.80474 7.10059C8.21106 7.10059 8.61339 7.18081 8.98864 7.33665C9.36389 7.4925 9.70468 7.7209 9.99146 8.00875" stroke="#32B964" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="pl-2 font-bold">{{ $t('Learn more on webumenia.sk') }}</span>
        </a>
    </div>
    <div class="w-full h-24 fixed bottom-0 bg-white">
        <div class="p-4">
            <div class="flex space-x-4">
                <ConfirmButton class="bg-white"><router-link to="/">{{ $t('Find another') }}</router-link></ConfirmButton>
                <ConfirmButton v-if="item && itemsStore.exists(item.id)" class="bg-white text-red border-red" @click="itemsStore.remove(item.id)">{{ $t('Remove') }}</ConfirmButton>
                <ConfirmButton v-else class="bg-black text-white" @click="itemsStore.add(item.id)">{{ $t('Save') }}</ConfirmButton>
            </div>
        </div>
    </div>
</template>

<script>
    import {ref, onMounted} from 'vue'
    import { useRoute } from 'vue-router'
    import { getActiveLanguage } from 'laravel-vue-i18n';
    import { useItemsStore } from '../stores/ItemsStore'
    import ConfirmButton from '../components/ConfirmButton.vue'
    import Header from '../components/Header.vue'
    import ItemImageLightbox from '../components/ItemImageLightbox.vue'

    export default {
        components: { ConfirmButton, Header , ItemImageLightbox },
        setup() {
            const item = ref(null)
            const route = useRoute()
            const itemsStore = useItemsStore()

            onMounted(async () => {
                 const response = await axios.get(`/api/items/${route.params.id}`, {headers: {
                     'X-locale': getActiveLanguage()
                 }})
                 item.value = response.data.data
            })

            return { item, itemsStore }
        }
    }
</script>