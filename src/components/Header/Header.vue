<template>
  <header class="trafft-page-header">
    <img :src="`${$trafft_img_url}/logo.svg`" alt="Trafft Logo" />
    <a href="https://trafft.com/contact/" target="__blank">
      <adm-button
          :icon-start="!$grid.mobile ? 'message-square' : undefined"
          color="grey"
          :icon-only="!$grid.mobile"
      >
        Contact us
      </adm-button>
    </a>
  </header>
</template>

<script>

export default {
  name: "Header"
}
</script>

<style lang="scss" scoped>
.trafft-page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 70px;

  @include tablet-down {
    padding: 0 40px;
  }

  @include phone-down {
    padding: 0 24px;
  }
}
</style>