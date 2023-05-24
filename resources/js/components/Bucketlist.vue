<template>
    <article v-if="bucketlist">
        <div class="space-y-4 bg-green/20 px-4 py-6">
            <h2 class="text-xl font-medium leading-6">{{ $t('Set of the month') }}</h2>
            <p class="text-3xl font-bold leading-8">
                <template v-if="unlocked">
                    {{ $t('All artworks found') }}
                </template>
                <template v-else>
                    {{ found.length }}/{{ bucketlist.items.length }} {{ $t('artworks found') }}
                </template>
            </p>
            <router-link class="block" :to="{ name: 'reward_detail', params: { id: bucketlist.id } }">
                <Thumbnail :class="[unlocked ? 'bg-white' : 'bg-gray-dark/15']" :truncate-description="false">
                    <template #image>
                        <ResponsiveImageWithSizes
                            :class="{ grayscale: !unlocked }"
                            class="h-full w-full object-cover"
                            :image="{ src: bucketlist.image.src, srcset: bucketlist.image.srcset }"
                        />
                    </template>
                    <template #title>{{ bucketlist.title }}</template>
                    <template #description>{{
                        $t(
                            unlocked
                                ? 'Explore the topic and claim your reward'
                                : 'Collect all artworks to unlock this story'
                        )
                    }}</template>
                    <template #icon><SvgLock v-if="!unlocked" /></template>
                </Thumbnail>
            </router-link>
        </div>
        <div class="mt-6 px-4" v-if="found.length">
            <h3 class="mt-2 text-1.5xl font-medium leading-6">{{ $t('Found artworks') }}</h3>
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
import { useItemStore } from '../stores/ItemStore'
import LockedItemThumbnail from './LockedItemThumbnail.vue'
import ItemThumbnail from './ItemThumbnail.vue'
import Thumbnail from './Thumbnail.vue'
import ResponsiveImageWithSizes from './ResponsiveImageWithSizes.vue'
import SvgLock from './svg/Lock.vue'

const bucketlistStore = useBucketlistStore()
const itemStore = useItemStore()
const props = defineProps(['id'])
const bucketlist = ref(null)

const found = computed(() => {
    return bucketlist.value?.items.filter((item) => itemStore.isViewed(item.id))
})

const notFound = computed(() => {
    return bucketlist.value?.items.filter((item) => !itemStore.isViewed(item.id))
})

const unlocked = computed(() => !notFound.value.length)

onMounted(async () => {
    bucketlist.value = bucketlistStore.get(props.id)
    bucketlist.value = await bucketlistStore.load(props.id)
})
</script>
