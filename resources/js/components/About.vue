<template>
    <Transition :duration="300">
        <div class="fixed inset-0 z-10 overflow-hidden md:mx-auto md:max-w-lg" v-if="opened">
            <div class="h-full overflow-y-auto bg-white pt-[48px] duration-300">
                <div class="border-b-1 border-gray-softest">
                    <div class="my-8 flex items-end justify-between">
                        <div class="self-items-end mx-4">
                            <SvgLogo class="mb-7 !h-[46px] !w-[46px]" viewBox="0 0 26 26" />
                            <h1 class="font-bold leading-10">
                                <span class="text-[52px]">Atlas</span><br />
                                <span class="text-[42px]">SNG</span>
                            </h1>
                        </div>
                        <div>
                            <img src="../../img/about-ester.png" />
                        </div>
                    </div>

                    <p class="m-4 text-xl">
                        Objavte príbehy umeleckých diel s digitálnou sprievodkyňou! Svetom novej SNG vás prevedie
                        <span class="font-bold text-red-pastel">Ester</span> a jej atlas.sng.sk.
                    </p>
                </div>

                <AboutCollapsible :open="true" class="border-b-1 border-gray-softest">
                    <template v-slot:summary>Ako na to?</template>
                    <template v-slot:content>
                        <ul>
                            <li>Prihláste sa na SNG WIFI (heslo: welcometosng)</li>
                            <li>Vyberte si jednu z výstav a preskúmajte diela, na ktoré počas návštevy narazíte.</li>
                            <li>Kód pri diele vyťukajte do mriežky v aplikácii.</li>
                            <li>
                                Diela si môžete uložiť do svojej kolekcie a poslať na e-mail a vrátiť sa k nim doma s
                                rozšírenými informáciami z archívu.
                            </li>
                        </ul>

                        <p class="my-4">
                            Ester vám pri putovaní výstavou ponúkne videá zo zákulisia a originálne pohľady na diela od
                            vystavujúcich osobností, alebo návštevníkov a návštevníčok.
                        </p>
                    </template>
                </AboutCollapsible>
                <AboutCollapsible class="border-b-1 border-gray-softest">
                    <template v-slot:summary>Projekt</template>
                    <template v-slot:content></template>
                </AboutCollapsible>
            </div>
        </div>
    </Transition>
</template>

<style scoped>
ul {
    @apply ml-6 list-disc;
}

li {
    @apply pl-2.5;
}

.v-enter-from > div,
.v-leave-to > div {
    @apply -translate-x-full;
}
</style>

<script setup>
import AboutCollapsible from './AboutCollapsible.vue'
import SvgLogo from './svg/Logo.vue'

const props = defineProps(['opened'])
</script>
