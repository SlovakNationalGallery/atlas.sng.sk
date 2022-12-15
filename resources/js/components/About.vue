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
                        <div class="flex rounded-xl border-2 border-black bg-green/30 p-2.5">
                            <div class="shrink-0">
                                <SvgInfo />
                            </div>
                            <div class="pl-2">
                                {{
                                    $t(
                                        'The development of the app is ongoing, we are improving it according to feedback. Do you want to help us?'
                                    )
                                }}
                                <a href="#" class="underline" @click="getFeedback">{{
                                    $t('Fill out a brief survey!')
                                }}</a>
                            </div>
                        </div>
                        <p v-html="$t('about_perex_1')"></p>
                        <p v-html="$t('about_perex_2')"></p>
                    </div>
                </div>

                <AboutCollapsible :initialOpen="true" class="scroll-mt-12 border-b-1 border-gray-softest">
                    <template v-slot:summary>{{ $t('How to?')}} </template>
                    <template v-slot:content>
                        <div class="space-y-4">
                            <ul class="ml-6 list-disc">
                                <li class="pl-2.5">{{ $t('Tap the code next to the artwork into the grid in the app.') }}</li>
                                <li class="pl-2.5">{{ $t('You can save the artwork to your collection and send it to your email.') }}</li>
                                <li class="pl-2.5">
                                    {{ $t('As you explore the exhibition, Ester will offer you behind-the-scenes videos and original insights on the artworks from the artists or visitors.') }}
                                </li>
                                <li class="pl-2.5">
                                    {{ $t('You can read about how Ester came to the SNG in Monika Kompaníková\'s book Where is Ester N?')}}
                                </li>
                            </ul>
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
</template>

<style scoped>
.v-enter-from > div,
.v-leave-to > div {
    @apply -translate-x-full;
}
</style>

<script setup>
import AboutCollapsible from './AboutCollapsible.vue'
import SvgLogo from './svg/Logo.vue'
import SvgInfo from './svg/Info.vue'
import { useSurveyStore } from '../stores/SurveyStore'
import { getActiveLanguage } from 'laravel-vue-i18n'

const props = defineProps(['opened'])
const surveyStore = useSurveyStore()

const getFeedback = () => {
    surveyStore.done()
    if (getActiveLanguage() == 'sk') {
        window.open(import.meta.env.VITE_SURVEY_SK, '_blank').focus()
    } else {
        window.open(import.meta.env.VITE_SURVEY_EN, '_blank').focus()
    }
}
</script>
