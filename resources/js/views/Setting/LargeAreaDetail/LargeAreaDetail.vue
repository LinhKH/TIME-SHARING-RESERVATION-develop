<template>
  {{ formData.attribute.user_display }}
  <div class="font-serif">
    <MenuForm :listMenus="listMenus" :textColor="textColor" @handleActiveMenu="handleActiveMenu" />
    <div
      v-if="isSuccess && errorMessage === false"
      class="bg-[#dff0d8] border border-solid border-[#d6e9c6] px-[10px] py-[12px]"
    >
      <i class="fa fa-check text-[#3c763d] mr-[5px]"></i>
      <span class="text-[12px] text-[#3c763d]">{{ $t("form_setting_news.success") }}</span>
    </div>
    <div v-if="errorMessage">
      <div class="text-start text-[16px] mb-[5px]">
        <p class="text-[#a94442] my-[5px]">どの言語にも入力データがありません。</p>
      </div>
    </div>
    <form @submit="submitForm" class="mt-[15px]">
      <div v-for="(largeAreaItem, index) in largeArea" :key="index" class="flex items-start justify-start mb-[8px]">
        <div class="flex items-center justify-start w-[17%]">
          <span
            class="text-[10px] bg-[#ff4b55] text-[#fff] py-[1px] px-[6px] rounded font-bold"
            v-if="largeAreaItem.isRequired"
            >必須</span
          >
          <i class="font-bold mr-[2px]" :class="largeAreaItem.icon"></i>
          <span class="font-bold translate-y-px">{{ largeAreaItem.title }}</span>
        </div>
        <div class="w-[100%] ml-[15px]">
          <div v-if="largeAreaItem.type === 'Radio'">
            <div class="flex items-center justify-start">
              <label class="flex items-center justify-start mr-[20px]">
                <input
                  type="radio"
                  :checked="detailLargeArea.active === 1"
                  :name="largeAreaItem.name"
                  :value="largeAreaItem.inputRadio1"
                  class="translate-y-[-1px] mr-[4px]"
                  @click="handleRadioActive(1)"
                />
                {{ largeAreaItem.inputRadio1 }}
              </label>
              <label class="flex items-center justify-start">
                <input
                  type="radio"
                  :checked="detailLargeArea.active === 2 || true"
                  :name="largeAreaItem.name"
                  :value="largeAreaItem.inputRadio2"
                  class="translate-y-[-1px] mr-[4px]"
                  @click="handleRadioActive(2)"
                />
                {{ largeAreaItem.inputRadio2 }}
              </label>
            </div>
            <span v-if="largeAreaItem.subTitle" class="text-[11px] text-[#737373] mt-[6px] block">
              {{ largeAreaItem.subTitle }}
            </span>
          </div>

          <div v-if="largeAreaItem.type === 'select'" class="relative">
            <SelectInput
              :listOption="largeAreList"
              @getParentId="getParentId"
              :parentTitle="parentTitle"
              @handleValueInput="handleValueInput"
            />
          </div>

          <div v-if="largeAreaItem.type === 'text'" class="flex items-start justify-start flex-col">
            <div class="w-full border border-solid border-[#ddd] rounded flex h-8 mb-[4px]">
              <div class="flex items-center justify-center border-r border-solid border-[#ddd] w-10 bg-[#eee]">
                <img :src="JapanIcon" alt="japan" class="w-9 object-cover" />
              </div>
              <Field
                type="text"
                name="title1"
                class="outline-none p-[5px] rounded-r w-full"
                placeholder="Party"
                v-model="formData.title__en"
                @input="handleInput"
              />
            </div>
            <div class="w-full border border-solid border-[#ddd] rounded flex h-8 mb-[4px]">
              <div class="flex items-center justify-center border-r border-solid border-[#ddd] w-10 bg-[#eee]">
                <img :src="JapanIcon" alt="japan" class="w-9 object-cover" />
              </div>
              <Field
                type="text"
                name="title2"
                class="outline-none p-[5px] rounded-r w-full"
                :placeholder="$t('large_area.placeholder_title_japan')"
                v-model="formData.title__ja"
                @input="handleInput"
              />
            </div>
            <div class="w-full border border-solid border-[#ddd] rounded flex h-8">
              <div class="flex items-center justify-center border-r border-solid border-[#ddd] w-10 bg-[#eee]">
                <img :src="JapanIcon" alt="japan" class="w-9 object-cover" />
              </div>
              <Field
                type="text"
                name="title3"
                class="outline-none p-[5px] rounded-r w-full"
                :placeholder="$t('large_area.placeholder_title_ja_kana')"
                v-model="formData.title__ja_kana"
                @input="handleInput"
              />
            </div>
            <span v-if="largeAreaItem.subTitle" class="text-[11px] text-[#737373] mt-[6px]">
              {{ largeAreaItem.subTitle }}
            </span>
          </div>

          <div v-if="largeAreaItem.type === 'textarea'" class="flex items-start justify-start flex-col">
            <div class="w-full border border-solid border-[#ddd] rounded flex h-14">
              <Field name="textarea1">
                <textarea
                  type="textarea"
                  class="outline-none p-[5px] rounded w-full px-[10px]"
                  v-model="formData.attribute.ranking_text"
                />
              </Field>
            </div>
            <span v-if="largeAreaItem.subTitle" class="text-[11px] text-[#737373] mt-[6px]">
              {{ largeAreaItem.subTitle }}
            </span>
          </div>

          <div v-if="largeAreaItem.type === 'textInput1'" class="flex items-start justify-start flex-col">
            <div class="w-full border border-solid border-[#ddd] rounded flex h-8">
              <Field
                type="text"
                class="outline-none p-[5px] rounded w-full px-[10px]"
                :name="largeAreaItem.name"
                v-model="formData.legacy_id"
              />
            </div>
          </div>
          <div v-if="largeAreaItem.type === 'textInput2'" class="flex items-start justify-start flex-col">
            <div class="w-full border border-solid border-[#ddd] rounded flex h-8">
              <Field
                type="text"
                class="outline-none p-[5px] rounded w-full px-[10px]"
                :name="largeAreaItem.name"
                v-model="formData.identifier"
              />
            </div>
            <span v-if="largeAreaItem.subTitle" class="text-[11px] text-[#737373] mt-[6px]">
              {{ largeAreaItem.subTitle }}
            </span>
          </div>
          <div v-if="largeAreaItem.type === 'Radio2'">
            <div class="flex items-center justify-start">
              <label class="flex items-center justify-start mr-[20px]">
                <input
                  type="radio"
                  :checked="formData.attribute.user_display === '1'"
                  :name="largeAreaItem.name"
                  :value="largeAreaItem.inputRadio1"
                  class="translate-y-[-1px] mr-[4px]"
                  @click="handleUserDisplay(1)"
                />
                {{ largeAreaItem.inputRadio1 }}
              </label>
              <label class="flex items-center justify-start">
                <input
                  type="radio"
                  :checked="formData.attribute.user_display === '2' || true"
                  :name="largeAreaItem.name"
                  :value="largeAreaItem.inputRadio2"
                  class="translate-y-[-1px] mr-[4px]"
                  @click="handleUserDisplay(2)"
                />
                {{ largeAreaItem.inputRadio2 }}
              </label>
            </div>
            <span v-if="largeAreaItem.subTitle" class="text-[11px] text-[#737373] mt-[6px] block">
              {{ largeAreaItem.subTitle }}
            </span>
          </div>
          <!-- <div v-if="largeAreaItem.type === 'selectCustom'" class="flex items-start justify-start flex-col relative">
            <SelectPurposeUseVue :optionEquipment="largeAreList" />
          </div> -->
          <div v-if="largeAreaItem.type === 'checkbox'">
            <div class="flex items-center justify-start">
              <label class="flex items-center justify-start mr-[20px] font-bold">
                <input
                  type="checkbox"
                  class="translate-y-[-1px] mr-[4px]"
                  :name="largeAreaItem.name"
                  v-model="formData[largeAreaItem.name]"
                  true-value="true"
                  false-value="false"
                  :checked="formData.attribute[largeAreaItem.name] === 'true'"
                />
                {{ largeAreaItem.titleCheckbox }}
              </label>
            </div>
            <span v-if="largeAreaItem.subTitle" class="text-[11px] text-[#737373] mt-[6px] block">
              {{ largeAreaItem.subTitle }}
            </span>
          </div>

          <div v-if="largeAreaItem.type === 'Custom'">
            <div class="flex items-center justify-between">
              <div v-for="(customItem, index) in largeAreaItem.valueCustom" :key="index" class="">
                <div>
                  <span class="text-[12px]">{{ customItem.title }}</span
                  ><i
                    class="tooltip mx-[3px] cursor-pointer text-[#337ab7] text-[12px] hover:text-[#23527c] transition-all"
                    :class="customItem.icon"
                    ><span class="tooltiptext">{{ customItem.tooltip }}</span></i
                  >
                  <span class="ml-[20px] text-[12px]" v-if="customItem.title2">{{ customItem.title2 }}</span>
                </div>
              </div>
            </div>
            <hr class="my-[20px]" />
            <hr class="mt-[40px] mb-[20px]" />
            <SelectInput />
            <hr class="my-[20px]" />
          </div>
        </div>
      </div>
      <div class="text-center mb-[8px]">
        <button
          @click="handleSubmit"
          class="group bg-[#fff] hover:bg-[#ffbd00] border border-solid border-[#ffbd00] px-[12px] py-[6px] rounded shadow-[0_1px_1px_0_#a4966e] translate-y-0 hover:translate-y-1 transition-all"
        >
          <span class="text-[14px] text-[#ffbd00] group-hover:text-[#fff]"> {{ $t("form_setting_news.keep") }}</span>
        </button>
        <button
          v-if="id || newId"
          @click="(event) => deleteLargeAre(event)"
          class="bg-[#fff] hover:bg-[#d43f3a] px-[12px] py-[6px] border border-solid border-[#d43f3a] rounded shadow-[0_1px_1px_0_#a4966e] translate-y-0 hover:translate-y-1 transition-all ml-[10px] group"
        >
          <span class="text-[14px] text-[#d43f3a] group-hover:text-[#fff]"> {{ $t("form_setting_news.delete") }}</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import MenuForm from "@/components/MenuForm";
