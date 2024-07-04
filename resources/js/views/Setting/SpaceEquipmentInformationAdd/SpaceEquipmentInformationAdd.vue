<template>
  <div v-if="isSuccess" class="bg-[#dff0d8] border border-solid border-[#d6e9c6] px-[10px] py-[12px] my-3">
    <i class="fa fa-check text-[#3c763d] mr-[5px]"></i>
    <span class="text-[12px] text-[#3c763d]">{{ $t("form_setting_news.success") }}</span>
  </div>
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
  <div>
    <div class="flex flex-wrap mx-auto">
      <div>
        <button
          @click="() => activeNav(item.id)"
          v-for="item in listMenuEdit"
          :key="item.id"
          class="cursor-pointer p-2 min-w-[75px] border-b border-solid border-[#ddd] hover:bg-[#eee] transition-all duration-200"
          :class="[itemClick === item.id ? 'border-b-[4px] border-[#75c8be] ' : '']"
        >
          <i :class="item.icon" class="mr-1"></i>
          <span>{{ item.name }}</span>
        </button>
      </div>
    </div>
  </div>
  <div v-if="isShowContent">
    <form>
      <ErrorMessage class="text-[red] font-bold" name="titleJap" />
      <LayoutInput :isRequired="true" :labelText="$t('space_equip_inform_add.type')">
        <div class="flex items-center justify-start break-words">
          <div v-for="idItem in typeList" :key="idItem.id">
            <label :for="idItem.type" class="flex items-center mr-[20px] cursor-pointer">
              <Field
                :id="idItem.type"
                type="radio"
                name="active"
                :value="idItem.id"
                v-model="newDetail.active"
                class="translate-y-[-1px] mr-[4px]"
              />
              {{ idItem.type }}
            </label>
          </div>
        </div>
      </LayoutInput>
      <LayoutInput :iconPrev="`fa fa-tag`" :labelText="$t('space_equip_inform_add.type_id')">
        <div>{{ convertIdTitle(idTitle) }}</div>
      </LayoutInput>
      <LayoutInput :iconPrev="`flag en mr-1`" :labelText="$t('space_equip_inform_add.title')">
        <Field
          type="text"
          name="titleUs"
          v-model="newDetail.title_en"
          class="px-2 w-full h-9 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd]"
        />
      </LayoutInput>
      <LayoutInput :iconPrev="`flag ja mr-1 `" :labelText="$t('space_equip_inform_add.title')">
        <Field
          type="text"
          name="titleJap"
          v-model="newDetail.title_jp"
          class="px-2 w-full h-9 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd]"
        />
      </LayoutInput>
      <LayoutInput :isRequired="true" :labelText="$t('space_equip_inform_add.string_id')">
        <Field
          type="text"
          name="string_id"
          v-model="newDetail.string_id"
          class="px-2 w-full h-9 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd]"
        />
        <div class="text-[#737373] my-1">{{ $t("space_equip_inform_add.sub_string_id") }}</div>
        <ErrorMessage class="text-[red] font-bold" name="string_id" />
      </LayoutInput>
      <LayoutInput :isRequired="true" :labelText="$t('space_equip_inform_add.type_import')">
        <Field
          v-model="newDetail.checkbox_label_type"
          name="type_import"
          as="select"
          class="bg-[#fff] px-2 w-full h-9 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shad ow-inner rounded border border-solid border-[#ddd]"
        >
          <option v-for="idItem in typeImport" :key="idItem.id" :value="idItem.id">
            {{ idItem.type }}
          </option>
        </Field>
        <div class="text-[#737373] my-1">{{ $t("space_equip_inform_add.type_import") }}</div>
        <ErrorMessage class="text-[red] font-bold" name="type_import" />
      </LayoutInput>
      <LayoutInput :labelText="$t('space_equip_inform_add.type_sign')">
        <div class="flex items-center justify-start break-words">
          <div v-for="idItem in typeSign" :key="idItem.id">
            <label :for="idItem.typeSign" class="flex items-center mr-[20px] cursor-pointer">
              <Field
                :id="idItem.typeSign"
                type="radio"
                name="typeSign"
                :value="idItem.id"
                v-model="newDetail.checkbox_type"
                class="translate-y-[-1px] mr-[4px]"
              />
              {{ idItem.type }}
            </label>
          </div>
        </div>
        <div class="text-[#737373] my-1">{{ $t("space_equip_inform_add.sub_type_import") }}</div>
      </LayoutInput>

      <LayoutInput :labelText="$t('space_equip_inform_add.number_import')">
        <div class="flex items-center justify-start break-words">
          <div v-for="idItem in numberImport" :key="idItem.id">
            <label :for="idItem.numberImport" class="flex items-center mr-[20px] cursor-pointer">
              <Field
                :id="idItem.numberImport"
                type="radio"
                name="numberImport"
                :value="idItem.id"
                v-model="newDetail.input_box"
                class="translate-y-[-1px] mr-[4px]"
              />
              {{ idItem.type }}
            </label>
          </div>
        </div>
        <div class="text-[#737373] my-1">{{ $t("space_equip_inform_add.sub_number_import") }}</div>
      </LayoutInput>

      <LayoutInput :labelText="$t('space_equip_inform_add.option')">
        <div class="flex items-center justify-start break-words">
          <div v-for="idItem in option" :key="idItem.id">
            <label :for="idItem.option" class="flex items-center mr-[20px] cursor-pointer">
              <Field
                :id="idItem.option"
                type="radio"
                name="option"
                :value="idItem.id"
                v-model="newDetail.required"
                class="translate-y-[-1px] mr-[4px]"
              />
              {{ idItem.type }}
            </label>
          </div>
        </div>
      </LayoutInput>

      <LayoutInput :labelText="$t('space_equip_inform_add.condition')">
        <div class="flex items-center justify-start break-words">
          <div v-for="idItem in condition" :key="idItem.id">
            <label :for="idItem.condition" class="flex items-center mr-[20px] cursor-pointer">
              <Field
                :id="idItem.condition"
                type="radio"
                name="condition"
                :value="idItem.id"
                v-model="newDetail.frequently_used"
                class="translate-y-[-1px] mr-[4px]"
              />
              {{ idItem.type }}
            </label>
          </div>
        </div>
      </LayoutInput>
      <LayoutInput>
        <div class="flex gap-4">
          <button
            class="block w-fit p-[8px] bg-[#ffbd00] text-white mr-3 rounded cursor-pointer hover:translate-y-1 transition-all"
            @click="submitForm"
          >
            {{ $t("space_equip_inform_add.btn") }}
          </button>
          <button
            v-if="isShowModalDelete"
            class="block w-fit p-[8px] bg-[#a94442] text-white mr-3 rounded cursor-pointer hover:translate-y-1 transition-all"
            @click="handleShowRequire"
          >
            {{ $t("space_equip_inform_add.btn_del") }}
          </button>
        </div>
      </LayoutInput>
    </form>
  </div>
  <div v-else class="my-2">
    <div v-if="isShowModalDelete">
      <LayoutInput :iconPrev="`fa fa-upload mr-1`" :labelText="$t('space_equip_inform_add.upload')">
        <input type="file" accept="image/png, image/jpeg" @change="handleCreateImageEquipment" />
      </LayoutInput>
      <LayoutInput :iconPrev="`fa fa fa-picture-o mr-1`" :labelText="$t('space_equip_inform_add.image_upload')">
        <div class="flex justify-start" v-if="urlImage">
          <div class="w-[40px]">
            <img :src="urlImage" alt="image" class="w-full h-full object-contain" />
          </div>
          <div class="m-2">
            <button
              class="py-2 px-3 text-white rounded bg-[#d9534f] hover:bg-[#c9302c]"
              @click="handleDeleteImageEquipment"
            >
              {{ $t("common.delete") }}
            </button>
          </div>
        </div>
      </LayoutInput>
    </div>
    <div v-else>
      {{ $t("space_equip_inform_add.note_image") }}
    </div>
  </div>
