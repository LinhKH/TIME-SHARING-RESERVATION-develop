<template>
  <div v-if="textLink || textHelpTop">
    <a
      :href="goToSpaceDetailClient"
      target="_blank"
      class="group inline-block px-1 py-[2px] bg-[#ffbd00] rounded-sm text-white cursor-pointer hover:bg-[#fff1cc] hover:text-[#ffbd00] mr-1"
    >
      <i class="fa fa-external-link text-white group-hover:text-[#ffbd00]"></i>
      {{ textLink }}
    </a>
    <span>
      {{ textHelpTop }}
    </span>
  </div>
  <div class="w-full h-[50px] bg-[#555] flex items-center justify-center text-lg text-white">
    {{ title }}
  </div>
  <div class="mt-1">
    {{ textHelp }}
  </div>
</template>

<script>
import { ROUTER_PATH } from "@/const";
import { useRoute } from "vue-router";
import { computed } from "@vue/runtime-core";
export default {
  name: "HeaderSpaces",
  props: {
    title: String,
    textHelp: String,
    textLink: String,
    textHelpTop: String,
  },
  setup() {
    const route = useRoute();
    const idSpace = route.query.id;
    const goToSpaceDetailClient = computed(() => {
      return `${ROUTER_PATH.HOME}${idSpace}/${ROUTER_PATH.SPACE_DETAILS_CLIENT}`;
    });
    return {
      goToSpaceDetailClient,
    };
  },
};
</script>

<style scoped></style>
