<template>
    <router-link :to="'/detail/' + itemId">
        <div class="flex my-4">
            <div class="h-24 w-24 border-black border-2 flex items-center justify-center">
                <svg class="w-9 h-9" fill="none" xmlns="http://www.w3.org/2000/svg"></svg>
            </div>
            <div class="py-2 px-4">
                <h2 class="text-base pb-1">{{ itemId }}</h2>
                <div class="text-sm text-gray-dark">Miloš Alexander Bazovský  a ...</div>
            </div>
        </div>
    </router-link>
</template>

<script setup>
    import { computed, ref } from "vue"
    const props = defineProps( [ 'itemId' ] )
</script>