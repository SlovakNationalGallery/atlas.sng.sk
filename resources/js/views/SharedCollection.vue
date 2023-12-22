<template>
    <article class="mb-6 px-4">
        <div class="mt-6 flex flex-col gap-y-3">
            <ItemLoader :id="id" v-slot="{ item }" v-for="id in sharedCollectionStore.itemsIds" :key="id">
                <router-link :to="{ name: 'item_detail', params: { id }, query: { isGuest: true} }">
                    <ItemThumbnail :item="item" />
                </router-link>
            </ItemLoader>
        </div>
    </article>
</template>

<script setup>
import { onMounted } from 'vue';
import ItemLoader from '../components/ItemLoader.vue'
import ItemThumbnail from '../components/ItemThumbnail.vue'
import { useSharedCollectionStore } from '../stores/SharedCollectionStore';
import { useRoute } from 'vue-router'

const sharedCollectionStore = useSharedCollectionStore()
const props = defineProps(['collectionId'])
const route = useRoute()

onMounted(async () => {
    if (route.params.id) {
        await sharedCollectionStore.fetch(route.params.id);
    }
})
</script>
