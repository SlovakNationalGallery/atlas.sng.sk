<template>
    <img
        ref="img"
        @load.once="load"
        :srcset="props.image.srcset"
        :sizes="sizes"
        :src="props.image.src"
        :width="props.image.width"
        :height="props.image.height"
    />
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps(['image'])
const img = ref(null)
const sizes = ref('1px')

const load = () => {
    window.requestAnimationFrame(() => {
        const size = img.value.getBoundingClientRect().width
        if (!size) {
            return
        }

        sizes.value = Math.ceil((size / window.innerWidth) * 100) + 'vw'
    })
}
</script>
