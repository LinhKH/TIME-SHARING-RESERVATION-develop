<template>
  <HeaderSpaces
    :title="$t('spaces_image_page.image_registration')"
    :textHelp="$t('spaces_image_page.text_help_1')"
    :textLink="$t('spaces_image_page.preview_of_public_page')"
    :textHelpTop="$t('spaces_image_page.text_desc_1')"
  />
  <div class="border border-solid border-[#ddd] rounded mt-2">
    <LayoutForm :title="$t('spaces_image_page.image')" icon="fa fa-picture-o mr-1">
      <div>
        {{ $t("spaces_image_page.text_help_2") }}
      </div>
      <div class="mt-2">
        {{ $t("spaces_image_page.text_help_3") }}
      </div>
      <div class="mt-2">
        {{ $t("spaces_image_page.text_help_4") }}
      </div>
      <div class="mt-2">{{ $t("spaces_image_page.text_help_5") }}</div>
      <div class="mt-2 text-[red]">
        {{ $t("spaces_image_page.text_warning") }}
      </div>

      <draggable v-model="listImages" group="people" @start="dragging = true" @end="dragging = false" item-key="order">
        <template #item="{ element, index }">
          <div class="w-full p-5 bg-[#f5f5f5] my-2 border border-solid border-[#e3e3e3] rounded shadow-inner">
            <div class="w-full h-[129px] flex">
              <div
                class="w-[30px] h-full border border-solid border-[#e3e3e3] rounded bg-[#f5f5f5] flex items-center justify-center"
              >
                <i class="fa fa-exchange rotate-90" aria-hidden="true"></i>
              </div>

              <div
                class="w-[123px] h-full flex flex-col items-center justify-evenly bg-white border border-solid border-[#e3e3e3] rounded mx-2"
              >
                <div class="w-[90px] h-[90px]">
                  <img :src="element.src_img" class="w-full h-full object-cover" alt="image" />
                </div>
                <div class="flex">
                  <div
                    v-if="index"
                    @click="handleClickUp(index, listImages)"
                    class="flex items-center justify-center px-2 py-1 border border-solid border-[#e3e3e3] rounded cursor-pointer mr-2"
                  >
                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                  </div>
                  <div
                    v-if="index != listImages.length - 1"
                    @click="handleClickDown(index, listImages)"
                    class="flex items-center justify-center px-2 py-1 border border-solid border-[#e3e3e3] rounded cursor-pointer"
                  >
                    <i class="fa fa-chevron-down" aria-hidden="true"></i>
                  </div>
                </div>
              </div>

              <div class="w-full">
                <div class="w-full border border-solid border-[#ddd] rounded flex h-8">
                  <div class="flex items-center justify-center border-r border-solid border-[#ddd] w-10 bg-[#eee]">
                    <img :src="JapanIcon" alt="japan" class="w-9 object-cover" />
                  </div>
                  <FormKit
                    type="text"
                    v-model="listImages[index].title"
                    outer-class="w-full"
                    wrapper-class="h-full"
                    inner-class="h-full"
                    validation="required"
                    :validation-messages="{
                      required: $t('validation.required'),
                    }"
                    message-class="text-[red] mt-2 ml-6"
                    help-class=" mt-1"
                    input-class="px-2 w-full h-full focus:shadow-lg outline-none  focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 "
                  />
                </div>
                <button
                  @click="() => handleDeleteListImages(index, element.id)"
                  class="py-2 px-3 mt-2 text-[#d43f3a] bg-white border border-solid border-[#d43f3a] rounded hover:bg-[#d43f3a] hover:text-white"
                >
                  {{ $t("spaces_image_page.delete") }}
                </button>
              </div>
            </div>
          </div>
        </template>
      </draggable>
      <input type="file" class="mt-2" multiple accept="image/png, image/jpeg" @change="handleChangeListImage" />
    </LayoutForm>

    <LayoutForm :title="$t('spaces_image_page.degree_photo')" icon="fa fa-picture-o mr-1" :borderFooter="false">
      <div>
        {{ $t("spaces_image_page.text_help_2") }}
      </div>
      <div class="mt-2">
        {{ $t("spaces_image_page.text_help_3") }}
      </div>
      <div class="mt-2">
        {{ $t("spaces_image_page.text_help_4") }}
      </div>
      <div class="mt-2">{{ $t("spaces_image_page.text_help_5") }}</div>

      <draggable
        v-model="listImagePanorama"
        group="people"
        @start="dragging = true"
        @end="dragging = false"
        item-key="order"
      >
        <template #item="{ element, index }">
          <div class="w-full p-5 bg-[#f5f5f5] my-2 border border-solid border-[#e3e3e3] rounded shadow-inner">
            <div class="w-full h-[129px] flex">
              <div
                class="w-[30px] h-full border border-solid border-[#e3e3e3] rounded bg-[#f5f5f5] flex items-center justify-center"
              >
                <i class="fa fa-exchange rotate-90" aria-hidden="true"></i>
              </div>

              <div
                class="w-[123px] h-full flex flex-col items-center justify-evenly bg-white border border-solid border-[#e3e3e3] rounded mx-2"
              >
                <div class="w-[90px] h-[90px]">
                  <img :src="element.src_img" class="w-full h-full object-cover" alt="image" />
                </div>
                <div class="flex">
                  <div
                    v-if="index"
                    @click="handleClickUp(index, listImagePanorama)"
                    class="flex items-center justify-center px-2 py-1 border border-solid border-[#e3e3e3] rounded cursor-pointer mr-2"
                  >
                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                  </div>
                  <div
                    v-if="index != listImagePanorama.length - 1"
                    @click="handleClickDown(index, listImagePanorama)"
                    class="flex items-center justify-center px-2 py-1 border border-solid border-[#e3e3e3] rounded cursor-pointer"
                  >
                    <i class="fa fa-chevron-down" aria-hidden="true"></i>
                  </div>
                </div>
              </div>

              <div class="w-full">
                <div class="w-full border border-solid border-[#ddd] rounded flex h-8">
                  <div class="flex items-center justify-center border-r border-solid border-[#ddd] w-10 bg-[#eee]">
                    <img :src="JapanIcon" alt="japan" class="w-9 object-cover" />
                  </div>
                  <FormKit
                    type="text"
                    v-model="listImagePanorama[index].title"
                    outer-class="w-full"
                    wrapper-class="h-full"
                    validation="required"
                    :validation-messages="{
                      required: $t('validation.required'),
                    }"
                    message-class="text-[red] mt-2 ml-6"
                    inner-class="h-full"
                    help-class=" mt-1"
                    input-class="px-2 w-full h-full focus:shadow-lg outline-none  focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 "
                  />
                </div>
                <button
                  @click="() => handleDeleteListImagePanorama(index, element.id)"
                  class="py-2 px-3 mt-2 text-[#d43f3a] bg-white border border-solid border-[#d43f3a] rounded hover:bg-[#d43f3a] hover:text-white"
                >
                  {{ $t("spaces_image_page.delete") }}
                </button>
              </div>
            </div>
          </div>
        </template>
      </draggable>
      <input type="file" class="mt-2" multiple accept="image/png, image/jpeg" @change="handleChangeImagePanorama" />
    </LayoutForm>
  </div>
  <ButtonNextStep @onBack="handleBack" @onNext="handleNextPage" />
