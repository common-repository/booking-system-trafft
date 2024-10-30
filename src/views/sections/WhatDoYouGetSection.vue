<template>
  <div>
    <spacer :height="$grid.desktop ? 118 : 88" />

    <component
        :is="$grid.desktop ? 'h2' : 'h3'"
        class="text-align-center"
    >
      What do you get with Trafft?
    </component>

    <spacer :height="$grid.desktop ? 48 : 24" />

    <section class="trafft-what-do-you-get-section">
      <div class="trafft-what-do-you-get-section__item">
        <img v-if="$grid.desktop" :src="`${$trafft_img_url}/illustrations/illustration_2.jpg`" alt="" />
        <img v-else :src="`${$trafft_img_url}/illustrations/illustration_2_medium.jpg`" alt="" />
      </div>

      <div class="trafft-what-do-you-get-section__item">
        <ul
            class="trafft-what-do-you-get-section__list"
            :style="{ '--mark': `url('${$trafft_img_url}/check-icon.svg')` }"
        >
          <li><b>Online booking and payment processing:</b> Allow your customers to book appointments online 24/7</li>
          <li><b>Tailored Booking Experience:</b> Craft modern and mobile-responsive booking form to showcase your services. Select colors, fonts, and arrange steps in accordance with your business requirements, shaping a booking process that perfectly aligns with your brand</li>
          <li><b>Employee management:</b> Assign services to employees, set personalized schedules, define days off, and special days for each team member</li>
          <li><b>Automated reminders:</b> Reduce no-shows with automated email, SMS or WhatsApp reminders</li>
          <li><b>Comprehensive Dashboard:</b> Consistently observe performance metrics, occupancy rates, and track revenue across various time intervals</li>
          <li><b>Marketing tools:</b> Promote your business with automatic email campaigns and track conversion rates and customers activity</li>
        </ul>

        <a href="https://trafft.com/features/" target="__blank">
          <adm-button class="tr-ml-34">Explore Features</adm-button>
        </a>
      </div>
    </section>
  </div>
</template>

<script setup>
import Spacer from "@/components/Spacer/Spacer.vue";
</script>

<style lang="scss">
.trafft-what-do-you-get-section {
  display: flex;
  align-items: flex-start;
  gap: 48px;

  @include tablet-down {
    flex-direction: column;
    gap: 24px;
  }

  &__item {
    flex: 1 1 0;
    width: 100%;

    img {
      width: 100%;
      border-radius: 24px;
      object-fit: cover;

      @include tablet-down {
        height: 250px;
      }

      @include phone-down {
        height: 150px;
      }
    }
  }

  &__list {
    font-size: 15px;
    font-weight: 500;
    line-height: 24px;
    margin: 0 0 24px 0;

    li {
      margin-bottom: 12px;
      position: relative;
      padding-left: 34px;

      &::before {
        left: 0;
        content: '';
        height: 30px;
        width: 30px;
        position: absolute;
        background: var(--mark);
        top: calc(50% - 15px);
      }
    }

    b {
      font-weight: 700;
    }
  }

}
</style>