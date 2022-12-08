<template>
    <div v-if="shown" class="fixed inset-0 cursor-zoom-out" @click="shown = false"></div>
    <div
        class="fixed top-full w-full bg-white ease-in-out md:mx-auto md:max-w-lg"
        :class="[
            peekingIn || peekingOut ? 'duration-300' : 'duration-500',
            shown || peekingIn ? (shown ? '-translate-y-full' : 'translate-y-peeking') : 'translate-y-0',
        ]"
    >
        <div class="absolute bottom-full flex w-full items-center rounded-t-xl bg-white">
            <div class="flex-1 px-3">
                <svg @click="shownOnboarding = true" class="h-[32px] w-[32px] cursor-pointer">
                    <path
                        d="M16 28C22.6274 28 28 22.6274 28 16C28 9.37258 22.6274 4 16 4C9.37258 4 4 9.37258 4 16C4 22.6274 9.37258 28 16 28Z"
                        class="fill-black"
                    />
                    <path
                        d="M16 24C16.8284 24 17.5 23.3284 17.5 22.5C17.5 21.6716 16.8284 21 16 21C15.1716 21 14.5 21.6716 14.5 22.5C14.5 23.3284 15.1716 24 16 24Z"
                        class="fill-white"
                    />
                    <path
                        d="M16 18V17C16.6922 17 17.3689 16.7947 17.9445 16.4101C18.5201 16.0256 18.9687 15.4789 19.2336 14.8394C19.4985 14.1999 19.5678 13.4961 19.4327 12.8172C19.2977 12.1383 18.9644 11.5146 18.4749 11.0251C17.9854 10.5356 17.3618 10.2023 16.6828 10.0673C16.0039 9.9322 15.3001 10.0015 14.6606 10.2664C14.0211 10.5313 13.4744 10.9799 13.0899 11.5555C12.7053 12.1311 12.5 12.8078 12.5 13.5"
                        class="stroke-white stroke-2 [stroke-linecap:round] [stroke-linejoin:round]"
                    />
                </svg>
            </div>
            <div class="grow text-center">
                <button
                    @click="shown = !shown"
                    class="my-2 min-w-[120px] rounded-full bg-black px-3 py-2 text-sm font-medium text-white duration-300 ease-in-out"
                    :class="[peekingIn ? 'text-lg text-green' : 'text-white']"
                >
                    {{ $t(shown ? 'Hide' : 'Tap to check the code') }}
                </button>
            </div>
            <div class="flex-1 px-3">
                <FavouritesCount />
            </div>
        </div>

        <div class="grid grid-cols-3 content-center gap-[2px] border-y-2 border-black bg-black">
            <CircleButton
                class="border-0 bg-white"
                v-for="position in code.length"
                :is-checked="code[position - 1]"
                @click="code[position - 1] = (code[position - 1] + 1) % 2"
                :key="position"
            />
        </div>

        <div class="p-4">
            <button
                @click="verifyCode"
                :disabled="!active"
                class="w-full rounded-xl bg-white py-2 text-xl"
                :class="[active ? 'bg-black text-white' : 'opacity-30', wrong ? 'bg-red' : null]"
            >
                {{ $t(wrong ? 'Try again' : 'Check the code') }}
            </button>
        </div>
    </div>
    <OnboardingModal @close="shownOnboarding = false" :visible="shownOnboarding"></OnboardingModal>
</template>

<script setup>
import { computed } from '@vue/reactivity'
import { onMounted, reactive, ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import CircleButton from '../components/CircleButton.vue'
import FavouritesCount from '../components/FavouritesCount.vue'
import OnboardingModal from '../components/OnboardingModal.vue'
import { useInteractionStore } from '../stores/InteractionStore'

const interactionStore = useInteractionStore()
const router = useRouter()
const route = useRoute()
const code = reactive(Array(9).fill(0))
const wrong = ref(false)
const shown = ref(false)
const shownOnboarding = ref(false)
const peekingIn = ref(false)
const peekingOut = ref(false)

const active = computed(() => {
    return code.some((bit) => bit)
})

watch(shown, (value) => {
    router.replace({ hash: value ? '#code' : undefined })
    interactionStore.peekCodePanel = false
})

const verifyCode = () => {
    const digit = parseInt(code.join(''), 2)
    axios
        .get('/api/verify/' + digit)
        .then(({ data }) => {
            const id = data.data.codeable_id
            if (data.data.codeable_type === 'item') {
                interactionStore.addItemViewed(id)
                router.push({
                    name: 'item_detail',
                    params: { id },
                })
            } else if (data.data.codeable_type === 'section') {
                interactionStore.addSectionViewed(id)
                router.push({
                    name: 'section_detail',
                    params: { id },
                })
            }
        })
        .catch(() => {
            wrong.value = true
        })
}

watch(code, () => {
    wrong.value = false
})

onMounted(() => {
    if (route.hash === '#code') {
        shown.value = true
    } else if (interactionStore.peekCodePanel) {
        const delay = (duration) => {
            return new Promise((resolve) => {
                setTimeout(resolve, duration)
            })
        }
        Promise.resolve()
            .then(() => delay(800)) // initial delay
            .then(() => {
                peekingIn.value = true
            })
            .then(() => delay(300)) // duration in
            .then(() => delay(800)) // delay between
            .then(() => {
                peekingIn.value = false
                peekingOut.value = true
            })
            .then(() => delay(300)) // duration out
            .then(() => {
                peekingOut.value = false
            })
    }
})
</script>
