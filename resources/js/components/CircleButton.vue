<template>
    <div class="w-full border border-black h-0 pb-full">
        <div class="p-3">
            <div
                class="-mt-0.5 -ml-0.5 w-full h-0 pb-full border-2 border-black box-content rounded-full"
                :class="{ 'bg-black': isChecked }"
            ></div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['isChecked'],
}
</script>
