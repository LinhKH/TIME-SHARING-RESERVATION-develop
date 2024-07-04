<template>
  <div class="mt-2">
    {{ $t("spaces_image_page.text_help_2") }}
  </div>
  <div class="mt-2">
    {{ $t("spaces_image_page.text_help_3") }}
  </div>
  <div class="mt-2">
    {{ $t("spaces_image_page.text_help_4") }}
  </div>
  <div class="mt-2">{{ $t("spaces_image_page.text_help_5", { total: listImagesInstance.length }) }}</div>

  <draggable
    v-model="listImagesInstance"
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
              <img :src="element.path_image" class="w-full h-full object-cover" alt="image" />
            </div>
            <div class="flex">
              <div
                v-if="index"
                @click="handleClickUp(index, listImagesInstance)"
                class="flex items-center justify-center px-2 py-1 border border-solid border-[#e3e3e3] rounded cursor-pointer mr-2"
              >
                <i class="fa fa-chevron-up" aria-hidden="true"></i>
              </div>
              <div
                v-if="index != listImagesInstance.length - 1"
                @click="handleClickDown(index, listImagesInstance)"
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
              <input
                type="text"
                class="w-full px-2 h-full outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50"
                v-model="listImagesInstance[index].title"
                @blur="() => handleUpdateImage(element)"
              />
            </div>

            <button
              class="py-2 px-3 mt-2 text-[#d43f3a] bg-white border border-solid border-[#d43f3a] rounded hover:bg-[#d43f3a] hover:text-white"
              @click="() => handleDeleteImage(element, index)"
            >
              {{ $t("spaces_image_page.delete") }}
            </button>
          </div>
        </div>
      </div>
    </template>
  </draggable>
  <input type="file" class="mt-1" multiple accept="image/png, image/jpeg" @change="handleChangeImages" />
  <button
    v-if="listImagesInstance.length"
    @click="handleSubmit"
    class="block mx-auto p-2 rounded mt-2 bg-[#FFBD00] text-white"
  >
    {{ $t("common.keep") }}
  </button>
</template>

<script>
import JapanIcon from "@/assets/images/japan.png";
import draggable from "vuedraggable";
import { uploadFiles, postSpaceImages, updateSpaceImage, deleteImageSpace } from "@/api";
import { ref, inject, watch } from "vue";
import ButtonAdd from "@/components/Buttons/ButtonAddNew";
import { useI18n } from "vue-i18n";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
import { MODULE_STORE } from "@/const";

export default {
  name: "PreviewImage",
  props: {
    listImages: Object,
    typeImage: { type: String, required: true },
    typeDelete: { type: String, required: true },
  },
  emits: ["updateList"],
  components: { draggable, ButtonAdd },
  setup(props, context) {
    const listImagesInstance = ref([]);
    watch(
      () => props.listImages,
      () => {
        listImagesInstance.value = [...props.listImages];
      }
    );
    const toast = inject("$toast");
    const { t } = useI18n();
    const route = useRoute();
    const idSpace = route.params.id || route.query.id;
    const store = useStore();
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
    const handleChangeImages = async (event) => {
      Array.from(event.target.files).forEach((item) => {
        listImagesInstance.value.push({
          path_image: URL.createObjectURL(item),
          file: item,
          title: "",
        });
      });
    };
    const handleUpdateImage = async (payload) => {
      if (payload.file || !payload.title) {
        return;
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
      try {
        const params = {
          image_id: payload.id,
          image_type: props.typeImage,
          title: payload.title,
        };
        await updateSpaceImage(idSpace, params);
        toast.success("Update successful!");
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    const handleSubmit = async () => {
      await Promise.all(
        listImagesInstance.value.map(async (item, index) => {
          if (!item.file) {
            const imgData = {
              ...item,
              path_file: item.path_image.replace("/storage/", "public/"),
              title_image: item.title,
            };
            delete imgData.title;
            delete imgData.path_image;
            return imgData;
          }
          const resFile = await uploadImage(item.file);
          URL.revokeObjectURL(item.src_img);
          return {
            path_file: resFile.path_file,
            title_image: item.title,
            type: props.typeImage,
            width: resFile.width,
            height: resFile.height,
            length: resFile.length,
            extension: resFile.extension,
            order_number: index,
          };
        })
      ).then(async (listImagesInstanceParams) => {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        if (listImagesInstanceParams.length) {
          try {
            await postSpaceImages({ information_images: listImagesInstanceParams }, idSpace);
            context.emit("updateList");
          } catch (errors) {
            const error = errors.message || t("common.has_error");
            toast.error(error);
          }
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        }
      });
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    const handleDeleteImage = async (image, index) => {
      try {
        if (!!image.id) {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;

          await deleteImageSpace(image.id, props.typeDelete);
        } else {
          listImagesInstance.value.splice(index, 1);
        }
        toast.success(t("toast_message.delete_success"));
        context.emit("updateList");
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
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
    return {
      JapanIcon,
      handleChangeImages,
      listImagesInstance,
      handleSubmit,
      handleUpdateImage,
      handleDeleteImage,
      handleClickUp,
      handleClickDown,
    };
  },
};
</script>

<style scoped></style>
