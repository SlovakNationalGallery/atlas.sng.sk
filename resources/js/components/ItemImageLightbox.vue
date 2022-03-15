<template>
    <ItemImage :item="item" @click.prevent="visible = true"></ItemImage>
    <div
        class="fixed inset-0 z-50 flex justify-center items-center"
        v-if="visible"
        @click="visible = false"
    >
        <div
            class="bg-black opacity-70 absolute inset-0 cursor-zoom-out"
            @click="visible = false"
        />
        <div class="relative max-h-full w-full" @click.stop="visible = false">
            <img :src="item.image_src" />
            <div
                class="absolute cursor-pointer p-1 bg-white top-0 right-0"
                @click.stop="visible = false"
            >
                <svg class="w-9 h-9"><path d="M36 0H0v36h36V0Z" fill="#fff"/><path d="m28.125 7.875-20.25 20.25M28.125 28.125 7.875 7.875" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import ItemImage from "./ItemImage.vue";

const props = defineProps(["item"]);
const visible = ref(false);
</script>