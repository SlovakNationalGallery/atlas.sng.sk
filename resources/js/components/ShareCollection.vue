<template>
    <div class="flex items-center rounded-xl bg-green/20 p-2">
        <SvgLinkSimple class="mx-2 stroke-current" />
        <div class="grow font-medium" ref="urlRef">{{ loading ? $t('Loading...') : url }}</div>
        <button :disabled="loading" @click="share" class="flex-none rounded-lg bg-green px-3 py-1 font-bold">
            {{ $t(buttonText) }}
        </button>
    </div>
</template>

<script setup>
import { useItemStore } from '../stores/ItemStore'
import { onMounted, ref } from 'vue'
import SvgLinkSimple from './svg/LinkSimple.vue'

const itemStore = useItemStore()
const loading = ref(true)
const url = ref(null)
const urlRef = ref(null)
const buttonText = ref('Share')

onMounted(async () => {
    url.value = await itemStore.getCollectionLink()
    loading.value = false
})

const share = () => {
    if (navigator.share) {
        navigator.share({
            title: 'Moja kolekcia · ' + document.title,
            // text: url.value,
            url: url.value,
        })
    } else {
        navigator.clipboard.writeText(urlRef.value.textContent).then(
            () => {
                buttonText.value = 'Link copied'
                setTimeout(() => {
                    buttonText.value = 'Share'
                }, 2000)
            },
            () => {
                window.open(url.value, '_blank').focus()
            }
        )
    }
}
</script>
