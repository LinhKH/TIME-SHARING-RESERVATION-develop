<template>
  <div class="flex justify-center mt-4">
    <button
      class="block w-fit p-2 bg-[#555] text-white mr-3 rounded-xl cursor-pointer hover:translate-y-1 transition-all"
      @click="handleBack"
    >
      {{ $t("spaces_image_page.return") }}
    </button>
    <button
      class="block w-fit p-2 bg-[#555] text-white rounded-xl cursor-pointer hover:translate-y-1 transition-all"
      @click="handleNextPage"
    >
      {{ nextPageButton }}
    </button>
  </div>
</template>

<script>
import { computed } from "vue";
import { useI18n } from "vue-i18n";

export default {
  name: "ButtonNextStep",
  props: {
    nextPage: {
      type: String,
    },
  },
  data() {
    return {};
  },

  setup(props) {
    const { t } = useI18n();
    const nextPageButton = computed(() =>
      props.nextPage ? `次のステップ（${props.nextPage}）へ進む` : t("spaces_image_page.next_step")
    );
    return {
      nextPageButton,
    };
  },

  mounted() {},

  methods: {
    handleBack() {
      this.$emit("onBack");
    },
    handleNextPage() {
      this.$emit("onNext");
    },
  },
};
</script>

<style scoped></style>
