<template>
    <div class="relative h-full border-black pb-24" v-if="section">
        <div class="h-full bg-black p-4">
            <img class="h-9 w-9 mb-4" :src="`/img/${section.code}.svg`" :alt="section.code" />
            <p v-if="section.items.length" class="mb-2 font-bold text-green">
                {{ $t('Group of :count artworks', { count: section.items.length }) }}
            </p>
            <h2 class="text-1.5xl font-bold text-white">{{ section.title }}</h2>
        </div>
        <div class="px-4">
            <div class="my-4 text-lg text-gray-dark" v-if="section.location_formatted">
                {{ $t('Location') }}: {{ section.location_formatted }}
            </div>
            <div class="my-4 space-y-4" v-html="section.description"></div>

            <p v-if="section.items.length" class="mb-2 font-bold">{{ $t('More about artworks in the group') }}</p>
            <div class="flex flex-col space-y-3">
                <router-link
                    v-for="item in section.items"
                    :key="item"
                    :to="{ name: 'section_item_detail', params: { section_id: route.params.id, id: item.id } }"
                >
                    <ItemThumbnail :item="item" />
                </router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import ItemThumbnail from '../components/ItemThumbnail.vue'
import { useSectionStore } from '../stores/SectionStore'

const route = useRoute()
const props = defineProps(['section'])
const sectionStore = useSectionStore()
const section = ref(null)

onMounted(async () => {
    const id = route.params.id
    section.value = await sectionStore.load(id)
})
</script>
