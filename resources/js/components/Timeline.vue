<template>
    <article class="mt-8 mb-6 px-4">
        <h3 class="flex items-center justify-between gap-x-1 text-1.5xl font-medium leading-6">
            <span class="grow">{{ $t('Explored artworks') }}</span>
            <span>{{ interactionStore.viewedItemsCount }}</span>
            <SvgEye :class="{ '!fill-green': interactionStore.viewedItemsCount }" />
        </h3>
        <!-- <template v-if="interactionStore.viewedItemsCount">
            <ShareCollection class="mt-4" />
            <div class="mt-3">
                {{ $t('Save the link to your artworks and return to them anywhere') }}
            </div>
        </template> -->
        <div class="mt-6 flex flex-col gap-y-3">
            <router-link :to="{ name: 'home', hash: '#code' }">
                <Thumbnail :truncate-description="false" class="border-2">
                    <template #image>
                        <div class="flex h-full w-full items-center justify-center bg-black">
                            <SvgCode />
                        </div>
                    </template>
                    <template #icon>
                        <CaretRight />
                    </template>
                    <template #title>{{ $t('Insert artwork code') }}</template>
                    <template #description>{{ $t('The artwork will be saved to your history') }}</template>
                </Thumbnail>
            </router-link>
            <ItemLoader :id="id" v-slot="{ item }" v-for="id in interactionStore.viewedItemIds" :key="id">
                <router-link :to="{ name: 'item_detail', params: { id } }">
                    <ItemThumbnail :item="item" />
                </router-link>
            </ItemLoader>
        </div>
    </article>
</template>

<script setup>
import { useInteractionStore } from '../stores/InteractionStore'
import ItemLoader from './ItemLoader.vue'
import ItemThumbnail from './ItemThumbnail.vue'
import ShareCollection from './ShareCollection.vue'
import Thumbnail from './Thumbnail.vue'
import SvgCode from './svg/Code.vue'
import SvgEye from './svg/Eye.vue'
import CaretRight from './svg/CaretRight.vue'

const interactionStore = useInteractionStore()
</script>
