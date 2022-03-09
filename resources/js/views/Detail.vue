<template>
    <Header :code="1">{{ $t('Artwork detail') }}</Header>
    <div class="bg-gray-100 h-48 border-black border-t-2 border-b-2">
        <img class="h-full object-cover w-full" :src="item.image" v-if="item">
    </div>
    <div class="h-full border-black p-4" v-if="item">
        <h2 class="text-xl font-bold">{{ item.title }}</h2>
        <h3 class="">{{ item.author }} · {{ item.dating }}</h3>
        <div class="py-4 text-sm pb-48" v-html="item.description"></div>
    </div>
    <div class="bg-gray-100 w-full h-48 fixed bottom-0">
        <div class="p-4">
            <div class="flex items-center">
                <svg class="" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M11.25 11.25H12V16.5H12.75" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M11.8125 9C12.4338 9 12.9375 8.49632 12.9375 7.875C12.9375 7.25368 12.4338 6.75 11.8125 6.75C11.1912 6.75 10.6875 7.25368 10.6875 7.875C10.6875 8.49632 11.1912 9 11.8125 9Z" fill="black"/>
                </svg>
                <div class="pl-2 font-bold">{{ $t('More info later. Keep collecting!')}}</div>
            </div>
            <div class="py-4 text-sm">
                {{ $t('You’ll see more details when you share the collection and view it from another device. Keep collecting!') }}
            </div>
            <div class="flex space-x-4">
                <ConfirmButton class="bg-white"><router-link to="/">{{ $t('Don’t add') }}</router-link></ConfirmButton>
                <ConfirmButton class="bg-black text-white" @click="itemsStore.add(item.id)">{{ $t('Add new') }}</ConfirmButton>
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