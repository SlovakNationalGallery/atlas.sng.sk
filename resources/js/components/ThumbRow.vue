<template>
    <router-link :to="'/detail/' + itemId">
        <div class="flex my-4">
            <div class="h-24 w-24 flex-none border-black border-2 flex items-center justify-center bg-gray-softest">
                <ItemImage v-if="item" :item="item"></ItemImage>
            </div>
            <div class="py-2 px-4 shrink" v-if="item">
                <h2 class="text-base pb-1">{{ item.title }}</h2>
                <div class="text-sm text-gray-dark">{{ item.author }} · {{ item.dating }}</div>
            </div>
        </div>
    </router-link>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import ItemImage from './ItemImage.vue'
import { useItemsStore } from '../stores/ItemsStore'

const props = defineProps(['itemId'])
const item = ref(null)

onMounted(async () => {
    const itemsStore = useItemsStore()
    item.value = await itemsStore.get(props.itemId)
})
</script>
