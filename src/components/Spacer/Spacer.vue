<template>
  <div :style="{ height: `${ height }px` }" />
</template>

<script>
export default {
  name: "Spacer",
  props: {
    height: {
      type: Number,
      default: 0,
    }
  }
}
</script>

<style scoped>

</style>