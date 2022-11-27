<template>
    <div class="bg-black grow pb-bar text-base text-white">
        <div
            :ref="setStoryRef"
            class="m-4 scroll-mt-14"
            :class="{ 'opacity-50': story !== active }"
            v-for="(story, i) in stories"
        >
            <Markdown :source="story.text" />

            <div class="my-4" v-for="image in story.images">
                <ResponsiveImageWithPlaceholder class="rounded-xl w-full" :image="image" />
            </div>

            <div class="my-4" v-if="story.video_thumbnail">
                <ResponsiveImage class="rounded-xl w-full" :image="story.video_thumbnail" />
            </div>

            <button
                :disabled="story !== active"
                v-show="story === active || selectedLinks[i] === link"
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

const route = useRoute()
const stories = ref([])
const active = ref(null)
const selectedLinks = ref([])
const storyRefs = ref([])

const navigate = (link) => {
    selectedLinks.value.push(link)
    active.value = null
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
        active.value = data.data
        stories.value.push(active.value)

        nextTick(() => {
            storyRefs.value[storyRefs.value.length - 1].scrollIntoView({
                behavior: 'smooth',
                block: 'start',
            })
        })
    })
}

onMounted(() => {
    loadStory(route.params.id || route.meta.id)
})
</script>
