<template>
    <div class="flex">
        <div class="shrink-0">
            <img class="rounded-full w-16" :src="authority.image_url" />
        </div>
        <div class="mx-3">
            <div class="font-bold">{{ helpers.formatName(authority.name) }}</div>
            <div class="text-sm">
                {{ authority.birth_date }} {{ authority.birth_place }}
                <template v-if="authority.death_date">
                    &mdash; {{ authority.death_date }} {{ authority.death_place }}
                </template>
            </div>
        </div>
    </div>
</template>

<script setup>
import helpers from '../helpers'

const props = defineProps(['authority'])
</script>
