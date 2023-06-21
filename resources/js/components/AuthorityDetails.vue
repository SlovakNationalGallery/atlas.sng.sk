<template>
    <div class="whitespace-pre-line">{{ authority.biography }}</div>
    <div v-if="authority.related_items">
        <div class="my-3 font-bold">{{ $t('Other works by the artist') }}</div>
        <carousel :items-to-show="2.3" snap-align="start">
            <template v-if="isLoading">
                <slide v-for="itemId in authority.related_items" :key="`skeleton${itemId}`">
                    <div class="min-w-full pr-2">
                        <div class="mb-1 aspect-[4/3] w-full animate-pulse rounded-lg bg-gray-soft"></div>
                        <div class="mb-1 h-3 w-full animate-pulse rounded-lg bg-gray-soft"></div>
                        <div class="mb-1 h-3 w-full animate-pulse rounded-lg bg-gray-soft"></div>
                    </div>
                </slide>
            </template>
            <template v-else>
                <slide v-for="item in relatedItems" :key="`slide${item.id}`">
                    <div class="min-w-full pr-2" @click="openPreview(item)">
                        <ItemImage
                            class="mb-1 rounded-lg"
                            :offset-top="item.offset_top"
                            :alt="item.title"
                            :src="item.image_src"
                            :srcset="item.image_srcset"
                        ></ItemImage>
                        <div class="text-left">
                            <h5 class="truncate text-sm font-bold">
                                {{ item.title }}
                            </h5>
                            <div class="text-xs text-gray-dark">{{ item.dating_short }}</div>
                        </div>
                    </div>
                </slide>
            </template>
        </carousel>
        <ItemPreview v-if="previewItem" :item="previewItem" @close="closePreview" />
    </div>
</template>

<script setup>
import { defineProps, ref, onMounted } from 'vue'
import { Carousel, Slide } from 'vue3-carousel'
import ItemImage from './ItemImage.vue'
import ItemPreview from './ItemPreview.vue'

const props = defineProps(['authority'])
const relatedItems = ref([])
const previewItem = ref(null)
const isLoading = ref(true)

onMounted(async () => {
    if (props.authority.related_items.length > 0) {
        try {
            const response = await axios.get(`/api/related_items/${props.authority.related_items.join(',')}`)
            relatedItems.value = response.data.data
        } catch (error) {
            console.error(error)
        } finally {
            isLoading.value = false
        }
    }
})

const openPreview = (item) => {
    previewItem.value = item
    document.body.style.overflow = 'hidden'
}

const closePreview = () => {
    previewItem.value = null
    document.body.style.overflow = 'auto'
}
</script>