import JapanIcon from "@/assets/images/japan.png";
import SelectPurposeUseVue from "../PurposeDetail/child/SelectPurposeUse.vue";

import SelectInput from "./SelectInput.vue";

import {
  getDetailLargeAreaApi,
  getListLargeArea,
  addLargeAreaApi,
  updateLargeAreaApi,
  deleteLargeAreaApi,
} from "@/api";

import { useI18n } from "vue-i18n";
import { Form, Field } from "vee-validate";
import { useForm } from "vee-validate";
import { isEmpty } from "lodash";
import * as Yup from "yup";
import { useStore } from "vuex";
import { useRouter, useRoute } from "vue-router";
import { ref, computed, inject, reactive } from "vue";
import { ROUTER_PATH, MODULE_STORE } from "@/const";

export default {
  name: "Detail Large",
  components: {
    MenuForm,
    Field,
    SelectPurposeUseVue,
    SelectInput,
  },
  setup() {
    const { t } = useI18n();
    const textColor = ref("#000");
    const store = useStore();
    const route = useRoute();
    const router = useRouter();
    const id = reactive(route.query.id);
    const toast = inject("$toast");
    const detailLargeArea = ref({});
    const listLargeArea = ref();
    const isSuccess = ref(false);
    const largeAreList = ref([]);
    const parentTitle = ref(null);
    const newId = ref();
    const listMenus = ref([
      {
        id: 1,
        active: true,
        icon: "fa fa-info-circle",
        text: t("footer_link.detail"),
        link: ``,
      },
    ]);
    const largeArea = ref([
      {
        id: 1,
        type: "Radio",
        icon: "",
        name: "radio",
        title: t("large_area.public_private"),
        inputRadio1: "非公開",
        inputRadio2: "公開",
      },
      {
        id: 2,
        icon: "",
        type: "select",
        title: t("large_area.setting_parent_area"),
      },
      {
        id: 3,
        icon: "",
        type: "text",
        isRequired: true,
        title: t("large_area.large_area"),
        subTitle: t("large_area.input_assist_function"),
      },
      {
        id: 4,
        icon: "",
        type: "textarea",
        title: t("large_area.ranking_text"),
        subTitle: t("large_area.subtitle_ranking_pages"),
      },
      {
        id: 5,
        icon: "",
        type: "textInput1",
        name: "textInput1",
        title: t("large_area.old_id"),
      },
      {
        id: 6,
        icon: "",
        type: "textInput2",
        name: "textInput2",
        title: t("large_area.map_identifier"),
        subTitle: t("large_area.subtitle_map_identifier"),
      },
      {
        id: 7,
        icon: "fa fa-map-o",
        type: "Radio2",
        name: "radio2",
        title: t("large_area.use_address"),
        inputRadio1: t("large_area.no"),
        inputRadio2: t("large_area.yes"),
        subTitle: t("large_area.subtitle_use_address"),
      },
      {
        id: 8,
        icon: "",
        type: "selectCustom",
        title: t("large_area.adjacent_area"),
        valueOption: [
          {
            id: 1,
            title: "飲食",
          },
          {
            id: 2,
            title: "飲食1",
          },
          {
            id: 3,
            title: "飲食2",
          },
        ],
      },
      {
        id: 9,
        icon: "",
        type: "checkbox",
        name: "checkbox1",
        title: t("large_area.concierge_correspondence"),
        titleCheckbox: t("large_area.maybe"),
        subTitle: t("large_area.subtitle_concierge_correspondence"),
        valueCheckbox: true,
      },
      {
        id: 10,
        icon: "",
        type: "checkbox",
        name: "checkbox2",
        title: t("large_area.concierge_consultation"),
        titleCheckbox: t("large_area.maybe"),
        subTitle: t("large_area.subtitle_concierge_consultation"),
        valueCheckbox: true,
      },
      {
        id: 11,
        icon: "",
        type: "checkbox",
        name: "checkbox3",
        title: t("large_area.eating_and_drinking_arrangement"),
        titleCheckbox: t("large_area.maybe"),
        subTitle: t("large_area.subtitle_eating_arrangement"),
        valueCheckbox: false,
      },
      {
        id: 12,
        icon: "",
        type: "checkbox",
        name: "checkbox4",
        title: t("large_area.eating_and_drinking_area"),
        titleCheckbox: t("large_area.maybe"),
        subTitle: t("large_area.subtitle_eating_area"),
        valueCheckbox: true,
      },
      {
        id: 13,
        icon: "",
        type: "Custom",
        title: t("large_area.information_on_catering"),
        valueCustom: [
          {
            id: 1,
            title: "表示順",
            title2: "会社・団体名",
            icon: "fa fa-question-circle",
            tooltip: "ドラッグで表示順を変更します。予約完了画面の並びが変えられます1",
          },
          {
            id: 2,
            title: "表示順",
            title2: "",
            icon: "",
            tooltip: "",
          },
          {
            id: 3,
            title: "表示順",
            title2: "",
            icon: "",
            tooltip: "",
          },
          {
            id: 4,
            title: "表示順",
            title2: "",
            icon: "",
            tooltip: "",
          },
          {
            id: 5,
            title: "表示順",
            title2: "",
            icon: "fa fa-question-circle",
            tooltip: "ドラッグで表示順を変更します。予約完了画面の並びが変えられます2",
          },
        ],
      },
    ]);
    const listOption = ref([
      {
        id: 1,
        title: "test1",
      },
      {
        id: 2,
        title: "abc",
      },
      {
        id: 3,
        title: "check123",
      },
    ]);
    const formData = ref({
      title__en: "",
      title__ja: "",
      title__ja_kana: "",
      parent_id: null,
      identifier: null,
      legacy_id: null,
      parent_id: null,
      active: 1,
      attribute: {},
      checkbox1: false,
      checkbox2: false,
      checkbox3: false,
      checkbox4: false,
    });

    const errorMessage = ref(false);
    const { handleSubmit, errors } = useForm({
      initialValues: {},
      validationSchema: Yup.object().shape({
        // title1: Yup.string().required(t("large_area.message_input")),
        // title2: Yup.string().required(t("large_area.message_input")),
        // title3: Yup.string().required(t("large_area.message_input")),
      }),
    });

    const submitForm = handleSubmit(async (val) => {
      if (val.title1 || val.title2 || val.title3) {
        if (id || newId.value) {
          if (id) {
            updateLargeArea(val);
          }
          if (newId.value) {
            updateLargeArea1(newId.value);
          }
        } else {
          addLargeAreaItem(val);
          isSuccess.value = true;
        }
      } else {
        errorMessage.value = true;
      }
    });
    const handleActiveMenu = (id) => {
      listMenus.value.forEach((element) => {
        if (element.id === id) {
          element.active = true;
        } else {
          element.active = false;
        }
      });
    };
    const handleInput = () => {
      errorMessage.value = false;
    };
    const getDetailLargeArea = async () => {
      if (id) {
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          let res = await getDetailLargeAreaApi(id);
          detailLargeArea.value = res.data;
          formData.value = {
            ...formData.value,
            ...res.data,
          };
          checkParentItem(formData.value.parent_id);
          res.data.area_area_eavs.forEach((item) => {
            formData.value.attribute[item.attribute] = item.value;
          });
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
      }
    };
    const listAllLargeArea = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getListLargeArea();
        listLargeArea.value = res.data;
        check(listLargeArea.value);
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };

    const check = (dataValue) => {
      listAll(dataValue);
    };
    const listAll = (dataValue) => {
      dataValue.forEach((item) => {
        largeAreList.value.push(item);
        if (item.children) {
          listAll(item.children);
        }
      });
    };
    const checkParentItem = async (idParent) => {
      if (idParent !== null) {
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          let res = await getDetailLargeAreaApi(idParent);
          parentTitle.value = res.data.title__ja || res.data.title__ja_kana;
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
      }
    };

    const addLargeAreaItem = async (values) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        let res;
        const params = {
          title__en: formData.value.title__en,
          title__ja: formData.value.title__ja,
          title__ja_kana: formData.value.title__ja_kana,
          parent_id: formData.value.parent_id,
          active: formData.value.active,
          identifier: formData.value.identifier,
          legacy_id: formData.value.legacy_id,
          attribute: {
            ranking_text: formData.value.attribute.ranking_text,
            user_display: formData.value.attribute.user_display,
            checkbox1: formData.value.checkbox1,
            checkbox2: formData.value.checkbox2,
            checkbox3: formData.value.checkbox3,
            checkbox4: formData.value.checkbox4,
          },
        };
        res = await addLargeAreaApi(params);
        newId.value = res.data.id;

        router.push(
          `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.LARGE_AREA_DETAIL}/?id=${newId.value}`
        );
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const getParentId = (options) => {
      formData.value.parent_id = options.id;
      parentTitle.value = options.title__ja || options.title__ja_kana;
    };
    const handleValueInput = (data) => {
      parentTitle.value = data;
    };
    const handleRadioActive = (valueActive) => {
      formData.value.attribute = valueActive;
    };
    const handleUserDisplay = (valueActive) => {
      formData.value.attribute.user_display = valueActive;
    };

    listAllLargeArea();
    getDetailLargeArea();
    const updateLargeArea = async (values) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        let res = await updateLargeAreaApi(id, {
          title__en: formData.value.title__en,
          title__ja: formData.value.title__ja,
          title__ja_kana: formData.value.title__ja_kana,
          parent_id: formData.value.parent_id,
          active: formData.value.active,
          identifier: formData.value.identifier,
          legacy_id: formData.value.legacy_id,
          attribute: {
            ranking_text: formData.value.attribute.ranking_text,
            user_display: formData.value.attribute.user_display,
            checkbox1: formData.value.checkbox1,
            checkbox2: formData.value.checkbox2,
            checkbox3: formData.value.checkbox3,
            checkbox4: formData.value.checkbox4,
          },
        });

        isSuccess.value = true;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const updateLargeArea1 = async (idNew) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        let res = await updateLargeAreaApi(idNew, {
          title__en: formData.value.title__en,
          title__ja: formData.value.title__ja,
          title__ja_kana: formData.value.title__ja_kana,
          parent_id: formData.value.parent_id,
          active: formData.value.active,
          identifier: formData.value.identifier,
          legacy_id: formData.value.legacy_id,
          attribute: {
            ranking_text: formData.value.attribute.ranking_text,
            user_display: formData.value.attribute.user_display,
            checkbox1: formData.value.checkbox1,
            checkbox2: formData.value.checkbox2,
            checkbox3: formData.value.checkbox3,
            checkbox4: formData.value.checkbox4,
          },
        });

        isSuccess.value = true;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const deleteLargeAre = async (event) => {
      event.preventDefault();
      if (confirm("お知らせを削除してよろしいですか？")) {
        if (id) {
          try {
            store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
            await deleteLargeAreaApi(id);
            isSuccess.value = true;
          } catch (errors) {
            const error = errors.message || t("common.has_error");
            toast.error(error);
          } finally {
            store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
          }
        }
        if (newId.value) {
          try {
            store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
            await deleteLargeAreaApi(newId.value);
            isSuccess.value = true;
          } catch (errors) {
            const error = errors.message || t("common.has_error");
            toast.error(error);
          } finally {
            store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
          }
        }
        router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.AREA}`);
      }
    };

    return {
      textColor,
      listMenus,
      JapanIcon,
      id,
      largeArea,
      listOption,
      isEmpty,
      errors,
      handleSubmit,
      submitForm,
      handleActiveMenu,
      detailLargeArea,
      listAllLargeArea,
      listLargeArea,
      listAll,
      check,
      largeAreList,
      formData,
      getParentId,
      parentTitle,
      handleValueInput,
      handleRadioActive,
      deleteLargeAre,
      updateLargeArea,
      handleUserDisplay,
      newId,
      isSuccess,
      updateLargeArea1,
      errorMessage,
      handleInput,
    };
  },
};
</script>

<style scoped>
.tooltip {
  position: relative;
  display: inline-block;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 240px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
  bottom: 150%;
  left: 50%;
  margin-left: -60px;
  line-height: 1.5;
  padding: 5px;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 25%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: black transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
}
.tooltip .tooltiptext {
  opacity: 0;
  transition: opacity 1s;
}

.tooltip:hover .tooltiptext {
  opacity: 1;
}
</style>
