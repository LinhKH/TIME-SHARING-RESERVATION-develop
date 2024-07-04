<template>
  <PreviewImage
    v-if="listImages"
    :listImages="listImages"
    :typeImage="IMAGE_TYPE.DIRECTION_STATION"
    :typeDelete="IMAGE_TYPE_DELETE.DIRECTION_STATION"
    @updateList="initData"
  ></PreviewImage>
</template>

<script>
import PreviewImage from "@/components/PreviewImage";
import { useStore } from "vuex";
import { MODULE_STORE, STEP_EDIT_SPACE, IMAGE_TYPE, IMAGE_TYPE_DELETE } from "@/const";
import { getDetailSpaceImagesDirectionsStation } from "@/api";
import { useRoute } from "vue-router";
import { useI18n } from "vue-i18n";
import { inject, ref } from "vue";

export default {
  name: "EditDirectionsStationImage",
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
        const response = await getDetailSpaceImagesDirectionsStation(id);
        let convertArray = [];
        if (response.data.imageFiles.length) {
          convertArray = response.data.imageFiles.map((item) => ({
            title: item.title,
            url_image: item.path_image,
            id: item.id,
          }));
        }
        listImages.value = convertArray;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    store.dispatch(
      `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
      STEP_EDIT_SPACE.STATION_ROUTE
    );
    initData();
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
