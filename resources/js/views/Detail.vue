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
        <h1 class="p-3">{{ $t('SNG Bookmarks') }}</h1>
    </div>
    <div class="bg-gray-200 h-48 border-black border-t-2">
        <img class="h-full object-cover w-full" :src="getImage(item, 800)" v-if="item">
        <!-- preview image -->
    </div>
    <div class="h-full border-black border-t-2 p-4" v-if="item">
        <h2 class="text-xl font-bold">{{ item.title }}</h2>
        <h3 class="">{{ formatName(item.author[0]) }} · {{ item.dating }}</h3>
        <div class="py-4 text-sm" v-html="item.description"></div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                item: null
            }
        },
        async mounted() {
            const { data } = await axios.get(`${process.env.MIX_WEBUMENIA_API}/items/${this.$route.params.id}`)
            this.item = data.document.content
        },
        methods: {
            getImage(item, size) {
                return `${process.env.MIX_WEBUMENIA_URL}/dielo/nahlad/${item.id}/${size}`
            },
            formatName(name) {
                return name.replace(/^([^,]*),\s*(.*)$/, '$2 $1')
            }
        }
    }
</script>