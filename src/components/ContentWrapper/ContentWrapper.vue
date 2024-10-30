<template>
  <div
      :class="['trafft-content-wrapper', color ]"
  >
    <slot />
  </div>
</template>

<script setup>
const props = defineProps({
  color: {
    type: String,
    default: null,
  }
})

</script>

<style lang="scss" scoped>
.trafft-content-wrapper {
  padding: 70px;
  border-radius: 16px;

  @include tablet-down {
    padding: 40px;
  }

  @include phone-down {
    padding: 24px;
  }

  &.white {
    background-color: var(--white);
  }

  &.blue-400 {
    background-color: var(--blue-400);
  }
}
</style>