<template>
    <div class="flex text-gray-softest opacity-60" v-if="place">
        <div class="mr-2 flex-none">
            <SvgEye />
        </div>
        <span>
            {{ $t('Viewed') }}
            <router-link
                class="underline hover:no-underline"
                :to="{ name: 'place_detail', params: { id: place.id } }"
                >{{ place.title }}</router-link
            >
        </span>
    </div>
</template>

<script setup>
import SvgEye from './svg/Eye.vue'

const props = defineProps(['place'])
</script>
