<template>
    <router-link :to="'/detail/' + itemId">
        <div class="flex my-4">
            <div class="h-24 w-24 flex-none border-black border-2 flex items-center justify-center bg-gray-softest">
                <img class="h-full object-cover w-full" :src="item.image" v-if="item">
            </div>
            <div class="py-2 px-4 shrink" v-if="item">
                <h2 class="text-base pb-1">{{ item.title }}</h2>
                <div class="text-sm text-gray-dark">{{ item.author }} · {{ item.dating }}</div>
            </div>
        </div>
    </router-link>
</template>

<script setup>
    import { onMounted, ref } from "vue"
    import { getActiveLanguage } from 'laravel-vue-i18n';
    const props = defineProps( [ 'itemId' ] )
    const item = ref(null)

    onMounted(async () => {
         const response = await axios.get(`/api/items/${props.itemId}`, {headers: {
             'X-locale': getActiveLanguage()
         }})
         item.value = response.data.data
    })
</script>