<template>
  <div v-if="idPurposeOfUse">
    <LayoutInput :iconPrev="`fa fa-upload mr-1`" :labelText="`アップロード`">
      <input
        id="fileupload"
        ref="fileupload"
        type="file"
        accept="image/png, image/jpeg"
        @change="handleUploadImagePurposeOfUse"
        class="hidden"
      />
      <div>
        <label
          class="border border-solid border-[#7c7777] text-[#7c7777] px-[10px] py-[5px] cursor-pointer rounded hover:bg-[#ddd]"
          for="fileupload"
          >Choose File</label
        >
        <span class="ml-[15px]">{{ nameImage }}</span>
      </div>
    </LayoutInput>
    <LayoutInput :iconPrev="`fa fa-picture-o mr-1`" :labelText="`画像`">
      <div class="flex flex-wrap" v-if="listImagesPurposeOfUse.length">
        <div
          class="w-[30%] pr-[20px] mb-[20px]"
          v-for="(itemImagePurposeOfUse, indexImageCompilation) in listImagesPurposeOfUse"
          :key="indexImageCompilation"
        >
          <div class="p-3 h-[360px] bg-[#f5f5f5] border border-solid border-[#ddd] rounded">
            <div class="w-full h-full bg-white border border-solid border-[#ddd] rounded">
              <div class="w-4/5 h-[100px] mt-2 mx-auto">
                <img :src="itemImagePurposeOfUse.url_img" alt="image" class="w-full h-full object-contain" />
              </div>
              <div class="grid grid-cols-3 gap-1 mt-3 px-2">
                <div class="" v-for="(item, index) in optionSettingPurposeOfUse" :key="index">
                  <input
                    :id="`${itemImagePurposeOfUse.id}_${index}`"
                    type="radio"
                    class="mr-1"
                    :value="item.value"
                    v-model="formDataType[itemImagePurposeOfUse.id]"
                  />
                  <label :for="`${itemImagePurposeOfUse.id}_${index}`" class="font-bold cursor-pointer select-none">
                    {{ item.label }}
                  </label>
                </div>
              </div>
              <div class="mt-2 flex justify-center">
                <button class="py-2 px-3 text-white rounded bg-[#ffbd00] hover:translate-y-1 mr-10">
                  {{ $t("common.keep") }}
                </button>
                <button
                  class="py-2 px-3 text-white rounded bg-[#d9534f] hover:bg-[#c9302c]"
                  @click="() => handleDeleteImagePurposeOfUse(itemImagePurposeOfUse.id)"
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
  <div class="mt-[10px] font-bold" v-else>画像は、利用目的が一旦保存された後にアップロードできるようになります。</div>
</template>

<script>
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import { optionSettingPurposeOfUse } from "@/const/options";
import { uploadImageSettingPurposeOfUse, getListImagePurpose, deleteImagePurpose } from "@/api";
import { useRoute } from "vue-router";
import { useI18n } from "vue-i18n";
import { inject, ref, reactive } from "vue";
import { useStore } from "vuex";
import { MODULE_STORE } from "@/const";

export default {
  name: "Image",
  components: { LayoutInput },
  setup() {
    const { t } = useI18n();
    const toast = inject("$toast");
    const store = useStore();
    const route = useRoute();
    const listImagesPurposeOfUse = ref([]);
    const formDataType = reactive({});
    const idPurposeOfUse = route.query.idPurposeOfUse;
    const fileupload = ref(null);
    const nameImage = ref();
    const getListImagePurposeFromApi = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getListImagePurpose(idPurposeOfUse);
        console.log("list image", res);
        listImagesPurposeOfUse.value = [...res];
        res.forEach((item) => {
          formDataType[item.id] = optionSettingPurposeOfUse[0].value;
        });
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    const handleUploadImagePurposeOfUse = async (event) => {
      const file = event.target.files[0];
      const formData = new FormData();
      formData.append("file", file);
      formData.append("type", optionSettingPurposeOfUse[0].value);

      nameImage.value = file.name;
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await uploadImageSettingPurposeOfUse(idPurposeOfUse, formData);
        getListImagePurposeFromApi();
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    // console.log("12312", this.$refs.fileupload);
    const handleDeleteImagePurposeOfUse = async (idImage) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await deleteImagePurpose(idImage);
        nameImage.value = "";
        getListImagePurposeFromApi();
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    const initData = () => {
      if (idPurposeOfUse) {
        getListImagePurposeFromApi();
      }
    };
    initData();
    return {
      formDataType,
      handleUploadImagePurposeOfUse,
      optionSettingPurposeOfUse,
      listImagesPurposeOfUse,
      handleDeleteImagePurposeOfUse,
      fileupload,
      nameImage,
      idPurposeOfUse,
    };
  },
};
</script>

<style lang="scss" scoped></style>
