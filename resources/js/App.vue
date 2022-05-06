<template>
    <router-view />
</template>

<script type="text/javascript">
    export default {
      methods: {
        setViewHeight: function() {
          let vh = window.innerHeight * 0.01
          document.documentElement.style.setProperty('--vh', `${vh}px`)
        },
      },
      mounted: function() {
        this.setViewHeight()
        window.addEventListener('resize', () => {
          this.setViewHeight()
        })
      },
    }
</script>