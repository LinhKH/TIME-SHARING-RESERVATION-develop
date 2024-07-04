<template>
  <Form v-slot="{ handleSubmit }" class="mt-[15px]" :initial-values="formValues">
    <div v-for="(newEditItem, index) in listForm" :key="index" class="flex items-start justify-start mb-[8px]">
      <div class="flex items-center justify-start w-[17%]">
        <i class="font-bold mr-[2px]" :class="newEditItem.icon"></i>
        <span class="font-bold translate-y-px">{{ newEditItem.title }}</span>
      </div>
      <div class="w-[100%]">
        <div v-if="newEditItem.type === 'Radio'" class="flex items-center justify-start">
          <label
            class="flex items-center justify-start mr-[20px] cursor-pointer"
            v-for="(optionActive, indexActive) in optionPublicAndPrivate"
            :key="indexActive"
          >
            <input
              type="radio"
              v-model="formData[newEditItem.name]"
              :value="optionActive.value"
              class="translate-y-[-1px] mr-[4px]"
            />
            {{ optionActive.label }}
          </label>
        </div>

        <div v-if="newEditItem.type === 'title'">
          <span class="text-[12px]">{{ categoryName }}</span>
        </div>

        <div v-if="newEditItem.type === 'text'" class="flex items-start justify-start flex-col">
          <div class="w-full border border-solid border-[#ddd] rounded flex h-8 mb-[4px]">
            <Flag :flag="`en`" class="w-[35px] bg-[#eee]" />
            <Field type="text" name="title_en" class="outline-none p-[5px] rounded-r w-full" />
          </div>
          <MessageErrors v-if="errors.title_en" :messages="errors.title_en" class="mt-1" />
          <div class="w-full border border-solid border-[#ddd] rounded flex h-8 mb-[4px]">
            <Flag :flag="`ja`" class="w-[35px] bg-[#eee]" />
            <Field type="text" name="title_ja" class="outline-none p-[5px] rounded-r w-full" />
          </div>
          <MessageErrors v-if="errors.title_ja" :messages="errors.title_ja" class="mt-1" />
          <div class="w-full border border-solid border-[#ddd] rounded flex h-8">
            <Flag :flag="`ja`" class="w-[35px] bg-[#eee]" />
            <Field type="text" name="title_jp" class="outline-none p-[5px] rounded-r w-full" />
          </div>
          <MessageErrors v-if="errors.title_jp" :messages="errors.title_jp" class="mt-2" />
        </div>

        <div v-if="newEditItem.type === 'supanavi'" class="flex items-start justify-start flex-col">
          <div class="w-full border border-solid border-[#ddd] rounded flex h-8">
            <Field type="text" :name="newEditItem.name" class="outline-none p-[5px] rounded w-full px-[10px]" />
          </div>
          <span v-if="newEditItem.subTitle" class="text-[11px] text-[#737373] mt-[6px]">
            {{ newEditItem.subTitle }}
          </span>
        </div>
        <div v-if="newEditItem.type === 'color'" class="flex items-start justify-start flex-col">
          <div class="w-full border border-solid border-[#ddd] rounded flex h-8">
            <Field type="color" :name="newEditItem.name" class="outline-none p-[5px] rounded w-full px-[10px]" />
          </div>
          <span v-if="newEditItem.subTitle" class="text-[11px] text-[#737373] mt-[6px]">
            {{ newEditItem.subTitle }}
          </span>
        </div>

        <div v-if="newEditItem.type === 'note'" class="flex items-start justify-start flex-col">
          <div class="w-full border border-solid border-[#ddd] rounded flex h-8 mb-[4px]">
            <Flag :flag="`en`" class="w-[35px] bg-[#eee]" />
            <Field type="text" name="note_en" class="outline-none p-[5px] rounded-r w-full" />
          </div>
          <div class="w-full border border-solid border-[#ddd] rounded flex h-8">
            <Flag :flag="`ja`" class="w-[35px] bg-[#eee]" />
            <Field type="text" name="note_jp" class="outline-none p-[5px] rounded-r w-full" />
          </div>
        </div>

        <div v-if="newEditItem.type === 'select'" class="flex items-start justify-start flex-col relative">
          <SelectPurposeUseVue
            :formData="formData[newEditItem.name]"
            :optionEquipment="optionEquipment"
            @updateModelValue="(value) => (formData[newEditItem.name] = value)"
          />
        </div>
      </div>
    </div>
    <div class="text-center mb-[8px]">
      <button
        @click="handleSubmit($event, onSubmit)"
        class="group bg-[#fff] hover:bg-[#ffbd00] border border-solid border-[#ffbd00] px-[12px] py-[6px] rounded shadow-[0_1px_1px_0_#a4966e] translate-y-0 hover:translate-y-1 transition-all"
      >
        <span class="text-[14px] text-[#ffbd00] group-hover:text-[#fff]"> {{ $t("form_setting_news.keep") }}</span>
      </button>
    </div>
  </Form>
