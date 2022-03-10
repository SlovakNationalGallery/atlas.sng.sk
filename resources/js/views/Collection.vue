<template>
    <Header :code="1">{{ $t('My collection') }}</Header>

    <div class="h-full border-black p-4 border-t-2">
        diela
    </div>
    <div class="w-full h-24 fixed bottom-0">
        <div class="p-4">
            <div class="flex space-x-4">
                <ConfirmButton class="bg-black text-white">{{ $t('Share collection link') }}</ConfirmButton>
            </div>
        </div>
    </div>
</template>

<script>
    import {ref, onMounted} from 'vue'
    import { useRoute } from 'vue-router'
    import { getActiveLanguage } from 'laravel-vue-i18n';
    import { useItemsStore } from '../stores/ItemsStore'
    import ConfirmButton from '../components/ConfirmButton.vue'
    import Header from '../components/Header.vue'

    export default {
        components: { ConfirmButton, Header },
        setup() { }
    }
</script>