</template>

<script>
import * as Yup from "yup";
import { ref, inject } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import { MODULE_STORE, ROUTER_PATH } from "@/const";
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import Modal from "@/views/ReservationsCalendar/child/Modal.vue";
import { Field, useForm, ErrorMessage } from "vee-validate";
import {
  createEquipmentInformationApi,
  deleteEquipmentInformationApi,
  uploadImageEquipment,
  deleteImageEquipmentSetting,
  getDetailEquipmentInformationApi,
} from "@/api";
export default {
  name: "SpaceEquipmentInformationAdd",
  components: { LayoutInput, Field, ErrorMessage, Modal },
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    const toast = inject("$toast");
    const isSuccess = ref(false);
    const isShowBtnDel = ref(false);
    const isShowModalDelete = ref(false);
    const isShowModal = ref(false);
    const newId = ref();
    const urlImage = ref(null);
    const newDetail = ref({
      typeImport: t("space_equip_inform_add.type_import_title"),
      active: 2,
      required: 1,
      frequently_used: 1,
    });
    const idTitle = ref(route.query.id);
    const convertIdTitle = (value) => {
      if (value == "basic") {
        return value ? t("space_equip_inform.information") : "";
      }
      if (value == "general") {
        return value ? t("space_equip_inform.equipment") : "";
      }
      if (value == "conference") {
        return value ? t("space_equip_inform.equipment_broad") : "";
      }
      if (value == "photography") {
        return value ? t("space_equip_inform.equipment_make_video") : "";
      }
      if (value == "events") {
        return value ? t("space_equip_inform.event_equipment") : "";
      }
      if (value == "party") {
        return value ? t("space_equip_inform.party_equipment") : "";
      }
      if (value == "share") {
        return value ? t("space_equip_inform.repos") : "";
      }
      if (value == "radio-options") {
        return value ? t("space_equip_inform.radio_option") : "";
      }
    };
    const itemClick = ref(1);
    const dataTable = ref([]);
    const typeList = [
      {
        id: 1,
        type: t("space_equip_inform_add.individual"),
      },
      {
        id: 2,
        type: t("space_equip_inform_add.general"),
      },
    ];
    const option = [
      {
        id: 1,
        type: t("space_equip_inform_add.no"),
      },
      {
        id: 2,
        type: t("space_equip_inform_add.yes"),
      },
    ];
    const condition = [
      {
        id: 1,
        type: t("space_equip_inform_add.no_condition"),
      },
      {
        id: 2,
        type: t("space_equip_inform_add.yes_condition"),
      },
    ];
    const typeSign = [
      {
        id: 1,
        type: t("space_equip_inform_add.individual"),
      },
      {
        id: 2,
        type: t("space_equip_inform_add.general"),
      },
    ];
    const typeImport = [
      {
        type: t("space_equip_inform_add.type_import_title"),
      },
      {
        id: 1,
        type: t("space_equip_inform_add.checkbox"),
      },
      {
        id: 2,
        type: t("space_equip_inform_add.radio"),
      },
      {
        id: 3,
        type: t("space_equip_inform_add.input"),
      },
      {
        id: 4,
        type: t("space_equip_inform_add.textarea"),
      },
    ];
    const numberImport = [
      {
        id: 1,
        type: t("space_equip_inform_add.nobody"),
      },
      {
        id: 2,
        type: t("space_equip_inform_add.minutes"),
      },
      {
        id: 3,
        type: t("space_equip_inform_add.footer"),
      },
      {
        id: 4,
        type: t("space_equip_inform_add.chain"),
      },
      {
        id: 5,
        type: t("space_equip_inform_add.town"),
      },
    ];
    const listMenuEdit = ref([
      {
        id: 1,
        icon: "fa fa-info-circle",
        name: t("space_equip_inform_add.content"),
      },
      {
        id: 2,
        icon: "fa fa fa-picture-o",
        name: t("space_equip_inform_add.image"),
      },
    ]);
    const isShowContent = ref(true);
    const activeNav = (id) => {
      itemClick.value = id;
      if (id == 1) {
        isShowContent.value = true;
      } else {
        isShowContent.value = false;
      }
    };
    const { handleSubmit, errors } = useForm({
      initialValues: {},
      validationSchema: Yup.object().shape({
        type_import: Yup.string().required(t("space_tour.message_date_time")),
        string_id: Yup.string().required(t("space_tour.message_date_time")).trim("cant not empty"),
      }),
    });
    const submitForm = handleSubmit(async (val) => {
      createEquipmentInformation(val);
      isShowModalDelete.value = true;
    });
    const createEquipmentInformation = async (val) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        let res = await createEquipmentInformationApi(idTitle.value, {
          active: val.active,
          required: val.option,
          checkbox_label_type: val.type_import,
          string_id: val.string_id,
          frequently_used: val.condition,
          attribute: {
            title_jp: val.titleJap,
            title_en: val.titleUs,
            checkbox_type: val.typeSign,
            input_box: val.numberImport,
          },
        });
        newId.value = res.id;
        isSuccess.value = true;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const deleteItemNew = async (event) => {
      event.preventDefault();
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await deleteEquipmentInformationApi(newId.value);
        isSuccess.value = true;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const handleShowRequire = (event) => {
      event.preventDefault();
      isShowModal.value = true;
    };
    const handleModalDelete = () => {
      isShowModal.value = false;
    };
    const handleDelItem = (event) => {
      isShowModal.value = false;
      deleteItemNew(event);
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.RENTAL_SPACE_EQUIPMENT_INFORMATION}`
      );
    };
    const handleCreateImageEquipment = async (event) => {
      const file = event.target.files[0];
      urlImage.value = URL.createObjectURL(file);
      const formData = new FormData();
      formData.append("file", file);
      formData.append("type", "equipment_img");
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await uploadImageEquipment(newId.value, formData);
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    const handleDeleteImageEquipment = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await deleteImageEquipmentSetting(newId.value);
        urlImage.value = null;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    return {
      handleShowRequire,
      handleDeleteImageEquipment,
      handleCreateImageEquipment,
      urlImage,
      errors,
      option,
      condition,
      listMenuEdit,
      typeList,
      newDetail,
      idTitle,
      typeSign,
      numberImport,
      submitForm,
      itemClick,
      activeNav,
      isShowContent,
      typeImport,
      isSuccess,
      createEquipmentInformation,
      isShowBtnDel,
      dataTable,
      isShowModalDelete,
      isShowModal,
      handleModalDelete,
      handleDelItem,
      newId,
      convertIdTitle,
    };
  },
};
</script>

<style scoped></style>
