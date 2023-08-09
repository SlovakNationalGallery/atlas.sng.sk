<template>
    <Transition :duration="300">
        <div class="fixed inset-0 z-10 overflow-hidden md:mx-auto md:max-w-lg" v-if="opened">
            <div class="h-full overflow-y-auto bg-white pt-[48px] duration-300">
                <div class="border-b-1 border-gray-softest">
                    <div class="my-8 flex items-end justify-between">
                        <div class="self-items-end mx-4">
                            <SvgLogo class="mb-7 !h-[46px] !w-[46px]" viewBox="3.3 3.3 28.7 28.7" />
                            <h1 class="font-bold leading-10">
                                <span class="text-[52px]">Atlas</span><br />
                                <span class="text-[42px]">SNG</span>
                            </h1>
                        </div>
                        <div>
                            <img src="../../img/about-ester.png" />
                        </div>
                    </div>

                    <div class="m-4 space-y-4 text-xl">
                        <div class="flex rounded-xl border-2 border-black bg-green/30 p-2.5" v-if="!isSurveyDone">
                            <div class="shrink-0">
                                <SvgInfo />
                            </div>
                            <div class="pl-2">
                                {{
                                    $t(
                                        'The development of the app is ongoing, we are improving it according to feedback. Do you want to help us?'
                                    )
                                }}
                                <a href="#" class="underline" @click="toggleSurvey">{{
                                    $t('Fill out a brief survey!')
                                }}</a>
                            </div>
                        </div>
                        <p v-html="$t('about_perex_1')"></p>
                        <p v-html="$t('about_perex_2')"></p>
                    </div>
                </div>

                <AboutCollapsible :initialOpen="true" class="scroll-mt-12 border-b-1 border-gray-softest">
                    <template v-slot:summary>{{ $t('How to?') }} </template>
                    <template v-slot:content>
                        <div class="space-y-4">
                            <ul class="ml-6 list-disc">
                                <li class="pl-2.5">
                                    {{ $t('Enter the code next to the artwork into the grid in the app. Feel free to try a random one.') }}
                                </li>
                                <li class="pl-2.5">
                                    {{ $t('You\'ll also find a link to other works by the artist in the artwork\'s profile.') }}
                                </li>
                                <li class="pl-2.5">
                                    {{ $t('You can come back to your artworks later, Atlas remembers them.') }}
                                </li>
                            </ul>
                        </div>
                    </template>
                </AboutCollapsible>
                <AboutCollapsible class="scroll-mt-12 border-b-1 border-gray-softest">
                    <template v-slot:summary>{{ $t('Settings') }}</template>
                    <template v-slot:content>
                        <div class="items-center flex">
                            <div class="grow">{{ $t('Reload the conversation from the beginning') }}</div>
                            <button
                                @click="shownResetModal = true"
                                class="flex-none rounded-xl bg-black py-2 px-3 text-sm font-medium leading-4.5 text-white"
                            >
                                {{ $t('Reset') }}
                            </button>
                        </div>
                    </template>
                </AboutCollapsible>
                <AboutCollapsible class="scroll-mt-12 border-b-1 border-gray-softest">
                    <template v-slot:summary>{{ $t('About the project') }}</template>
                    <template v-slot:content>
                        <div class="space-y-4">
                            <p v-html="$t('about_project_1')"></p>
                            <p v-html="$t('about_project_2')"></p>
                            <p>
                                <a
                                    class="underline hover:no-underline"
                                    href="https://www.sng.sk/sk/vyskum/projekty/ako-porozumiet-digitalnym-zbierkam"
                                    target="_blank"
                                    >{{ $t('More about the project') }}</a
                                >
                            </p>
                        </div>

                        <img
                            class="mt-8 max-w-[8rem]"
                            src="../../img/eea_grants.png"
                            alt="Iceland Lichtenstein Norway grants"
                        />
                    </template>
                </AboutCollapsible>
                <AboutCollapsible class="scroll-mt-12 border-b-1 border-gray-softest">
                    <template v-slot:summary>{{ $t('Made by') }} lab.SNG</template>
                    <template v-slot:content>
                        <ul>
                            <li>Gabriel Balkó: {{ $t('Production') }}</li>
                            <li>Michal Čudrnák: {{ $t('Project lead') }}</li>
                            <li>Dominika Čupková: {{ $t('Video') }}</li>
                            <li>Romana Halgošová: {{ $t('Video') }}</li>
                            <li>Rastislav Chynoranský: {{ $t('Development') }}</li>
                            <li>Zuzana Koblišková: {{ $t('Content, English translation') }}</li>
                            <li>Michaela Kováčová: {{ $t('Content') }}</li>
                            <li>Igor Rjabinin: {{ $t('Development') }}</li>
                            <li>Filip Ruisl: {{ $t('UX design, graphic design') }}</li>
                            <li>František Sebestyén: {{ $t('Development') }}</li>
                            <li>Lukáš Štepanovský: {{ $t('Content, UX design, concept') }}</li>
                            <li>Jana Šuchová: {{ $t('Artist research') }}</li>
                            <li>Barbora Tribulová: {{ $t('Content') }}</li>
                            <li>Katarína Vass: {{ $t('User research') }}</li>
                            <li>Karin Vicianová: {{ $t('Content') }}</li>
                            <li>Ernest Walzel: {{ $t('Development') }}</li>
                        </ul>
                    </template>
                </AboutCollapsible>
            </div>
        </div>
    </Transition>

    <CardModal @close="shownResetModal = false" :visible="shownResetModal">
        <h3 class="my-4 text-2xl font-bold">{{ $t('Reset the conversation') }}</h3>
        <div class="text-lg leading-7">
            <p>
                {{
                    $t(
                        'Are you sure you want to reset your conversation with Ester? It will start from the very beginning. This step can not be undone.'
                    )
                }}
            </p>
            <p class="mt-2 font-bold">{{ $t('Your collection remains saved!') }}</p>
        </div>
        <div class="flex space-x-3">
            <ConfirmButton class="my-4 bg-black text-white" @click="resetInteraction">{{ $t('Reset') }}</ConfirmButton>
            <ConfirmButton class="my-4" @click="shownResetModal = false">{{ $t('Close') }}</ConfirmButton>
        </div>
    </CardModal>
</template>

<style scoped>
.v-enter-from > div,
.v-leave-to > div {
    @apply -translate-x-full;
}
</style>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import AboutCollapsible from './AboutCollapsible.vue'
import CardModal from '../components/CardModal.vue'
import ConfirmButton from '../components/ConfirmButton.vue'
import SvgLogo from './svg/Logo.vue'
import SvgInfo from './svg/Info.vue'
import { useInteractionStore } from '../stores/InteractionStore'
import { useSurvey } from '../composables/Survey'

const props = defineProps(['opened'])
const router = useRouter()
const interactionStore = useInteractionStore()
const { toggle: toggleSurvey, isDone: isSurveyDone } = useSurvey()

const shownResetModal = ref(false)

const resetInteraction = () => {
    interactionStore.clear()
    router.go()
}
</script>
