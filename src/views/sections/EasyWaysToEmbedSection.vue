<template>
  <ContentWrapper color="blue-400">
    <component
        :is="$grid.desktop ? 'h2' : 'h3'"
        class="text-align-center"
    >
      Easy ways to embed booking forms
    </component>

    <spacer :height="$grid.desktop ? 48 : 24" />

    <div class="trafft-shortcodes-list-section">
      <!-- Gutenberg Block -->
      <div class="trafft-shortcodes-list-section__item">
        <div class="trafft-shortcodes-list-section__item__illustration">
          <img :src="`${$trafft_img_url}/illustrations/gutenberg.png`" alt="" />
        </div>
        <div class="trafft-shortcodes-list-section__item__description">
          <div class="trafft-shortcodes-list-section__item__description__header">
            <img :src="`${$trafft_img_url}/gutenberg-logo.svg`" alt="" />
            <h5>
              Gutenberg Editor
            </h5>
          </div>

          <p>
            Use Gutenberg Editor to add Trafft Booking form. Simply tap the plus button, input “Trafft” into the search field, then click or drag and drop the Trafft Booking element to your chosen section. To predefine particular category, service, employee and/or location you can activate the “Preselect Booking Parameters” in the right sidebar.
          </p>
        </div>
      </div>
      <!-- /Gutenberg Block -->

      <!-- Elementor Block -->
      <div class="trafft-shortcodes-list-section__item">
        <div class="trafft-shortcodes-list-section__item__illustration">
          <img :src="`${$trafft_img_url}/illustrations/elementor.png`" alt="" />
        </div>
        <div class="trafft-shortcodes-list-section__item__description">
          <div class="trafft-shortcodes-list-section__item__description__header">
            <img :src="`${$trafft_img_url}/elementor-logo.svg`" alt="" />
            <h5>
              Elementor blocks
            </h5>
          </div>

          <p>
            Utilize Elementor to incorporate Booking form onto your page. Enter “Trafft” into the search field, then either click or drag and drop the Trafft Booking element to your chosen section. If you want to predefine particular category, service, employee and/or location you can activate the “Preselect Booking Parameters” option.
          </p>
        </div>
      </div>
      <!-- /Elementor Block -->
    </div>
  </ContentWrapper>
</template>

<script setup>
import ContentWrapper from "@/components/ContentWrapper/ContentWrapper.vue";
import Spacer from "@/components/Spacer/Spacer.vue";
</script>

<style lang="scss">
.trafft-shortcodes-list-section {
  display: flex;
  gap: 48px;

  @include tablet-down {
    gap: 24px;
  }

  @include phone-down {
    flex-direction: column;
  }

  &__item {
    flex: 1 1 0;
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    padding: 16px;
    border-radius: 4px;
    background-color: var(--white);
    flex-direction: column;

    &__illustration {
      background-color: var(--blue-300);
      display: flex;
      align-items: flex-end;
      justify-content: center;
      flex: 0 1 150px;

      @include tablet-down {
        flex: 0 1 136px;
      }

      img {
        max-width: 100%;
      }
    }

    &__description {
      flex: 1 1 0;

      &__header {
        display: flex;
        align-items: center;
        gap: 8px;
      }
    }
  }
}
</style>