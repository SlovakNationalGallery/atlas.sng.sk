<template>
    <div class="whitespace-pre-line">{{ authority.biography }}</div>
    <div v-if="authority.related_items">
        <div class="font-bold my-3">{{ $t('Other works by the artist') }}</div>
        <Carousel :items-to-show="2.3" :snap-align="start">
            <slide v-for="item in relatedItems" :key="item.id" class="self-start">
                <div class="pr-2 min-w-full">
                    <ItemImage class="rounded-lg" :offset-top="item.offset_top" :alt="item.title" :src="item.image_src" :srcset="item.image_srcset"></ItemImage>
                    <div class="text-left">
                        <h5 class="font-bold text-sm truncate">
                            {{ item.title }}
                        </h5>
                        <div class="text-xs text-gray-dark">{{ item.dating_short }}</div>
                    </div>
                </div>
            </slide>
        </Carousel>
    </div>
</template>

<script setup>
import { defineProps, ref, onMounted } from 'vue'
import { Carousel, Slide } from 'vue3-carousel'
import ItemImage from './ItemImage.vue'

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
