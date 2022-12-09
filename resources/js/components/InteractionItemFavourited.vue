<template>
    <InteractionItem :icon="SvgHeartSmall" iconClass="fill-current" :label="$t('Saved')" v-bind="props" />
</template>

<script setup>
import InteractionItem from './InteractionItem.vue'
import SvgHeartSmall from './svg/HeartSmall.vue'

const props = defineProps(['item'])
</script>
