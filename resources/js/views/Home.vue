<template>
    <ScreenWrapper>
        <div class="bg-black text-white h-32 flex">
            <div class="p-4 pr-0 flex flex-col grow">
                <div class="text-xl mb-2">{{ $t('Enter artwork code to start') }}</div>
                <div class="flex-1 text-base">
                    {{ $t('Collect your favorite artworks and find more info about them') }}
                </div>
            </div>
            <div class="w-8 h-32">
                <svg class="w-full h-full" fill="none" viewBox="0 0 20 111" preserveAspectRatio="none">
                    <path d="M0.500001 55.5L19.25 0.0743716L19.25 110.926L0.500001 55.5Z" fill="white" />
                </svg>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-0 border border-black content-center">
            <CircleButton
                v-for="position in code.length"
                :is-checked="code[position - 1] == '1' ? true : false"
                @click="modifyCode(position)"
                :key="position"
            />
        </div>
        <div class="border border-black content-center border-t-0 grow flex">
            <div class="w-full border border-black border-t-0">
                <RectangleButton @click="switchLanguage()"> SK/EN </RectangleButton>
            </div>
            <div class="w-full border border-black border-t-0">
                <RectangleButton class="font-bold bg-red text-white" v-if="isWrong" @click="verifyCode">
                    {{ $t('Try again') }}
                </RectangleButton>
                <RectangleButton
                    class="font-bold"
                    :class="isActive ? 'bg-black text-white active:bg-white active:text-black' : 'text-gray-soft'"
                    @click="verifyCode"
                    v-else
                >
                    {{ $t('Verify') }}
                </RectangleButton>
            </div>
            <div class="w-full border border-black border-t-0">
                <RectangleButton @click="toggleOnboarding">
                    {{ $t('Help') }}
                </RectangleButton>
                <OnboardingModal @close="toggleOnboarding" :visible="onboardingActive"></OnboardingModal>
            </div>
        </div>
        <TeaserModal @close="toggleTeaser" :visible="teaserActive"></TeaserModal>
    </ScreenWrapper>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useTeaserStore } from '../stores/TeaserStore'
import CircleButton from '../components/CircleButton.vue'
import RectangleButton from '../components/RectangleButton.vue'
import OnboardingModal from '../components/OnboardingModal.vue'
import TeaserModal from '../components/TeaserModal.vue'
import { getActiveLanguage, loadLanguageAsync } from 'laravel-vue-i18n'
import { useItemsStore } from '../stores/ItemsStore'
import ScreenWrapper from '../components/ScreenWrapper.vue'

const router = useRouter()
const teaserStore = useTeaserStore()
const code = ref('000000000')
const isWrong = ref(false)
const locale = ref('sk')
const onboardingActive = ref(false)
const teaserActive = ref(false)
const itemsStore = useItemsStore()

const isActive = computed(() => {
    return code.value != '000000000'
})

onMounted(async () => {
    locale.value = getActiveLanguage()

    if (!teaserStore.isDone) {
        teaserActive.value = true
        teaserStore.done()
    }
})

const verifyCode = (event) => {
    if (!isActive.value) return
    const digit = parseInt(code.value, 2)
    axios
        .get('/api/verify/' + digit)
        .then((response) => {
            router.push('/detail/' + response.data.data.item_id)
        })
        .catch((resonse) => {
            isWrong.value = true
        })
}

const modifyCode = (pos) => {
    if (isWrong.value) {
        isWrong.value = false
    }
    const bit = code.value[pos - 1] == '1' ? '0' : '1'
    code.value = code.value.substring(0, pos - 1) + bit + code.value.substring(pos)
}

const switchLanguage = () => {
    locale.value = locale.value == 'sk' ? 'en' : 'sk'
    loadLanguageAsync(locale.value)
    itemsStore.clearItemsFromState()
}

const toggleOnboarding = () => {
    onboardingActive.value = !onboardingActive.value
}

const toggleTeaser = () => {
    teaserActive.value = !teaserActive.value
}
</script>
