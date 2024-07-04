<template>
  <div>
    <ul class="flex justify-content-start align-items-center border-b border-solid border-[#ddd] pt-2.5 pl-2.5 mb-5">
      <li
        class="sidebar__item"
        :class="[currentStep == sidebar.id ? 'active' : '']"
        v-for="(sidebar, index) in sideBarSteps"
        :key="index"
      >
        <div
          :class="[currentStep == sidebar.id ? classActive : '']"
          class="block py-2.5 px-4 cursor-pointer bg-white"
          :href="`${sidebar.url}`"
        >
          <i :class="sidebar.icon"></i>
          <span>{{ sidebar.title }} </span>
        </div>
      </li>
    </ul>

    <teleport to="body">
      <modal v-if="isShowModal" @closeModal="handleModalDelete">
        <template v-slot:title>
          <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-100">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray break-all">
              {{ $t("static_Page_View.modal_title") }}
            </h3>
          </div>
        </template>
        <template v-slot:content>
          <div class="p-6 space-y-6">
            <p class="text-base leading-relaxed break-all">
              {{ $t("static_Page_View.modal_content") }}
            </p>
          </div>
        </template>
        <template v-slot:foot>
          <div class="flex justify-end gap-4 p-6 space-x-2 rounded-b break-all">
            <button
              @click="handleModalDelete"
              class="text-[blue] bg-white border border-gray-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 break-all"
            >
              {{ $t("static_Page_View.cancel") }}
            </button>
            <button
              @click="handleDelItem"
              class="text-white bg-blue-600 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 break-all"
            >
              {{ $t("static_Page_View.ok") }}
            </button>
          </div>
        </template>
      </modal>
    </teleport>
    <div v-if="isShowConfirm" class="p-[15px] mb-[20px] border-1 border-[#d6e9c6] bg-[#dff0d8]">
      <i class="fa fa-check text-[#3c763d]"></i>
      <span class="text-[#3c763d] ml-1"> {{ $t("static_Page_View.show_confirm") }}</span>
    </div>
    <ErrorMessage class="text-[red]" name="title" />
    <form @submit="handleClickCreateAdd">
      <div class="w-full h-full mt-[12px]">
        <div class="flex">
          <label for="key" class="w-[20%] mb-[5px] font-bold">{{ $t("static_Page.key") }}</label>
          <div class="w-full mb-[5px]">
            <Field
              id="key"
              name="key"
              class="w-[50%] border border-gray-300 outline-none px-[12px] py-3 rounded"
              type="text"
              v-model="newDetail.key"
              disabled
            />
            <div>
              <ErrorMessage class="text-[red]" name="key" />
            </div>
          </div>
        </div>

        <div class="flex">
          <label for="title" class="w-[20%] mb-[5px] font-bold">{{ $t("static_Page.label") }}</label>
          <div class="w-full h-full flex mb-[5px]">
            <div class="h-auto py-[6px] px-[12px] bg-gray-300 border-r-0 border-gray-200">
              <img :src="JapanIcon" class="w-6 h-6" alt="image" />
            </div>
            <Field
              id="title"
              name="title"
              class="w-[100%] border border-gray-300 outline-none px-[12px] py-3 rounded"
              type="text"
              v-model="newDetail.title"
            />
          </div>
        </div>

        <div class="flex">
          <div class="w-[20%] mb-[5px] font-bold">{{ $t("static_Page.content") }}</div>
          <div class="w-full h-full flex">
            <div class="h-auto py-[6px] px-[12px] bg-gray-300 border-r-0 border-gray-200">
              <img :src="JapanIcon" class="w-6 h-6" alt="image" />
            </div>
            <div class="w-full h-full">
              <ckeditor :editor="editor" v-model="editorData" tag-name="textarea" rows="5"></ckeditor>
            </div>
          </div>
        </div>
      </div>
      <div class="w-full h-full flex justify-center mt-[6px] gap-[50px]">
        <button
          class="block w-fit p-[8px] bg-[#ffbd00] text-white mr-3 rounded cursor-pointer hover:translate-y-1 transition-all"
          @click="handleSubmit"
        >
          {{ $t("static_Page_View.text_add") }}
        </button>
        <button
          v-if="id"
          class="block w-fit px-[12px] py-[6px] bg-[#fff] text-[#d43f3a] border border-[#d43f3a] mr-3 rounded cursor-pointer hover:bg-[#d43f3a] hover:text-[#fff]"
          @click="handleClickDelete"
        >
          {{ $t("static_Page_View.text_delete") }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import * as Yup from "yup";
import { ref, inject } from "vue";
import { useI18n } from "vue-i18n";
import { useRouter, useRoute } from "vue-router";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import JapanIcon from "@/assets/images/japan.png";
import { Field, useForm, ErrorMessage } from "vee-validate";
import { ROUTER_PATH, MODULE_STORE } from "@/const";
import Modal from "@/views/ReservationsCalendar/child/Modal.vue";
import { addPageNewApi, deletePageNewApi, updatePageNew, getDetailPageNewApi } from "@/api";
import { useStore } from "vuex";
export default {
  name: "StaticPageView",
  components: { Field, ErrorMessage, Modal },
  setup(props, context) {
    const { t } = useI18n();
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    const toast = inject("$toast");
    const editorData = ref();
    const newDetail = ref({});
    const isShowModal = ref(false);
    const isShowConfirm = ref(false);
    const id = route.query.id;
    const editor = ClassicEditor;
    const classActive = "rounded-t border border-solid border-[#ddd] text-[#555] border-b-[transparent]";
    const sideBarSteps = [
      {
        id: 1,
        title: t("static_Page_View.title"),
        icon: "fa fa-info mr-2",
      },
    ];
    const { handleSubmit, errors } = useForm({
      initialValues: {
        key: "",
        title: "",
      },
      validationSchema: Yup.object().shape({
        key: Yup.string().required(t(`static_Page_View.validation_key`)),
        title: Yup.string().required(t(`static_Page_View.validation_content`)),
      }),
    });
    const handleClickCreateAdd = handleSubmit(async (val) => {
      if (id) {
        updateItemNew(val);
      } else {
        addPageNew(val);
        isShowConfirm.value = true;
      }
    });
    const addPageNew = async (val) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await addPageNewApi({
          attribute: {
            key: val.key,
            title: val.title,
            content: editorData.value,
          },
        });
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const deleteItemNew = async (e) => {
      e.preventDefault();
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await deletePageNewApi(id);
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const updateItemNew = async (val) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await updatePageNew(id, {
          attribute: {
            key: val.key,
            title: val.title,
            content: editorData.value,
          },
        });
        isShowConfirm.value = true;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const getDetailPageNew = async () => {
      if (id) {
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          newDetail.value = await getDetailPageNewApi(id);
          editorData.value = newDetail.value.content;
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
      }
    };
    getDetailPageNew();
    const handleClickDelete = () => {
      isShowModal.value = true;
    };
    const handleModalDelete = () => {
      isShowModal.value = false;
    };
    const handleDelItem = (e) => {
      deleteItemNew(e);
      router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.STATIC_PAGE}`);
    };
    return {
      sideBarSteps,
      classActive,
      JapanIcon,
      handleClickCreateAdd,
      handleSubmit,
      errors,
      isShowModal,
      isShowConfirm,
      handleClickDelete,
      handleModalDelete,
      editor,
      editorData,
      addPageNew,
      deleteItemNew,
      updateItemNew,
      newDetail,
      id,
      handleDelItem,
    };
  },
};
</script>

<style></style>
