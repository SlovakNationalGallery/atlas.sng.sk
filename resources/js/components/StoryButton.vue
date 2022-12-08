<template>
    <div
        @click="toggleModal"
        class="block rounded-xl border-2 border-black bg-green/30 p-2.5"
    >
        <div class="flex cursor-pointer">
            <div class="grow">
                <div class="flex">
                    <div class="shrink-0">
                        <img
                            class="h-16 w-16 rounded-xl border-2"
                            src="../../img/avatar-ester.png"
                            alt="Avatar"
                        />
                    </div>
                    <div class="mx-3 self-center">
                        <div class="font-bold">
                            {{
                                $t(
                                    'The exhibition trail containing this artwork'
                                )
                            }}
                        </div>
                        <div class="text-sm">{{ $t('Go to the trail') }}</div>
                    </div>
                </div>
            </div>
            <ChatCircleSmall />
        </div>
    </div>
    <CardModal @close="toggleModal" :visible="modalActive">
        <h3 class="my-4 text-2xl font-bold">
            {{ $t('Would you like to abort the current trail?') }}
        </h3>
        <div class="text-lg">{{ $t('This is irreversible') }}</div>
        <div class="flex space-x-3">
            <ConfirmButton
                class="my-4 bg-black text-white"
                @click="openStory"
                >{{ $t('OK') }}</ConfirmButton
            >
            <ConfirmButton class="my-4" @click="toggleModal">{{
                $t('Close')
            }}</ConfirmButton>
        </div>
    </CardModal>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import ChatCircleSmall from './svg/ChatCircleSmall.vue'
import CardModal from '../components/CardModal.vue'
import ConfirmButton from '../components/ConfirmButton.vue'

const props = defineProps(['storyId'])
const modalActive = ref(false)
const router = useRouter()

const toggleModal = () => {
    modalActive.value = !modalActive.value
}

const openStory = () => {
    router.push({
        name: 'story',
        params: { id: props.storyId },
    })
}
</script>
