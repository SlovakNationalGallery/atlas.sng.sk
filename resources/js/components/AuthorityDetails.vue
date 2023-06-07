<template>
    <div class="whitespace-pre-line">{{ authority.biography }}</div>
    <div v-if="authority.related_items">
        <div class="font-bold my-3">{{ $t('Other works by the artist') }}</div>
        <ul>
            <li v-for="item in relatedItems" :key="item.id">
                <div class="text-sm">{{ item.title }}</div>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { defineProps, ref, onMounted } from 'vue'

const props = defineProps(['authority'])
const relatedItems = ref([])

onMounted(async () => {
  if (props.authority.related_items.length > 0) {
    try {
      const response = await axios.get(`/api/related_items/${props.authority.related_items.join(',')}`);
      relatedItems.value = response.data.data;
    } catch (error) {
      console.error(error);
    }
  }
});
</script>
