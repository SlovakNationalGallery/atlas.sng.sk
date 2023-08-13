<template>
    <div v-if="item">
        <article class="flex justify-between border-b-2 bg-green/20 p-4 pb-5" v-if="bucketlist">
            <div>
                <h3 class="font-medium">
                    {{ $t('Scavenger hunt:') }} <span class="italic">{{ bucketlist.title }}</span>
                </h3>
                <p class="mt-1 text-2xl font-medium leading-snug">
                    {{ $t(':found of :all artworks found', { found: found.length, all: bucketlist.items.length }) }}
                </p>
            </div>
            <div class="flex items-center">
                <router-link
                    tag="button"
                    :to="
                        unlocked ? { name: 'reward_detail', params: { id: bucketlist.id } } : { name: 'my_collection' }
                    "
                    class="rounded-xl border-2 bg-green px-4 py-3 text-center font-bold capitalize leading-none"
                    >{{ $t(unlocked ? 'reward' : 'list') }}</router-link
                >
            </div>
        </article>
        <div class="relative w-full border-b-2 border-black bg-gray-softest">
            <ImageMovable
                v-if="route.query.edit"
                :alt="`${item.author}: ${item.title}`"
                :src="item.image_src"
                :srcset="item.image_srcset"
                :offset-top="item.offset_top"
            />
            <ImageLightbox
                v-else
                :alt="`${item.author}: ${item.title}`"
                :src="item.image_src"
                :srcset="item.image_srcset"
                :offset-top="item.offset_top"
                :images="item.images"
                :image-aspect-ratio="item.image_aspect_ratio"
            />
        </div>
        <div class="relative h-full border-black px-4 pb-24 pt-8">
            <div class="absolute -top-8 inline-block rounded-md bg-black p-1.5" v-if="item.code">
                <img class="h-9 w-9" :src="`/img/${item.code}.svg`" :alt="item.code" />
            </div>
            <h2 class="text-1.5xl font-bold">{{ item.title }}</h2>
            <h3 class="text-lg text-gray-dark">{{ item.author }} · {{ item.dating }}</h3>
            <div class="text-lg text-gray-dark" v-if="item.location_formatted">
                {{ $t('Location') }}: {{ item.location_formatted }}
            </div>
            <div class="my-4 space-y-4 markdown" v-html="item.description"></div>
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
        <div
            class="pointer-events-none fixed bottom-0 h-24 w-full bg-gradient-to-t from-white to-transparent md:max-w-lg"
        >
            <div class="pointer-events-auto p-4 pt-8">
                <HistoryBack v-slot="{ back }">
                    <ConfirmButton class="group bg-white" @click="back">
                        <SvgBack class="mr-2 group-active:stroke-white" />
                        {{ $t('Back') }}
                    </ConfirmButton>
                </HistoryBack>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import { useBucketlistStore } from '../stores/BucketlistStore'
import { useInteractionStore } from '../stores/InteractionStore'
import { useItemStore } from '../stores/ItemStore'
import AuthorityDetails from '../components/AuthorityDetails.vue'
import AuthoritySummary from '../components/AuthoritySummary.vue'
import Collapsible from '../components/Collapsible.vue'
import ImageLightbox from '../components/ImageLightbox.vue'
import ImageMovable from '../components/ImageMovable.vue'
import WebumeniaButton from '../components/WebumeniaButton.vue'
import StoryButton from '../components/StoryButton.vue'
import VideoSummary from '../components/VideoSummary.vue'
import ResponsiveVideoEmbed from '../components/ResponsiveVideoEmbed.vue'
import AuthorSummary from '../components/AuthorSummary.vue'
import AuthorDetails from '../components/AuthorDetails.vue'
import HistoryBack from '../components/HistoryBack.vue'
import ConfirmButton from '../components/ConfirmButton.vue'
import SvgBack from '../components/svg/Back.vue'

const route = useRoute()
const bucketlistStore = useBucketlistStore()
const interactionStore = useInteractionStore()
const itemStore = useItemStore()
const item = ref(null)
const bucketlist = ref(null)
const found = computed(() => bucketlist.value.items.filter((item) => interactionStore.isItemViewed(item.id)))
const unlocked = computed(() => found.value.length === bucketlist.value.items.length)

onMounted(async () => {
    const id = route.params.id
    item.value = await itemStore.load(id)
    interactionStore.addItemViewed(item.value.id)
    const defaultBucketlist = item.value.bucketlists.find(
        (bucketlist) => bucketlist.id === import.meta.env.VITE_DEFAULT_BUCKETLIST
    )
    if (defaultBucketlist) {
        bucketlist.value =
            bucketlistStore.get(defaultBucketlist.id) || (await bucketlistStore.load(defaultBucketlist.id))
    }
})
</script>