</template>

<script>
import SelectPurposeUseVue from "./SelectPurposeUse.vue";
import { optionPublicAndPrivate } from "@/const/options";
import Image from "./Image.vue";
import { useI18n } from "vue-i18n";
import { watch, ref, reactive, computed, inject } from "vue";
import { Field, Form } from "vee-validate";
import { isEmpty } from "lodash";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
import { MODULE_STORE, CATEGORY__PRIORITIZED_PRIORITIZED, ACTIONS_TYPE } from "@/const";
import { createPurposeUse, getListEquipment, getDetailPurposeOfUse, updatePurposeOfUse } from "@/api";
import { handleBack, isRequired } from "@/utils";
import Flag from "@/components/Atoms/Flag.vue";
import MessageErrors from "@/components/Atoms/MessageErrors.vue";

export default {
  name: "Info",
  components: {
    Field,
    SelectPurposeUseVue,
    Image,
    Form,
    Flag,
    MessageErrors,
  },
  props: {
    actionType: { type: String },
  },
  setup(props) {
    const { t } = useI18n();
    const textColor = ref("#000");
    const route = useRoute();
    const store = useStore();
    const categoryId = ref();
    const toast = inject("$toast");
    const isUsePurposeCategory = ref(false);
    const optionEquipment = ref(null);
    const idPurposeOfUse = route.query.idPurposeOfUse;
    const listCategories =
      store.getters[`${MODULE_STORE.SETTING.NAME}/${MODULE_STORE.SETTING.GETTERS.GET_LIST_CATEGORY_PURPOSE_OF_USE}`];
    const categoryName = ref();
    const formData = reactive({
      active: optionPublicAndPrivate[0].value,
      equipment_information_icons_ids: [],
      equipment_information_ids: [],
      equipment_information_ids_mobile: [],
    });
    const formValues = reactive({
      title_en: "",
      title_ja: "",
      title_jp: "",
      supanavi_id: "",
      seo_text: "",
      note_en: "",
      note_jp: "",
      color: "",
    });
    const errors = reactive({
      title_en: "",
      title_ja: "",
      title_jp: "",
    });
    const convertNameCategory = (idCategory) => {
      if (!idCategory) return;
      const category = listCategories.find((item) => item.id == idCategory);
      if (category) return category.label;
    };
    watch(
      () => route.query.categoryId,
      (idCategory) => {
        categoryId.value = idCategory;
        if (idCategory == CATEGORY__PRIORITIZED_PRIORITIZED) {
          isUsePurposeCategory.value = true;
        } else {
          isUsePurposeCategory.value = false;
        }
        categoryName.value = convertNameCategory(idCategory);
      },
      { immediate: true }
    );

    const newEdit = [
      {
        id: 1,
        type: "Radio",
        name: "active",
        icon: "",
        title: t("purpose_of_use.public_private"),
        inputRadio1: "非公開",
        inputRadio2: "公開",
      },
      {
        id: 2,
        type: "title",
        name: "",
        icon: "fa fa-tags fa fa-white",
        title: t("purpose_of_use.category"),
        titleValue: "利用目的",
      },
      {
        id: 3,
        type: "text",
        name: "",
        icon: "",
        title: t("purpose_of_use.title"),
      },

      {
        id: 4,
        type: "supanavi",
        name: "supanavi_id",
        icon: "",
        value: "",
        title: t("purpose_of_use.supanavi_id"),
        subTitle: t("purpose_of_use.sub_title"),
      },
      {
        id: 5,
        type: "supanavi",
        name: "seo_text",
        icon: "fa fa-text-background",
        value: "",
        title: t("purpose_of_use.seo_text"),
      },
      {
        id: 6,
        type: "color",
        name: "color",
        icon: "",
        title: t("purpose_of_use.color"),
        subTitle: "この色をカラーコーディングに使用します。",
      },
      {
        id: 7,
        type: "note",
        name: "",
        icon: "",
        value: "",
        title: t("purpose_of_use.notes_optional"),
      },
      {
        id: 8,
        type: "select",
        name: "equipment_information_ids",
        icon: "",
        value: "",
        title: t("purpose_of_use.equipment_information"),
      },
      {
        id: 9,
        type: "select",
        name: "equipment_information_ids_mobile",
        icon: "",
        value: "",
        title: t("purpose_of_use.equipment_information_mobile"),
      },
      {
        id: 10,
        type: "select",
        name: "equipment_information_icons_ids",
        icon: "",
        value: "",
        title: t("purpose_of_use.equipment_information_icon"),
      },
    ];
    const listForm = computed(() => {
      if (isUsePurposeCategory.value) {
        return newEdit.slice();
      } else {
        return newEdit.slice(0, 5);
      }
    });

    const onSubmit = async (values) => {
      const checkRequired = isRequired(
        {
        //   title_en: values.title_en,
          title_ja: values.title_ja.replace(/\s+/g, ''),
        //   title_jp: values.title_jp,
        },
        errors
      );
      if (!checkRequired) return;
      const equipment_information_icons_ids = formData.equipment_information_icons_ids.map((item) => item?.id || item);
      const equipment_information_ids = formData.equipment_information_ids.map((item) => item?.id || item);
      const equipment_information_ids_mobile = formData.equipment_information_ids_mobile.map(
        (item) => item?.id || item
      );
      const active = formData.active;
      const params = {
        equipment_information_icons_ids,
        equipment_information_ids,
        equipment_information_ids_mobile,
        active,
        attribute: {
          ...values,
        },
      };
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        if (props.actionType == ACTIONS_TYPE.UPDATE) {
          await updatePurposeOfUse(idPurposeOfUse, params);
        } else {
          await createPurposeUse(categoryId.value, params);
        }
        handleBack();
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    const getListEquipmentFromApi = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getListEquipment();
        optionEquipment.value = res;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    const mapData = (data) => {
      formValues.title_en = data.title_en;
      formValues.title_ja = data.title_ja;
      formValues.title_jp = data.title_jp;
      formValues.supanavi_id = data.supanavi_id;
      formValues.seo_text = data.seo_text;
      formValues.note_en = data.note_en;
      formValues.note_jp = data.note_jp;
      formValues.color = data.color;
      formData.active = data.active;
      formData.equipment_information_icons_ids = data.equipment_information_icons_ids;
      formData.equipment_information_ids = data.equipment_information_ids;
      formData.equipment_information_ids_mobile = data.equipment_information_ids_mobile;
    };

    const getDetailPurposeOfUseFromApi = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getDetailPurposeOfUse(idPurposeOfUse);
        mapData(res);
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    const initData = async () => {
      getListEquipmentFromApi();
      if (props.actionType == ACTIONS_TYPE.UPDATE) {
        getDetailPurposeOfUseFromApi();
      }
    };

    initData();
    return {
      textColor,
      listForm,
      isEmpty,
      onSubmit,
      optionPublicAndPrivate,
      formData,
      categoryName,
      isUsePurposeCategory,
      optionEquipment,
      formValues,
      ACTIONS_TYPE,
      errors,
    };
  },
};
</script>

<style lang="scss" scoped></style>
