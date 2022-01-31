<template>
    <div class="w-full border border-black h-0 pb-full">
        <div class="p-3"><div class="w-full h-0 pb-full border-2 border-black rounded-full" :class="{ 'bg-black': isChecked }"></div></div>
    </div>
</template>

<script>
  export default {
      props: ['isChecked']
  }
</script>