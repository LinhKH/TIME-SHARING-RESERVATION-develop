<template>
  <div class="flex border-b border-solid border-[#ddd]">
    <div
      class="p-3 hover:bg-[#eee] bg-white cursor-pointer select-none"
      :class="isInfoScreen ? styleInfo.active.button : styleInfo.disabled.button"
      @click="typeScreen = TYPE_SCREEN.INFO_SETTING_COMPILATION"
    >
      <i
        class="fa fa-info-circle mr-1"
        aria-hidden="true"
        :class="isInfoScreen ? styleInfo.active.icon : styleInfo.disabled.icon"
      ></i>
      <span :class="isInfoScreen ? styleInfo.active.text : styleInfo.disabled.text">情報</span>
    </div>
    <div
      class="p-3 hover:bg-[#eee] bg-white cursor-pointer select-none"
      :class="isImageScreen ? styleInfo.active.button : styleInfo.disabled.button"
      @click="typeScreen = TYPE_SCREEN.IMAGE_SETTING_COMPILATION"
    >
      <i
        class="fa fa-picture-o mr-1"
        aria-hidden="true"
        :class="isImageScreen ? styleInfo.active.icon : styleInfo.disabled.icon"
      ></i>
      <span :class="isImageScreen ? styleInfo.active.text : styleInfo.disabled.text">画像</span>
    </div>
  </div>
  <Info v-show="isInfoScreen" class="mt-2" :isUpdate="isUpdate" :formDataInfo="formDataInfo" />
  <Image
    v-show="isImageScreen"
    class="mt-2"
    :listImagesCompilation="listImagesCompilation"
    @updateImageSummary="() => initData()"
  />
</template>

<script>
import Info from "./child/Info.vue";
import Image from "./child/Image.vue";
import { TYPE_SCREEN, MODULE_STORE } from "@/const";
import { ref, computed, inject } from "vue";
import { useI18n } from "vue-i18n";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
import { getDetailSummary } from "@/api";
import moment from "moment";
import { optionUse, optionEffectiveness } from "@/const/options";

export default {
  name: "CompilationDetail",
  components: { Info, Image },
  props: {
    isUpdate: {
      type: Boolean,
      default: false,
    },
  },
  setup() {
    const typeScreen = ref(TYPE_SCREEN.INFO_SETTING_COMPILATION);
    const { t } = useI18n();
    const toast = inject("$toast");
    const formDataInfo = ref({
      active: optionEffectiveness[1].value,
      use_purpose_category: optionUse[0].value,
      catch_ja: "",
      area_id: "",
      last_update: new Date(),
      meta_keywords: "",
      meta_description: "", 
      rental_space_id: {
        rental_space_ids__1: "",
      },
      access_key: "",
      title_ja: "",
      subtitle_ja: "",
      summary_ja: "",
    });
    const listImagesCompilation = ref([]);
    const store = useStore();
    const route = useRoute();
    const idCompilation = route.query.idSummary;
    const isInfoScreen = computed(() => typeScreen.value === TYPE_SCREEN.INFO_SETTING_COMPILATION);
    const isImageScreen = computed(() => typeScreen.value === TYPE_SCREEN.IMAGE_SETTING_COMPILATION);
    const styleInfo = {
      disabled: {
        button: "",
        icon: "text-[#7f8084]",
        text: "text-[#7f8084]",
      },
      active: {
        button: "border-t border-r border-l border-solid border-[#ddd] mb-[-1px]",
        icon: "text-[#333]",
        text: "text-[#333]",
      },
    };
    const initData = async () => {
      if (!idCompilation) return;
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getDetailSummary(idCompilation);
        formDataInfo.value = {
          ...res,
          last_update: moment(res.last_update, "MM/DD/YYYY").toDate(),
          area_id: Number(res.area_id),
          active: Number(res.active),
        };
        listImagesCompilation.value = res.rental_space_compilation_images;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    initData();
    return {
      typeScreen,
      isInfoScreen,
      isImageScreen,
      styleInfo,
      TYPE_SCREEN,
      formDataInfo,
      listImagesCompilation,
      initData,
    };
  },
};
</script>

<style scoped></style>
