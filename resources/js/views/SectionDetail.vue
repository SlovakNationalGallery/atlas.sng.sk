<template>
    <div class="relative w-full border-b-2 border-black bg-gray-softest" v-if="section">
        <ItemImage v-if="section.image"
            :alt="section.title"
            :src="section.image.src"
            :srcset="section.image.srcset"
        />
        <!-- Add space if section image is missing -->
        <div v-else class="h-12 w-full" />
    </div>

    <div class="relative h-full border-black px-4 pb-24 pt-8" v-if="section">
        <div class="absolute -top-8 inline-block rounded-md bg-black p-1.5" v-if="section.code">
            <img class="h-9 w-9" :src="`/img/${section.code}.svg`" :alt="section.code" />
        </div>
        <h3 class="text-lg font-bold text-gray-dark">
            {{ $t('Group of :count artworks', { count: section.items.length }) }}
        </h3>
        <h2 class="text-1.5xl font-bold">{{ section.title }}</h2>
        <div class="text-lg text-gray-dark" v-if="section.location_formatted">
            {{ $t('Location') }}: {{ section.location_formatted }}
        </div>
        <div class="my-4 space-y-4 markdown" v-html="section.description"></div>
        <p class="mb-2 font-bold">{{ $t('More about artworks in the group') }}</p>
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
    <div class="pointer-events-none fixed bottom-0 h-24 w-full bg-gradient-to-t from-white to-transparent md:max-w-lg">
        <div class="pointer-events-auto p-4 pt-8">
            <HistoryBack v-slot="{ back }">
                <ConfirmButton class="group bg-white" @click="back">
                    <SvgBack class="mr-2 group-active:stroke-white" />
                    {{ $t('Back') }}
                </ConfirmButton>
            </HistoryBack>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import { useSectionStore } from '../stores/SectionStore'
import { useInteractionStore } from '../stores/InteractionStore'
import HistoryBack from '../components/HistoryBack.vue'
import ConfirmButton from '../components/ConfirmButton.vue'
import ItemThumbnail from '../components/ItemThumbnail.vue'
import SvgBack from '../components/svg/Back.vue'
import ItemImage from '../components/ItemImage.vue'

const route = useRoute()
const props = defineProps(['section'])
const interactionStore = useInteractionStore()
const sectionStore = useSectionStore()
const section = ref(null)

onMounted(async () => {
    const id = route.params.id
    section.value = await sectionStore.load(id)
    interactionStore.addSectionViewed(item.value.id)
})
</script>
