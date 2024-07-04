<template>
  <div>
    <LayoutInput :labelText="$t('compilation_setting.upload')" :iconPrev="`fa fa-upload mr-1`">
      <input type="file" accept="image/png, image/jpeg" @change="handleCreateImageSummary" />
    </LayoutInput>
    <LayoutInput :customCss="`mt-5`" :labelText="$t('compilation_setting.image')" :iconPrev="`fa fa-picture-o mr-1`">
      <div class="flex flex-wrap" v-if="listImagesCompilation.length">
        <div
          class="w-[30%] pr-[20px] mb-[20px]"
          v-for="(itemImageCompilation, indexImageCompilation) in listImagesCompilation"
          :key="indexImageCompilation"
        >
          <div class="p-3 h-[360px] bg-[#f5f5f5] border border-solid border-[#ddd] rounded">
            <div class="w-full h-full bg-white border border-solid border-[#ddd] rounded">
              <div class="w-4/5 h-[100px] mt-2 mx-auto">
                <img :src="itemImageCompilation.s3key" alt="image" class="w-full h-full object-contain" />
              </div>
              <div class="flex flex-wrap pl-3">
                <div class="w-1/2 break-words mt-2" v-for="(item, index) in optionsImageSettingSummary" :key="index">
                  <input
                    :id="`${itemImageCompilation.rental_space_compilation_image_id}_${index}`"
                    type="radio"
                    class="mr-1"
                    :value="item.value"
                    v-model="typeImage[itemImageCompilation.rental_space_compilation_image_id]"
                  />
                  <label
                    :for="`${itemImageCompilation.rental_space_compilation_image_id}_${index}`"
                    class="font-bold cursor-pointer select-none"
                  >
                    {{ item.label }}
                  </label>
                </div>
              </div>
              <div class="mt-2 flex justify-center">
                <button
                  class="py-2 px-3 text-white rounded bg-[#ffbd00] hover:translate-y-1 mr-10"
                  @click="() => handleUpdateImageSummary(itemImageCompilation.rental_space_compilation_image_id)"
                >
                  {{ $t("common.keep") }}
                </button>
                <button
                  class="py-2 px-3 text-white rounded bg-[#d9534f] hover:bg-[#c9302c]"
                  @click="() => handleDeleteImageSummary(itemImageCompilation.rental_space_compilation_image_id)"
                >
                  {{ $t("common.delete") }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </LayoutInput>
  </div>
</template>

<script>
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import { uploadFiles, uploadImageSummary, deleteImageSummarySetting, updateImageSummary } from "@/api";
import { useI18n } from "vue-i18n";
import { inject, reactive, watch } from "vue";
import { optionsImageSettingSummary } from "@/const/options";
import { useRoute } from "vue-router";
import { MODULE_STORE } from "@/const";
import { useStore } from "vuex";

export default {
  name: "Image",
  components: { LayoutInput },
  emits: ["updateImageSummary"],
  props: { listImagesCompilation: Array },
  setup(props, context) {
    const { t } = useI18n();
    const toast = inject("$toast");
    const typeImage = reactive({});
    const store = useStore();
    const route = useRoute();
    const idSummary = route.query.idSummary;

    watch(
      () => props.listImagesCompilation,
      () => {
        props.listImagesCompilation.forEach((item) => {
          typeImage[item.rental_space_compilation_image_id] = item.type;
        });
      }
    );
    const handleUpdateImageSummary = async (idImage) => {
      try {
        await updateImageSummary(idImage, { type: typeImage[idImage] });
        context.emit("updateImageSummary");
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
    };
    const handleCreateImageSummary = async (event) => {
      const file = event.target.files[0] || "";
      if (file) {
        const formData = new FormData();
        formData.append("file", file);
        formData.append("type", "image");
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          const resFile = await uploadFiles(formData);
          const params = {
            name: resFile.path_file.split("/").pop(),
            type: optionsImageSettingSummary[0].value,
            width: resFile.width,
            height: resFile.length,
            extension: resFile.extension,
            s3key: resFile.path_file,
            length: resFile.length,
          };
          await uploadImageSummary(idSummary, params);
          context.emit("updateImageSummary");
          event.target.value = "";
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        }
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const handleDeleteImageSummary = async (idImage) => {
      if (confirm("画像を削除しますか？")) {
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          await deleteImageSummarySetting(idImage);
          context.emit("updateImageSummary");
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        }
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };

    return {
      typeImage,
      handleCreateImageSummary,
      optionsImageSettingSummary,
      handleDeleteImageSummary,
      handleUpdateImageSummary,
    };
  },
};
</script>
