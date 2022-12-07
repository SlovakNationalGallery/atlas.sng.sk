<template>
    <Transition :duration="300">
        <div class="fixed inset-0 overflow-hidden md:max-w-lg md:mx-auto z-10" v-if="opened">
            <div class="bg-white duration-300 h-full overflow-y-auto pt-[48px]">
                <div class="border-b-2 border-gray-softest">
                    <div class="flex justify-between items-end my-8">
                        <div class="mx-4 self-items-end">
                            <SvgLogo class="!h-[48px] !w-[48px] mb-[14px] ml-[-5.25px]" viewBox="0 0 32 32" />
                            <h1 class="font-bold leading-[1]">
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

                <AboutCollapsible :open="true" class="border-b-2 border-gray-softest">
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
                <AboutCollapsible class="border-b-2 border-gray-softest">
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
