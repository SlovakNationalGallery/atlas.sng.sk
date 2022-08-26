<template>
    <Header />
    <div class="min-h-[calc(100vh-3rem-4px)]">
        <router-view v-slot="{ Component }">
            <transition
                enter-active-class="transition-transform duration-500"
                leave-active-class="transition-transform duration-500"
                enter-to-class="transform translate-x-0"
                enter-from-class="transform translate-x-full"
                leave-to-class="transform -translate-x-full"
                leave-from-class="transform translate-x-0"
            >
                <component :is="Component" />
            </transition>
        </router-view>
    </div>
</template>

<script setup>
import Header from './/components/Header.vue'
import { onMounted } from 'vue'

const setViewHeight = () => {
    let vh = window.innerHeight * 0.01
    document.documentElement.style.setProperty('--vh', `${vh}px`)
}

onMounted(async () => {
    setViewHeight()
    window.addEventListener('resize', () => {
        setViewHeight()
    })
})
</script>
