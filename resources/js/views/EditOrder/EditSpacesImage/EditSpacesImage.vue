<template>
  <PreviewImage
    v-if="listImages"
    :listImages="listImages"
    :typeImage="IMAGE_TYPE.NORMAL"
    :typeDelete="IMAGE_TYPE_DELETE.NORMAL"
    @updateList="initData"
  ></PreviewImage>
</template>

<script>
import { useStore } from "vuex";
import { useRoute } from "vue-router";
import { MODULE_STORE, STEP_EDIT_SPACE, IMAGE_TYPE, IMAGE_TYPE_DELETE } from "@/const";
import { getDetailSpaceImages } from "@/api";
import PreviewImage from "@/components/PreviewImage";
import { inject, ref } from "vue";
import { useI18n } from "vue-i18n";

export default {
  name: "EditSpacesImage",
  components: { PreviewImage },
  setup() {
    const store = useStore();
    const route = useRoute();
    const { t } = useI18n();
    const toast = inject("$toast");
    const id = route.params.id;
    const listImages = ref([]);
    const initData = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const response = await getDetailSpaceImages(id);

        let convertArray = [];
        if (response.data.imageFiles.length) {
          // convertArray = response.data.imageFiles.map((item) => ({
          //   title: item.title,
          //   url_image: item.path_image,
          //   id: item.id,
          // }));
          convertArray = response.data.imageFiles;
        }
        listImages.value = convertArray;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    initData();
    store.dispatch(
      `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
      STEP_EDIT_SPACE.IMAGE
    );
    return {
      listImages,
      IMAGE_TYPE,
      IMAGE_TYPE_DELETE,
      initData,
    };
  },
};
</script>

<style scoped></style>
