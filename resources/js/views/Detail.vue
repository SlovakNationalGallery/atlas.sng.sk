<template>
    <div class="border-black border-t-2 flex items-center">
        <router-link to="/">
            <div class="bg-black p-2" >
                <svg class="h-9 w-9" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="4" cy="4" r="3.30435" stroke="white" stroke-width="1.3913"/>
                    <circle cx="4" cy="16" r="3.30435" stroke="white" stroke-width="1.3913"/>
                    <circle cx="4" cy="28" r="4" fill="white"/>
                    <circle cx="16" cy="4" r="4" fill="white"/>
                    <circle cx="16" cy="16" r="4" fill="white"/>
                    <circle cx="16" cy="28" r="4" fill="white"/>
                    <circle cx="28" cy="4" r="4" fill="white"/>
                    <circle cx="28" cy="16" r="3.30435" stroke="white" stroke-width="1.3913"/>
                    <circle cx="28" cy="28" r="3.30435" stroke="white" stroke-width="1.3913"/>
                </svg>
            </div>
        </router-link>
        <h1 class="p-3">{{ $t('SNG Bookmarks') }}</h1>
    </div>
    <div class="bg-gray-200 h-48 border-black border-t-2">
        <!-- preview image -->
    </div>
    <div class="h-full border-black border-t-2 p-4">
        <h2 class="text-xl font-bold">Zimná Bratislava</h2>
        <h3 class="">Miloš Alexander Bazovský · 1942</h3>
        <div class="py-4 text-sm">
            In the works of Gibson, a predominant concept is the concept of material consciousness. It could be said that Sartre uses the term ‘the subculturalparadigm of discourse’ to denote a self-referential paradox...
            {{ $route.params.id }}
        </div>
    </div>
</template>

<script>
    export default {

    }
</script>