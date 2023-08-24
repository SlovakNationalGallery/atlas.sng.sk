<template>
    <div class="flex opacity-60 text-gray-softest" v-if="item">
        <div class="flex-none mr-2">
            <component :is="icon" :class="iconClass" />
        </div>
        <span>
            {{ $t(label) }}
            <router-link class="underline hover:no-underline" :to="{ name: 'item_detail', params: { id: item.id } }"
                >{{ item.author }} &mdash; {{ item.title }}</router-link
            >
        </span>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useItemStore } from '../stores/ItemStore'

const props = defineProps(['id', 'label', 'icon', 'iconClass'])
const itemStore = useItemStore()
const item = ref()

onMounted(async () => {
    item.value = itemStore.get(props.id) || await itemStore.load(props.id)
})

</script>