</template>

<script>
import HeaderSpaces from "@/components/HeaderSpaces";
import ButtonNextStep from "@/components/Buttons/ButtonNextStep";
import { ROUTER_PATH } from "@/const";
import { useRouter, useRoute } from "vue-router";
import LayoutForm from "@/components/Layouts/LayoutForm.vue";
import { useStore } from "vuex";
import { MODULE_STORE, STEP_CREATE_SPACE, IMAGE_TYPE, STEP_SPACE_CREATED } from "@/const";
import JapanIcon from "@/assets/images/japan.png";
import draggable from "vuedraggable";
import { ref, inject, computed } from "vue";
import {
  uploadFiles,
  postSpaceImages,
  getDetailSpaceImages,
  deleteImageSpace,
  getDetailSpaceImagesPanorama,
} from "@/api";
import { useI18n } from "vue-i18n";

export default {
  name: "Recommendation",
  components: { HeaderSpaces, ButtonNextStep, LayoutForm, draggable },
  setup() {
    const router = useRouter();
    const route = useRoute();
    const idSpace = route.params.id || route.query.id;
    const store = useStore();
    const listImages = ref([]);
    const { t } = useI18n();
    const listImagePanorama = ref([]);
    const dragging = ref(false);
    const toast = inject("$toast");
    const isCreated =
      store.getters[`${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.GETTERS.GET_STEP_SPACE_CREATED}`] >
      STEP_CREATE_SPACE.IMAGE;
    const messagesFormError = ref({});
    const uploadImage = async (file) => {
      const formData = new FormData();
      formData.append("file", file);
      formData.append("type", "image");
      try {
        const resFile = await uploadFiles(formData);
        return resFile;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
    };
    const createSpaceImages = async () => {
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;

      const listImagesParams = await Promise.all(
        listImages.value.map(async (item, index) => {
          if (!item.file) {
            const imgData = { ...item, path_file: item.path_image.replace("/storage/", "public/"), title_image: item.title };
            delete imgData.title;
            delete imgData.src_img;
            delete imgData.path_image;
            return imgData;
          }
          const resFile = await uploadImage(item.file);
          URL.revokeObjectURL(item.src_img);
          return {
            path_file: resFile.path_file,
            title_image: item.title,
            type: IMAGE_TYPE.NORMAL,
            width: resFile.width,
            height: resFile.height,
            length: resFile.length,
            extension: resFile.extension,
            order_number: index,
          };
        })
      );
      const listImagePanoramaParams = await Promise.all(
        listImagePanorama.value.map(async (item, index) => {
          if (!item.file) {
            const imgData = { ...item, path_file: item.path_image.replace("/storage/", "public/"), title_image: item.title };
            delete imgData.title;
            delete imgData.src_img;
            delete imgData.path_image;
            return imgData;
          }
          const resFile = await uploadImage(item.file);
          URL.revokeObjectURL(item.src_img);
          return {
            path_file: resFile.path_file,
            title_image: item.title,
            type: IMAGE_TYPE.PANORAMA,
            width: resFile.width,
            height: resFile.height,
            length: resFile.length,
            extension: resFile.extension,
            order_number: index,
          };
        })
      );
      const params = {
        information_images: [...listImagesParams, ...listImagePanoramaParams].filter((img) => img),
      };
      try {
        await postSpaceImages(params, idSpace);
      } catch (error) {
        if (error?.data) {
          messagesFormError.value = {};
          error?.data.forEach((item) => {
            messagesFormError.value[item.key] = item.messages[0];
          });
        } else {
          error.message ? toast.error(error.message) : toast.error("エラー情報を入力してください");
        }
        throw error;
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };

    const handleNextPage = async () => {
      if (!listImagePanorama.value.length && !listImages.value.length) {
        toast.error("1枚以上の画像を登録して下さい");
      }
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await createSpaceImages();
        if (!isCreated) {
          store.commit(
            `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_STEP_SPACE_CREATED}`,
            STEP_SPACE_CREATED["equipment-information"]
          );
        }
        router.push(`${ROUTER_PATH.SPACE.EQUIPMENT_INFORMATION}?id=${idSpace}`);
      } catch (error) {
        if (error?.data) {
          messagesFormError.value = {};
          error?.data.forEach((item) => {
            messagesFormError.value[item.key] = item.messages[0];
          });
        } else {
          error.message ? toast.error(error.message) : toast.error("エラー情報を入力してください");
        }
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };

    const handleBack = () => {
      router.push(`${ROUTER_PATH.SPACE.GENERAL}?id=${idSpace}`);
    };

    const handleChangeListImage = (e) => {
      Array.from(e.target.files).forEach((item) => {
        listImages.value.push({
          src_img: URL.createObjectURL(item),
          file: item,
          title: "",
        });
      });
    };

    const handleChangeImagePanorama = (e) => {
      Array.from(e.target.files).forEach((item) => {
        listImagePanorama.value.push({
          src_img: URL.createObjectURL(item),
          title: "",
          file: item,
        });
      });
    };
    const handleDeleteListImages = async (index, id) => {
      if (id) {
        await deleteImageSpace(id, "images");
      }
      listImages.value.splice(index, 1);
    };
    const handleDeleteListImagePanorama = async (index, id) => {
      if (id) {
        await deleteImageSpace(id, "panorama-images");
      }
      listImagePanorama.value.splice(index, 1);
    };
    const initData = async () => {
      if (isCreated) {
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          const res = await getDetailSpaceImages(idSpace);
          listImages.value = res.data.imageFiles
            .filter((item) => item.type == IMAGE_TYPE.NORMAL)
            .map((item) => {
              return {
                title: item.title,
                src_img: `${window.location.origin}/${item.path_image}`,
                ...item,
              };
            });
          const resPanorama = await getDetailSpaceImagesPanorama(idSpace);

          listImagePanorama.value = resPanorama.data.imageFiles
            .filter((item) => item.type == IMAGE_TYPE.PANORAMA)
            .map((item) => {
              return {
                title: item.title,
                src_img: `${window.location.origin}/${item.path_image}`,
                ...item,
              };
            });
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
      }
      store.dispatch(
        `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE}`,
        STEP_CREATE_SPACE.IMAGE
      );
    };
    function handleClickUp(index, nameList) {
      if (index) {
        const temp = JSON.parse(JSON.stringify(nameList[index]));
        nameList[index] = JSON.parse(JSON.stringify(nameList[index - 1]));
        nameList[index - 1] = JSON.parse(JSON.stringify(temp));
      }
    }
    function handleClickDown(index, nameList) {
      if (index < nameList.length - 1) {
        const temp = JSON.parse(JSON.stringify(nameList[index]));
        nameList[index] = JSON.parse(JSON.stringify(nameList[index + 1]));
        nameList[index + 1] = JSON.parse(JSON.stringify(temp));
      }
    }

    initData();
    return {
      handleDeleteListImages,
      handleDeleteListImagePanorama,
      handleNextPage,
      handleBack,
      handleChangeListImage,
      handleChangeImagePanorama,
      JapanIcon,
      listImages,
      listImagePanorama,
      dragging,
      messagesFormError,
      handleClickUp,
      handleClickDown,
    };
  },
};
</script>

<style scoped></style>
