<template>
    <div v-if="shown" class="cursor-zoom-out fixed inset-0" @click="shown = false"></div>
    <div
        class="bg-white duration-500 fixed top-full w-full md:max-w-lg md:mx-auto"
        :class="{ '-translate-y-full': shown, 'animate-peek': peek }"
    >
        <div class="absolute bg-white bottom-full flex items-center rounded-t-xl w-full">
            <div class="flex-1 px-3">
                <svg @click="shownOnboarding = true" class="cursor-pointer h-[32px] w-[32px]">
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
                        class="stroke-2 stroke-white [stroke-linecap:round] [stroke-linejoin:round]"
                    />
                </svg>
            </div>
            <div class="grow text-center">
                <button
                    @click="togglePanel"
                    class="bg-black my-2 px-3 py-2 rounded-full text-sm text-white"
                    :class="{ 'animate-grow': peek }"
                >
                    {{ $t(shown ? 'Tap to hide' : 'Tap to collect artworks') }}
                </button>
            </div>
            <div class="flex-1 px-3">
                <FavouritesCount />
            </div>
        </div>

        <div class="bg-black border-black border-y-2 content-center gap-[2px] grid grid-cols-3">
            <CircleButton
                class="bg-white border-0"
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
                class="bg-white py-2 rounded-xl text-lg w-full"
                :class="[active ? 'bg-black text-white' : 'opacity-30', wrong ? 'bg-red' : null]"
            >
                {{ $t(wrong ? 'Try again' : 'Tap to check code') }}
            </button>
        </div>
    </div>
    <OnboardingModal @close="shownOnboarding = false" :visible="shownOnboarding"></OnboardingModal>
</template>

<script setup>
import { computed } from '@vue/reactivity'
import { reactive, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import CircleButton from '../components/CircleButton.vue'
import FavouritesCount from '../components/FavouritesCount.vue'
import OnboardingModal from '../components/OnboardingModal.vue'

const router = useRouter()
const code = reactive(Array(9).fill(0))
const wrong = ref(false)
const shown = ref(false)
const shownOnboarding = ref(false)
const peek = ref(true)

const active = computed(() => {
    return code.some((bit) => bit)
})

const togglePanel = () => {
    peek.value = false
    // ugly hack since nextTick does not help
    setTimeout(() => {
        shown.value = !shown.value
    }, 0)
}

const verifyCode = () => {
    const digit = parseInt(code.join(''), 2)
    axios
        .get('/api/verify/' + digit)
        .then(({ data }) => {
            if (data.data.codeable_type === 'item') {
                router.push({
                    name: 'item_detail',
                    params: { id: data.data.codeable_id },
                })
            } else if (data.data.codeable_type === 'section') {
                router.push({
                    name: 'section_detail',
                    params: { id: data.data.codeable_id },
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
</script>
