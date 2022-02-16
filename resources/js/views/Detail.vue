<template>
    <div class="border-black border-t-2 flex items-center">
        <router-link to="/">
            <div class="bg-black p-2" >
                <svg class="h-9 w-9" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="4" cy="4" r="3.30435" stroke="white" stroke-width="1.3913"/>
                    <circle cx="4" cy="16" r="3.30435" stroke="white" stroke-width="1.3913"/>
                    <circle cx="4" cy="28" r="4" fill="white"/>
                    <circle cx="16" cy="4" r="4" fill="white"/>
                    <circle cx="16" cy="16" r="4" fill="white"/>
                    <circle cx="16" cy="28" r="4" fill="white"/>
                    <circle cx="28" cy="4" r="4" fill="white"/>
                    <circle cx="28" cy="16" r="3.30435" stroke="white" stroke-width="1.3913"/>
                    <circle cx="28" cy="28" r="3.30435" stroke="white" stroke-width="1.3913"/>
                </svg>
            </div>
        </router-link>
        <h1 class="p-3 grow">{{ $t('SNG Bookmarks') }}</h1>
        <div class="flex pr-4">
            <div class="font-bold text-xl px-2">1</div>
            <svg class="h-9 w-9" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M26 5H6C5.44772 5 5 5.44772 5 6V26C5 26.5523 5.44772 27 6 27H26C26.5523 27 27 26.5523 27 26V6C27 5.44772 26.5523 5 26 5Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M27 19.9998L21.7071 14.707C21.5196 14.5194 21.2652 14.4141 21 14.4141C20.7348 14.4141 20.4804 14.5194 20.2929 14.707L14.7071 20.2927C14.5196 20.4803 14.2652 20.5856 14 20.5856C13.7348 20.5856 13.4804 20.4803 13.2929 20.2927L10.7071 17.707C10.5196 17.5194 10.2652 17.4141 10 17.4141C9.73478 17.4141 9.48043 17.5194 9.29289 17.707L5 21.9999" fill="black"/>
                <path d="M27 19.9998L21.7071 14.707C21.5196 14.5194 21.2652 14.4141 21 14.4141C20.7348 14.4141 20.4804 14.5194 20.2929 14.707L14.7071 20.2927C14.5196 20.4803 14.2652 20.5856 14 20.5856C13.7348 20.5856 13.4804 20.4803 13.2929 20.2927L10.7071 17.707C10.5196 17.5194 10.2652 17.4141 10 17.4141C9.73478 17.4141 9.48043 17.5194 9.29289 17.707L5 21.9999V26.5H27V19.9998Z" fill="black"/>
                <path d="M12.5 13C13.3284 13 14 12.3284 14 11.5C14 10.6716 13.3284 10 12.5 10C11.6716 10 11 10.6716 11 11.5C11 12.3284 11.6716 13 12.5 13Z" fill="black"/>
            </svg>

        </div>
    </div>
    <div class="bg-gray-100 h-48 border-black border-t-2 border-b-2">
        <img class="h-full object-cover w-full" :src="getImageSrc(800)" v-if="item">
    </div>
    <div class="h-full border-black p-4" v-if="item">
        <h2 class="text-xl font-bold">{{ item.title }}</h2>
        <h3 class="">{{ formatName(item.author[0]) }} · {{ item.dating }}</h3>
        <div class="py-4 text-sm" v-html="item.description"></div>
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
                <ConfirmButton class="bg-black text-white">{{ $t('Add new') }}</ConfirmButton>
            </div>
        </div>
    </div>
</template>

<script>
    import ConfirmButton from '../components/ConfirmButton.vue'
    import { getActiveLanguage } from 'laravel-vue-i18n';

    export default {
        components: { ConfirmButton },
        data(){
            return {
                item: null
            }
        },
        async mounted() {
            const { data } = await axios.get(`${process.env.MIX_WEBUMENIA_API}/items/${this.$route.params.id}?locale=${getActiveLanguage()}`)
            this.item = data.document.content
        },
        methods: {
            getImageSrc(size) {
                return `${process.env.MIX_WEBUMENIA_URL}/dielo/nahlad/${this.item.id}/${size}`
            },
            formatName(name) {
                return name.replace(/^([^,]*),\s*(.*)$/, '$2 $1')
            }
        }
    }
</script>