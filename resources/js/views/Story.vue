<template>
    <div ref="storiesRef" class="bg-black grow text-base text-white">
        <div class="m-4" :class="{ 'opacity-50 pointer-events-none': story !== active }" v-for="(story, i) in stories">
            <Markdown :source="story.text" />

            <div class="my-4" v-for="image in story.images">
                <ResponsiveImage class="rounded-xl w-full" :image="image" />
            </div>

            <button
                v-show="story === active || selectedLinks[i] === link"
                class="block border-1 border-green cursor-pointer my-4 p-3 rounded-xl text-green text-left w-full"
                @click="navigate(link)"
                v-for="link in story.links"
            >
                {{ link.title }}
            </button>
        </div>
    </div>
</template>

<script setup>
import { nextTick, onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import Markdown from 'vue3-markdown-it'
import ResponsiveImage from '../components/ResponsiveImage.vue'

const route = useRoute()
const stories = ref([])
const active = ref(null)
const selectedLinks = ref([])
const storiesRef = ref(null)

const navigate = (link) => {
    selectedLinks.value.push(link)
    active.value = null
    loadStory(link.story_id)
}

const loadStory = (id) => {
    return axios.get(`/api/stories/${id}`).then(({ data }) => {
        active.value = data.data
        stories.value.push(active.value)

        nextTick(() => {
            storiesRef.value.scrollIntoView({
                behavior: 'smooth',
                block: 'end',
            })
        })
    })
}

onMounted(() => {
    loadStory(route.params.id)
})
</script>
