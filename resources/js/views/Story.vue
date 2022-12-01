<template>
    <div class="bg-black grow pb-bar text-base text-white">
        <div
            :ref="setStoryRef"
            class="m-4 scroll-mt-14"
            :class="{ 'opacity-50': story !== storiesStore.active }"
            v-for="(story, i) in storiesStore.stories"
        >
            <Markdown :source="story.text" />

            <div class="my-4" v-for="image in story.images">
                <ResponsiveImageWithPlaceholder class="rounded-xl w-full" :image="image" />
            </div>

            <div class="my-4" v-if="story.video_thumbnail">
                <ResponsiveImage class="rounded-xl w-full" :image="story.video_thumbnail" />
            </div>

            <button
                :disabled="story !== storiesStore.active"
                v-show="story === storiesStore.active || storiesStore.selectedLinks[i] === link"
                class="block border-1 border-green cursor-pointer my-4 p-3 rounded-xl text-green text-left w-full"
                @click="navigate(link)"
                v-for="link in story.links"
            >
                {{ link.title }}
            </button>
        </div>
    </div>

    <CodePanel />
</template>

<script setup>
import { nextTick, onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import Markdown from 'vue3-markdown-it'
import CodePanel from '../components/CodePanel.vue'
import ResponsiveImage from '../components/ResponsiveImage.vue'
import ResponsiveImageWithPlaceholder from '../components/ResponsiveImageWithPlaceholder.vue'
import { useStoriesStore } from '../stores/StoriesStore'

const storiesStore = useStoriesStore()
const route = useRoute()
const storyRefs = ref([])

const navigate = (link) => {
    storiesStore.selectLink(link)
    loadStory(link.story_id)
}

const setStoryRef = (el) => {
    if (!el) {
        return
    }

    storyRefs.value.push(el)
}

const loadStory = (id) => {
    return axios.get(`/api/stories/${id}`).then(({ data }) => {
        storiesStore.addStory(data.data)

        nextTick(() => {
            storyRefs.value[storyRefs.value.length - 1].scrollIntoView({
                behavior: 'smooth',
                block: 'start',
            })
        })
    })
}

onMounted(() => {
    if (!storiesStore.stories.length) {
        loadStory(route.params.id || route.meta.id)
    }
})
</script>
