<template>
    <article class="mt-8 mb-6 px-4">
        <h3 class="flex items-center justify-between gap-x-2 text-1.5xl font-medium leading-6">
            <span class="grow">{{ $t('Your timeline') }}</span>
            <span>{{ itemStore.viewedCount }}</span>
            <SvgEye />
        </h3>
        <template v-if="itemStore.viewedCount">
            <ShareCollection class="mt-4" />
            <div class="mt-3">
                {{ $t('Save this link and study the artworks in depth even after you leave the museum') }}
            </div>
        </template>
        <div class="mt-6 flex flex-col gap-y-3">
            <router-link :to="{ name: 'home', hash: '#code' }">
                <Thumbnail :truncate-description="false">
                    <template #image>
                        <div class="flex h-full w-full items-center justify-center bg-black">
                            <SvgCode />
                        </div>
                    </template>
                    <template #title>{{ $t('Add new artwork') }}</template>
                    <template #description>{{ $t('Enter the artwork code and add it to your collection') }}</template>
                </Thumbnail>
            </router-link>
            <ItemLoader :id="id" v-slot="{ item }" v-for="id in itemStore.viewedIds" :key="id">
                <router-link :to="{ name: 'item_detail', params: { id } }">
                    <ItemThumbnail :item="item" />
                </router-link>
            </ItemLoader>
        </div>
    </article>
</template>

<script setup>
import { useItemStore } from '../stores/ItemStore'
import ItemLoader from './ItemLoader.vue'
import ItemThumbnail from './ItemThumbnail.vue'
import ShareCollection from './ShareCollection.vue'
import Thumbnail from './Thumbnail.vue'
import SvgCode from './svg/Code.vue'
import SvgEye from './svg/Eye.vue'

const itemStore = useItemStore()
</script>
