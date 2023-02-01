<template>
    <div class="relative w-full border-b-2 border-black bg-gray-softest" v-if="place">
        <ImageLightbox :alt="place.title" :src="place.image.src" :srcset="place.image.srcset" />
    </div>
    <div class="relative h-full border-black px-4 pb-24 pt-8" v-if="place">
        <div class="absolute -top-8 inline-block rounded-md bg-black p-1.5" v-if="place.code">
            <img class="h-9 w-9" :src="`/img/${place.code}.svg`" :alt="place.code" />
        </div>
        <h2 class="text-1.5xl font-bold">{{ place.title }}</h2>
        <div class="my-4 space-y-4" v-html="place.description"></div>
        <Collapsible v-if="place.video_embed" :open="true" class="my-4">
            <template v-slot:summary>
                <VideoSummary
                    :thumbnail="place.video_thumbnail"
                    :title="place.video_title"
                    :subtitle="place.video_subtitle"
                />
            </template>
            <template v-slot:content>
                <ResponsiveVideoEmbed
                    :src="place.video_embed"
                    :width="place.video_aspect_ratio.width"
                    :height="place.video_aspect_ratio.height"
                />
            </template>
        </Collapsible>
        <StoryButton :storyId="place.story_id" class="my-4" v-if="place.story_id" />
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import Collapsible from '../components/Collapsible.vue'
import ConfirmButton from '../components/ConfirmButton.vue'
import ImageLightbox from '../components/ImageLightbox.vue'
import ItemImageMovable from '../components/ItemImageMovable.vue'
import StoryButton from '../components/StoryButton.vue'
import VideoSummary from '../components/VideoSummary.vue'
import HistoryBack from '../components/HistoryBack.vue'
import ResponsiveVideoEmbed from '../components/ResponsiveVideoEmbed.vue'
import SvgBack from '../components/svg/Back.vue'
import SvgHeartSmall from '../components/svg/HeartSmall.vue'
import { usePlaceStore } from '../stores/PlaceStore'

const route = useRoute()
const placeStore = usePlaceStore()
const place = ref(null)

onMounted(async () => {
    const id = route.params.id
    place.value = await placeStore.load(id)
})
</script>
