<template>
    <article v-if="bucketlist" class="space-y-6">
        <div class="space-y-4">
            <h2 class="text-2xl font-medium leading-6">{{ $t('Scavenger hunt:') }} {{ bucketlist.title }}</h2>
            <p class="text-3xl font-bold leading-snug">
                {{
                    unlocked
                        ? $t('All artworks found')
                        : $t(':found of :all artworks found', { found: found.length, all: bucketlist.items.length })
                }}
            </p>
            <p class="text-2xl">
                {{
                    unlocked
                        ? $t('Check out the reward!')
                        : $t(
                              'Find and explore all the works in the list. Discover what they have in common and unlock your reward.'
                          )
                }}
            </p>
        </div>
        <div>
            <h3 class="text-1.5xl font-medium capitalize leading-6">{{ $t('reward') }}</h3>
            <p v-if="!unlocked" class="pt-1">{{ $t('The story unlocks when all artworks have been found') }}</p>
            <router-link
                :class="[{ 'pointer-events-none': !unlocked }, 'block']"
                :to="{ name: 'reward_detail', params: { id: bucketlist.id } }"
            >
                <Thumbnail class="mt-4" :class="[unlocked ? 'bg-green' : 'bg-green/20']" :truncate-description="false">
                    <template #image>
                        <div class="absolute inset-0 z-10 bg-green/20"></div>
                        <ResponsiveImageWithSizes
                            :class="{ grayscale: !unlocked }"
                            class="h-full w-full rounded-xl object-cover"
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
        <div v-if="found.length">
            <h3 class="text-1.5xl font-medium leading-6">{{ $t('Found') }}</h3>
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
        <div>
            <h3 class="text-1.5xl font-medium leading-6">{{ $t('Not found yet') }}</h3>
            <div class="mt-4 flex flex-col gap-y-4">
                <router-link
                    v-for="item in notFound"
                    :key="item.id"
                    :to="{ name: 'locked_item_detail', params: { id: item.id } }"
                >
                    <LockedItemThumbnail :item="item" />
                </router-link>
            </div>
        </div>
    </article>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { useBucketlistStore } from '../stores/BucketlistStore'
import { useInteractionStore } from '../stores/InteractionStore'
import LockedItemThumbnail from './LockedItemThumbnail.vue'
import ItemThumbnail from './ItemThumbnail.vue'
import Thumbnail from './Thumbnail.vue'
import ResponsiveImageWithSizes from './ResponsiveImageWithSizes.vue'
import SvgLock from './svg/Lock.vue'

const bucketlistStore = useBucketlistStore()
const interactionStore = useInteractionStore()
const props = defineProps(['id'])
const bucketlist = ref(null)

const found = computed(() => {
    return bucketlist.value?.items.filter((item) => interactionStore.isItemViewed(item.id))
})

const notFound = computed(() => {
    return bucketlist.value?.items.filter((item) => !interactionStore.isItemViewed(item.id))
})

const unlocked = computed(() => !notFound.value.length)

onMounted(async () => {
    bucketlist.value = bucketlistStore.get(props.id)
    bucketlist.value = await bucketlistStore.load(props.id)
})
</script>
