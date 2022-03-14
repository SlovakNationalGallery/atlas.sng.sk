<template>
    <Header :code="1">{{ $t('Artwork detail') }}</Header>
    <div class="bg-gray-softest h-48 border-black border-t-2 border-b-2 relative">
        <img class="h-full object-cover w-full" :src="item.image" v-if="item">
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
    <div class="h-full border-black p-4" v-if="item">
        <h2 class="text-xl font-bold">{{ item.title }}</h2>
        <h3 class="text-gray-dark text-base">{{ item.author }} · {{ item.dating }}</h3>
        <div class="py-4 pb-24" v-html="item.description"></div>
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

    export default {
        components: { ConfirmButton, Header },
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