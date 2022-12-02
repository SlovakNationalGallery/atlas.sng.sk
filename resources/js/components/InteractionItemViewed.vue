<template>
    <InteractionItem :icon="SvgEye" :label="$t('Viewed')" v-bind="props" />
</template>

<script setup>
import InteractionItem from './InteractionItem.vue'
import SvgEye from './svg/Eye.vue'

const props = defineProps(['item'])
</script>
