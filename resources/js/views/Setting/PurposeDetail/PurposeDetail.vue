<template>
  <Menu :listMenus="listMenus" :isScreen="isScreen" @onChangeTab="(value) => (isScreen = value)" />
  <Info v-if="isScreen === TYPE_COMMON.content" :actionType="actionType" />
  <Image v-if="isScreen === TYPE_COMMON.image" />
</template>

<script>
import Menu from "./child/Menu.vue";
import Info from "./child/Info.vue";
import Image from "./child/Image.vue";
import { useI18n } from "vue-i18n";
import { ref, watch } from "vue";
import { TYPE_COMMON, ACTIONS_TYPE } from "@/const";
import { useRoute } from "vue-router";

export default {
  name: "PurposeDetail",
  components: {
    Menu,
    Image,
    Info,
  },
  setup() {
    const { t } = useI18n();
    const route = useRoute();
    const actionType = ref(ACTIONS_TYPE.CREATE);
    watch(
      () => route.query.idPurposeOfUse,
      (val) => {
        if (val) {
          actionType.value = ACTIONS_TYPE.UPDATE;
        } else {
          actionType.value = ACTIONS_TYPE.CREATE;
        }
      },
      { immediate: true }
    );
    const isScreen = ref(TYPE_COMMON.content);
    const listMenus = [
      {
        icon: "fa fa-info-circle",
        text: t("footer_link.detail"),
        type: TYPE_COMMON.content,
      },
      {
        icon: "fa fa-picture-o",
        text: "お知らせ",
        type: TYPE_COMMON.image,
      },
    ];

    return {
      listMenus,
      isScreen,
      TYPE_COMMON,
      actionType,
    };
  },
};
</script>

<style></style>
