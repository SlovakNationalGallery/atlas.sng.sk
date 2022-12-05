<template>
    <InteractionItem :icon="SvgHeart" iconClass="fill-current" :label="$t('Collected')" v-bind="props" />
</template>

<script setup>
import InteractionItem from './InteractionItem.vue'
import SvgHeart from './svg/Heart.vue'

const props = defineProps(['item'])
</script>
