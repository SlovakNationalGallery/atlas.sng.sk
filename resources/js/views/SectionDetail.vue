<template>
    <div class="h-full border-black pb-24 relative" v-if="section">
        <div class="h-full bg-black p-4">
            <img class="h-9 w-9" :src="`/img/${section.code}.svg`" :alt="section.code" />
            <p class="font-bold mb-2 mt-4 text-green">
                {{ $t('Section with :count artworks', { count: section.items.length }) }}
            </p>
            <h2 class="font-bold text-white text-xl">{{ section.title }}</h2>
        </div>
        <div class="px-4">
            <div class="py-4 space-y-4" v-html="section.description"></div>

            <p class="font-bold mb-2">{{ $t('Artworks in section') }}</p>
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
    section.value = sectionStore.get(id) || (await sectionStore.load(id))
})
</script>
