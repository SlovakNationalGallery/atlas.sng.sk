<template>
    <div class="bg-black text-white">
        <div :class="{ 'opacity-50': story !== active }" v-for="(story, i) in stories">
            <Markdown :source="story.text" />

            <div
                v-show="story === active || selectedLinks[i] === link"
                :class="{ 'pointer-events-none': story !== active }"
                class="block border-1 border-green cursor-pointer m-2 p-2 rounded-xl text-center text-green w-auto"
                @click="navigate(link)"
                v-for="link in story.links"
            >
                {{ link.title }}
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import Markdown from 'vue3-markdown-it'

const route = useRoute()
const stories = ref([])
const active = ref(null)
const selectedLinks = ref([])

const navigate = (link) => {
    selectedLinks.value.push(link)
    active.value = null
    loadStory(link.story_id)
}

const loadStory = (id) => {
    return axios.get(`/api/stories/${id}`).then(({ data }) => {
        active.value = data.data
        stories.value.push(active.value)
    })
}

onMounted(() => {
    loadStory(route.params.id)
})
</script>
