<template>
    <div class="whitespace-pre-line">
        <template v-if="item.author_description">
            {{ item.author_description }}
        </template>
        <template v-else>
            {{ authority.biography }}
        </template>
    </div>
</template>

<script setup>
const props = defineProps(['authority', 'item'])
</script>
