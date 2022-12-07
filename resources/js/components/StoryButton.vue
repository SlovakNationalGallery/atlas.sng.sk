<template>
    <router-link
        :to="{ name: 'story', params: { id: story_id } }"
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
                            {{ $t('Exhibition trail containing the artwork') }}
                        </div>
                        <div class="text-sm">{{ $t('Go to the trail') }}</div>
                    </div>
                </div>
            </div>
            <ChatCircleSmall />
        </div>
    </router-link>
</template>

<script setup>
import ChatCircleSmall from './svg/ChatCircleSmall.vue'

const props = defineProps(['story_id'])
</script>
