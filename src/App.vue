<template>
  <div class="trafft-body">
    <div class="trafft-page-wrapper">
      <Header />
      <RouterView />
    </div>
  </div>
</template>

<script setup>
import { RouterView } from 'vue-router'
import Header from "@/components/Header/Header.vue";
</script>

<style lang="scss">
  .trafft-body {
    background-color: var(--shade-200);
    color: var(--shade-900);
    margin-left: -20px;
    padding: 48px 20px;

    @include tablet-down {
      padding: 24px 0;
    }

    @include phone-down {
      padding: 16px 0;
      margin-left: -10px;
    }

    .trafft-page-wrapper {
      max-width: 1140px;
      margin: 0 auto;
    }
  }
</style>