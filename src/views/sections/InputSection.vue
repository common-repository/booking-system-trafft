<template>
  <ContentWrapper>
    <section class="trafft-add-booking-form-section">
      <div class="trafft-add-booking-form-section__item">
        <component
            :is="$grid.desktop ? 'h1' : 'h2'"
        >
          Add Booking Form to any page
        </component>

        <p>
          Add a Free Booking form to any page in WordPress and increase the number of bookings by encouraging your customers to book online.
        </p>

        <adm-alert
            v-if="notification.text"
            :type="notification.type"
            :description="notification.text"
            class="tr-mb-12"
        />

        <div class="trafft-add-booking-form-section__item__form tr-mb-24">
          <label>
            <div class="flex-align-center">
              Trafft account URL
              {{ ' ' }}
              <adm-tooltip>
                <template #content>
                  Please input the name you provided during<br />
                  the sign-up process on Trafft. This name<br />
                  has become an integral part of your URL.
                </template>
                <adm-icon icon="info" type="grey" size="small" />
              </adm-tooltip>
            </div>
            <adm-input
                v-model="tenantName"
                name="trafft_option[tenantName]"
                id="tenantName"
            >
              <template #suffix>
                .trafft.com
              </template>
            </adm-input>
          </label>

          <adm-button
              :loading="loading"
              @click="setOptions"
          >
            Save
          </adm-button>
        </div>

        <div class="trafft-add-booking-form-section__item__help">
          <div
              class="trafft-add-booking-form-section__item__help__button flex-align-center"
              @click="showTip = !showTip"
          >
            What is it and how to get it?
            <adm-button
                class="tr-ml-8"
                icon-only
                :icon-start="showTip ? 'arrow-up' :'arrow-down'"
                size="micro"
                color="grey"
            />
          </div>

          <div
              v-if="showTip === true"
              class="trafft-add-booking-form-section__item__help__text"
          >
            <p>This plugin is an integration for the Trafft booking platform, and in order to use it you need a Trafft account.</p>

            <p>If you already have a Trafft account, just paste the part of the booking website URL to finish the URL in the field above. You can always copy it from the browser:</p>
            <img :src="`${$trafft_img_url}/illustrations/help_trafft_url.png`" alt="" />
            <p>If you DON’T have a Trafft account yet, just sign up <a href="https://signup.trafft.com" target="_blank">here</a>, and you’ll create an account URL during the process.</p>

            <p>Once you enter it here, click the “Save” button, your Trafft account will be linked with the plugin, allowing you to add booking form to your WordPress page using one of the page builders and Trafft shortcode.</p>
          </div>
        </div>

        <p>Don’t have Trafft account? <a href="https://signup.trafft.com" target="_blank">Sign Up -></a></p>
      </div>

      <div class="trafft-add-booking-form-section__item">
        <img v-if="$grid.desktop" :src="`${$trafft_img_url}/illustrations/illustration_1.jpg`" alt="" />
        <img v-else :src="`${$trafft_img_url}/illustrations/illustration_1_medium.jpg`" alt="" />
      </div>
    </section>
  </ContentWrapper>
</template>

<script setup>
import ContentWrapper from "@/components/ContentWrapper/ContentWrapper.vue";

// * Import from Vue
import {
  ref,
  onMounted
} from "vue"

let tenantName = ref('')
let loading = ref(false)
let showTip = ref(false)
let notification = ref({
  text: null,
  type: 'positive',
});

onMounted(() => {
  getOptions()
})

const getOptions = () => {
  const data = new FormData()

  data.append( 'action', 'get_options' )
  data.append( 'trafft_nonce', trafft_plugin.trafft_nonce )

  fetch(trafft_plugin.ajax_url, {
    method: "POST",
    credentials: 'same-origin',
    dataType: 'json',
    body: data
  }).then(response => {
    response.json().then(data => {
      tenantName.value = data.tenantName
    })
  }).catch((error) => {
    console.error(error)
  })
}

const setOptions = () => {
  const data = new FormData()
  loading.value = true

  data.append( 'action', 'set_options' )
  data.append( 'trafft_nonce', trafft_plugin.trafft_nonce )
  data.append('tenantName', tenantName.value)

  fetch(trafft_plugin.ajax_url, {
    method: "POST",
    credentials: 'same-origin',
    dataType: 'json',
    body: data
  }).then(response => {
    response.json().then(data => {
      notification.value.text = data.text;
      notification.value.type = data.type;
    })
  }).catch((error) => {
    console.error(error)
  }).finally(() => {
    loading.value = false
  });
}

</script>

<style lang="scss">
.trafft-add-booking-form-section {
  display: flex;
  align-items: flex-start;
  gap: 48px;

  @include tablet-down {
    flex-direction: column-reverse;
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

    &__form {
      display: flex;
      align-items: flex-end;
      gap: 24px;

      label {
        flex-grow: 1;
        font-size: 14px;
        line-height: 20px;
        font-weight: 500;
      }
    }

    &__help {
      &__button {
        font-size: 14px;
        line-height: 20px;
        cursor: pointer;
      }
    }
  }
}
</style>