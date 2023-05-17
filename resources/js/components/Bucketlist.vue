<template>
    <article v-if="bucketlist">
        <div class="bg-green/20 p-4">
            <h2 class="mt-2 text-xl font-medium leading-6">{{ $t('Hidden artworks') }}</h2>
            <p class="mt-4 text-3xl font-bold leading-8">
                {{ found.length }}/{{ bucketlist.items.length }} {{ $t('collected') }}
            </p>
            <p class="mt-4">{{ $t('Nájdi všetky diela v zozname nižšie a odhalíš ich tajomstvo') }}</p>
        </div>
        <div class="mt-6 px-4" v-if="found.length">
            <h3 class="mt-2 text-1.5xl font-medium leading-6">{{ $t('Found') }}</h3>
            <div class="mt-4 flex flex-col gap-y-4">
                <router-link
                    :to="{ name: 'item_detail', params: { id: item.id } }"
                    v-for="item in found"
                    :key="item.id"
                >
                    <ItemThumbnail :item="item" />
                </router-link>
            </div>
        </div>
        <div class="mt-6 px-4" v-if="notFound.length">
            <h3 class="text-1.5xl font-medium leading-6">{{ $t('Not found yet') }}</h3>
            <div class="mt-4 flex flex-col gap-y-4">
                <LockedItemThumbnail :item="item" v-for="item in notFound" :key="item.id" />
            </div>
        </div>
    </article>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { useBucketlistStore } from '../stores/BucketlistStore'
import LockedItemThumbnail from './LockedItemThumbnail.vue'
import ItemThumbnail from './ItemThumbnail.vue'
import { useItemStore } from '../stores/ItemStore'

const bucketlistStore = useBucketlistStore()
const itemStore = useItemStore()
const props = defineProps(['id'])
const bucketlist = ref(null)

const found = computed(() => {
    return bucketlist.value.items.filter((item) => itemStore.isViewed(item.id))
})

const notFound = computed(() => {
    return bucketlist.value.items.filter((item) => !itemStore.isViewed(item.id))
})

onMounted(async () => {
    bucketlist.value = bucketlistStore.get(props.id) || (await bucketlistStore.load(props.id))
})
</script>
