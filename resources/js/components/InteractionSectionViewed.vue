<template>
    <div class="flex opacity-60 text-gray-softest" v-if="section">
        <div class="flex-none mr-2">
            <SvgEye />
        </div>
        <span>
            {{ $t('Viewed') }}
            <router-link
                class="underline hover:no-underline"
                :to="{ name: 'section_detail', params: { id: section.id } }"
                >{{ section.title }}</router-link
            >
        </span>
    </div>
</template>

<script setup>
import SvgEye from './svg/Eye.vue'
import { useSectionStore } from '../stores/SectionStore'
import { onMounted, ref } from 'vue'

const sectionStore = useSectionStore()
const section = ref()

onMounted(async () => {
    section.value = sectionStore.get(props.id) || await sectionStore.load(props.id)
})

const props = defineProps(['section'])
</script>
