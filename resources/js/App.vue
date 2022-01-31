<template>
    <div>
        <h1>Záložky SNG</h1>
    </div>
    <div>
        <div class="max-w-screen-lg mx-auto p-4">
          <div class="grid grid-cols-3 gap-0 mt-12 border-collapse border border-black">
            <Button v-for="index in 9" :key="index"></Button>
            <div class="w-full border border-black">
                <div class="p-3 text-center">🌐</div>
            </div>
            <div class="w-full border border-black">
                <div class="p-3 text-center">CHECK</div>
            </div>
            <div class="w-full border border-black">
                <div class="p-3 text-center">?</div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
    import Button from './components/Button.vue'

    export default {
        components: { Button }
    }
</script>