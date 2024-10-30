<template>
  <main>
    <InputSection />
    <ContentWrapper color="white">
      <EasyWaysToEmbedSection />
      <WhatDoYouGetSection />
    </ContentWrapper>
  </main>
</template>
<script setup>
import InputSection from "@/views/sections/InputSection.vue";
import EasyWaysToEmbedSection from "@/views/sections/EasyWaysToEmbedSection.vue";
import ContentWrapper from "@/components/ContentWrapper/ContentWrapper.vue";
import WhatDoYouGetSection from "@/views/sections/WhatDoYouGetSection.vue";
</script>