<template>
    <div class="relative w-full border-b-2 border-black bg-gray-softest" v-if="item">
        <ItemImageMovable v-if="$route.meta.edit" :item="item"></ItemImageMovable>
        <ItemImageLightbox v-else :item="item"></ItemImageLightbox>
    </div>
    <div class="relative h-full border-black px-4 pb-24 pt-8" v-if="item">
        <div class="absolute -top-8 inline-block rounded-md bg-black p-1.5" v-if="item.code">
            <img class="h-9 w-9" :src="`/img/${item.code}.svg`" :alt="item.code" />
        </div>
        <h2 class="text-1.5xl font-bold">{{ item.title }}</h2>
        <h3 class="text-lg text-gray-dark">{{ item.author }} · {{ item.dating }}</h3>
        <div class="my-4 space-y-4" v-html="item.description"></div>
        <Collapsible :open="i === 0" v-for="(authority, i) in item.authorities" :key="authority.id" class="my-4">
            <template v-slot:summary>
                <AuthoritySummary :authority="authority" />
            </template>
            <template v-slot:content v-if="authority.biography">
                <AuthorityDetails :authority="authority" />
            </template>
        </Collapsible>
        <Collapsible v-if="!item.authorities.length && item.author_description" :open="true" class="my-4">
            <template v-slot:summary>
                <AuthorSummary :item="item" />
            </template>
            <template v-slot:content>
                <AuthorDetails :item="item" />
            </template>
        </Collapsible>
        <Collapsible v-if="item.video_embed" class="my-4">
            <template v-slot:summary>
                <VideoSummary
                    :thumbnail="item.video_thumbnail"
                    :title="item.video_title"
                    :subtitle="item.video_subtitle"
                />
            </template>
            <template v-slot:content>
                <ResponsiveVideoEmbed
                    :src="item.video_embed"
                    :width="item.video_aspect_ratio.width"
                    :height="item.video_aspect_ratio.height"
                />
            </template>
        </Collapsible>
        <StoryButton :storyId="item.story_id" class="my-4" v-if="item.story_id" />
        <WebumeniaButton :url="item.webumenia_url" class="my-4" />
    </div>
    <div class="pointer-events-none fixed bottom-0 h-24 w-full bg-gradient-to-t from-white to-transparent md:max-w-lg">
        <div class="p-4 pt-8">
            <div class="pointer-events-auto flex space-x-4">
                <HistoryBack v-slot="{ back }">
                    <ConfirmButton class="group bg-white" @click="back">
                        <SvgBack class="mr-2 group-active:stroke-white" />
                        {{ $t('Back') }}
                    </ConfirmButton>
                </HistoryBack>
                <ConfirmButton
                    v-if="item && itemStore.isFavourite(item.id)"
                    class="border-red bg-white text-red"
                    @click="itemStore.removeFavourite(item.id)"
                    >{{ $t('Remove') }}</ConfirmButton
                >
                <ConfirmButton v-else class="group bg-green" @click="addItemFavourited(item)">
                    <SvgHeartSmall class="mr-2 fill-green group-active:fill-none" />
                    {{ $t('Save') }}
                </ConfirmButton>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import { useItemStore } from '../stores/ItemStore'
import AuthorityDetails from '../components/AuthorityDetails.vue'
import AuthoritySummary from '../components/AuthoritySummary.vue'
import Collapsible from '../components/Collapsible.vue'
import ConfirmButton from '../components/ConfirmButton.vue'
import ItemImageLightbox from '../components/ItemImageLightbox.vue'
import ItemImageMovable from '../components/ItemImageMovable.vue'
import WebumeniaButton from '../components/WebumeniaButton.vue'
import StoryButton from '../components/StoryButton.vue'
import VideoSummary from '../components/VideoSummary.vue'
import HistoryBack from '../components/HistoryBack.vue'
import ResponsiveVideoEmbed from '../components/ResponsiveVideoEmbed.vue'
import SvgBack from '../components/svg/Back.vue'
import SvgHeartSmall from '../components/svg/HeartSmall.vue'
import { useInteractionStore } from '../stores/InteractionStore'
import AuthorSummary from '../components/AuthorSummary.vue'
import AuthorDetails from '../components/AuthorDetails.vue'

const route = useRoute()
const interactionStore = useInteractionStore()
const itemStore = useItemStore()
const item = ref(null)

const addItemFavourited = (item) => {
    itemStore.addFavourite(item.id)
    interactionStore.addItemFavourited(item.id)
}

onMounted(async () => {
    const id = route.params.id
    item.value = itemStore.get(id) || (await itemStore.load(id))
})
</script>
