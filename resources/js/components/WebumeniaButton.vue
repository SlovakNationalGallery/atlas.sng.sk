<template>
    <a :href="props.url" target="_blank" class="bg-green border-2 border-green p-2.5 rounded-xl block">
        <div class="flex cursor-pointer">
            <div class="grow">
                <div class="flex">
                    <div class="shrink-0">
                        <div class="bg-black w-16 h-16 rounded-xl"></div>
                    </div>
                    <div class="mx-3 self-center">
                        <div class="font-bold">Otvor v Archíve</div>
                        <div class="text-sm">
                            na Web Umenia SNG
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <svg
                    class="fill-none h-[20px] w-[20px] stroke-2 stroke-black [stroke-linecap:round] [stroke-linejoin:round]">
                    <path d="M18.25 7.375V1.75H12.625" />
                    <path d="M11.5 8.5L18.25 1.75" />
                    <path
                        d="M15.25 11.5V17.5C15.25 17.6989 15.171 17.8897 15.0303 18.0303C14.8897 18.171 14.6989 18.25 14.5 18.25H2.5C2.30109 18.25 2.11032 18.171 1.96967 18.0303C1.82902 17.8897 1.75 17.6989 1.75 17.5V5.5C1.75 5.30109 1.82902 5.11032 1.96967 4.96967C2.11032 4.82902 2.30109 4.75 2.5 4.75H8.5" />
                </svg>
            </div>
        </div>
    </a>
</template>

<script setup>
const props = defineProps(['url'])
</script>
