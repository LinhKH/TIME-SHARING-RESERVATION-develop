<template>
  <div class="font-serif">
    <div v-if="isSuccess" class="bg-[#dff0d8] border border-solid border-[#d6e9c6] px-[10px] py-[12px] my-3">
      <i class="fa fa-check text-[#3c763d] mr-[5px]"></i>
      <span class="text-[12px] text-[#3c763d]">{{ $t("form_setting_news.success") }}</span>
    </div>
    <MenuForm :listMenus="listMenus" :textColor="textColor" />
    <div v-if="!isEmpty(errors)">
      <div class="text-start text-[16px] bg-[#f2dede] p-2.5 mb-[10px]">
        <h1 class="text-[#a94442]">
          {{ $t("space_tour.error_notification") }}
        </h1>
      </div>
      <div class="text-start text-[16px] mb-[5px]">
        <p class="text-[#a94442] my-[5px]" v-for="(error, index) in errors" :key="index">
          {{ error }}
        </p>
      </div>
    </div>
    <form @submit="submitForm">
      <div v-for="(newEditItem, index) in newEdit" :key="index" class="flex items-start justify-start mb-[8px]">
        <div class="flex items-center justify-start w-[17%]">
          <i class="font-bold mr-[2px]" :class="newEditItem.icon"></i>
          <span class="font-bold translate-y-px">{{ newEditItem.title }}</span>
        </div>
        <div class="">
          <div v-if="newEditItem.type === 'RadioStatus'" class="flex items-center justify-start">
            <label class="flex items-center justify-start mr-[20px]">
              <Field
                type="radio"
                :name="newEditItem.name"
                value="1"
                v-model="newDetail.status"
                class="translate-y-[-1px] mr-[4px]"
              />
              {{ newEditItem.inputRadio1 }}
            </label>
            <label class="flex items-center justify-start">
              <Field
                type="radio"
                checked
                :name="newEditItem.name"
                value="2"
                v-model="newDetail.status"
                class="translate-y-[-1px] mr-[4px]"
              />
              {{ newEditItem.inputRadio2 }}
            </label>
          </div>
          <div v-if="newEditItem.type === 'Radio'" class="flex items-center justify-start">
            <label class="flex items-center justify-start mr-[20px]">
              <Field
                type="radio"
                :name="newEditItem.name"
                value="1"
                v-model="newDetail.link_destination"
                class="translate-y-[-1px] mr-[4px]"
              />
              {{ newEditItem.inputRadio1 }}
            </label>
            <label class="flex items-center justify-start">
              <Field
                type="radio"
                checked
                :name="newEditItem.name"
                value="2"
                v-model="newDetail.link_destination"
                class="translate-y-[-1px] mr-[4px]"
              />
              {{ newEditItem.inputRadio2 }}
            </label>
          </div>
          <div v-if="newEditItem.type === 'radioCategory'" class="flex items-center justify-start break-words">
            <div v-for="idItem in categoryList" :key="idItem.id">
              <label :for="idItem.name" class="flex items-center justify-start mr-[20px]">
                <Field
                  type="radio"
                  name="category_id"
                  :value="idItem.id"
                  v-model="newDetail.category_id"
                  class="translate-y-[-1px] mr-[4px]"
                />
                {{ idItem.name }}
              </label>
            </div>
          </div>
          <div v-if="newEditItem.type === 'radioTargetPerson'" class="flex items-center justify-start">
            <label class="flex items-center justify-start mr-[20px]">
              <Field
                type="radio"
                checked
                :name="newEditItem.name"
                value="1"
                v-model="newDetail.target_person"
                class="translate-y-[-1px] mr-[4px]"
              />
              {{ newEditItem.inputRadio1 }}
            </label>
            <label class="flex items-center justify-start mr-[20px]">
              <Field
                type="radio"
                :name="newEditItem.name"
                value="2"
                v-model="newDetail.target_person"
                class="translate-y-[-1px] mr-[4px]"
              />
              {{ newEditItem.inputRadio2 }}
            </label>
            <label class="flex items-center justify-start">
              <Field
                type="radio"
                :name="newEditItem.name"
                value="3"
                v-model="newDetail.target_person"
                class="translate-y-[-1px] mr-[4px]"
              />
              {{ newEditItem.inputRadio3 }}
            </label>
          </div>
          <div v-if="newEditItem.type === 'textTitle'" class="flex items-start justify-start flex-col">
            <div class="w-full border border-solid border-[#ddd] rounded flex h-8">
              <Field
                type="text"
                :name="newEditItem.name"
                v-model="newDetail.title"
                class="outline-none py-[5px] px-[10px] rounded w-full"
              />
            </div>
          </div>
          <div v-if="newEditItem.type === 'textLink'" class="flex items-start justify-start flex-col">
            <div class="w-full border border-solid border-[#ddd] rounded flex h-8">
              <Field
                type="text"
                :name="newEditItem.name"
                v-model="newDetail.link"
                class="outline-none py-[5px] px-[10px] rounded w-full"
              />
            </div>
          </div>
          <div v-if="newEditItem.type === 'text1'" class="flex items-start justify-start flex-col">
            <div class="w-full border border-solid border-[#ddd] rounded flex h-8">
              <Field
                type="text"
                :name="newEditItem.name"
                v-model="newDetail.tracking_category"
                class="outline-none py-[5px] px-[10px] rounded w-full"
              />
            </div>
          </div>
          <div v-if="newEditItem.type === 'text2'" class="flex items-start justify-start flex-col">
            <div class="w-full border border-solid border-[#ddd] rounded flex h-8">
              <Field
                type="text"
                :name="newEditItem.name"
                v-model="newDetail.tracking_label"
                class="outline-none py-[5px] px-[10px] rounded w-full"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="text-center mb-[8px]">
        <button
          @click="handleSubmit"
          class="group bg-[#ffbd00] border border-solid border-[#ffbd00] px-[12px] py-[6px] rounded shadow-[0_1px_1px_0_#a4966e] translate-y-0 hover:translate-y-1 transition-all"
        >
          <span class="text-[14px] text-[#fff]"> {{ $t("form_setting_news.keep") }}</span>
        </button>

        <button
          class="bg-[#d43f3a] px-[12px] py-[6px] border border-solid border-[#d43f3a] rounded shadow-[0_1px_1px_0_#a4966e] translate-y-0 hover:translate-y-1 transition-all ml-[10px] group"
        >
          <span class="text-[14px] text-[#fff]"> {{ $t("form_setting_news.delete") }}</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import MenuForm from "@/components/MenuForm";
import { Field } from "vee-validate";
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import { MODULE_STORE, PAGE_DEFAULT } from "@/const";
import { useRouter, useRoute } from "vue-router";
import { ref, inject } from "vue";
import { createFooterLinksApi, updateFooterLinksApi, getDetailFooterLinksApi, getListCategoryFooterApi } from "@/api";
import { useForm } from "vee-validate";

import { isEmpty } from "lodash";
import * as Yup from "yup";
import Input from "@/components/Form/Input.vue";
export default {
  name: "FooterLinkDetail",
  components: {
    MenuForm,
    Field,
    Input,
  },
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    const isSuccess = ref(false);
    const toast = inject("$toast");
    const textColor = ref("#555");
    const status = ref();
    const id = route.query.id;
    const newDetail = ref({});
    const categoryList = ref([]);
    const listMenus = [
      {
        id: 1,
        active: true,
        icon: "fa fa-info-circle",
        text: t("footer_link.detail"),
        link: ``,
      },
    ];
    const newEdit = [
      {
        id: 1,
        type: "RadioStatus",
        name: "status",
        icon: "",
        title: t("footer_link.public_private"),
        inputRadio1: "非公開",
        inputRadio2: "公開",
      },
      {
        id: 2,
        type: "radioCategory",
        name: "category_id",
        icon: "fa fa-tags fa fa-white",
        title: t("footer_link.category"),
        inputRadio1: "",
      },
      {
        id: 3,
        type: "radioTargetPerson",
        name: "target_person",
        icon: "",
        title: t("footer_link.display_target_person"),
        inputRadio1: "全員",
        inputRadio2: "ログイン閲覧者",
        inputRadio3: "非ログイン閲覧者",
      },

      {
        id: 4,
        type: "textTitle",
        name: "title",
        icon: "",
        value: "",
        title: t("footer_link.title"),
      },
      {
        id: 5,
        type: "textLink",
        name: "link",
        icon: "",
        value: "",
        title: t("footer_link.link"),
      },
      {
        id: 6,
        type: "Radio",
        name: "link_destination",
        icon: "",
        title: t("footer_link.link_destination"),
        inputRadio1: "新しいページを開かない ",
        inputRadio2: "新しいページで開く ",
      },
      {
        id: 7,
        type: "text1",
        name: "tracking_category",
        icon: "",
        value: "",
        title: t("footer_link.google_analytics_event"),
      },
      {
        id: 8,
        type: "text2",
        name: "tracking_label",
        icon: "",
        value: "",
        title: t("footer_link.google_analytics_event"),
      },
    ];
    const { handleSubmit, errors } = useForm({
      initialValues: {},
      validationSchema: Yup.object().shape({
        title: Yup.string().required(t("space_tour.message_date_time")),
      }),
    });
    const submitForm = handleSubmit(async (val) => {
      if (id) {
        updateFooterLinks(val);
      } else {
        createFooterLinks(val);
      }
    });
    const getListCategoryFooter = async (page = PAGE_DEFAULT) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getListCategoryFooterApi(page);
        categoryList.value = res?.data?.filter((c) => c.status && c.status == "2") || [];
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    getListCategoryFooter();

    const createFooterLinks = async (val) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await createFooterLinksApi({
          status: val.status,
          title: val.title,
          link: val.link,
          category_id: val.category_id,
          target_person: val.target_person,
          link_destination: val.link_destination,
          tracking_category: val.tracking_category,
          tracking_label: val.tracking_label,
        });
        isSuccess.value = true;
        toast.success(t("form_setting_news.success"));
        router.push({ name: "footer-link" });
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const updateFooterLinks = async (val) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await updateFooterLinksApi(id, {
          status: val.status,
          title: val.title,
          link: val.link,
          category_id: val.category_id,
          target_person: val.target_person,
          link_destination: val.link_destination,
          tracking_category: val.tracking_category,
          tracking_label: val.tracking_label,
        });
        isSuccess.value = true;
        toast.success(t("form_setting_news.success"));
        router.push({ name: "footer-link" });
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const getDetailFooterLinks = async () => {
      if (id) {
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          newDetail.value = await getDetailFooterLinksApi(id);
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
      }
    };
    getDetailFooterLinks();
    return {
      listMenus,
      submitForm,
      errors,
      isEmpty,
      newEdit,
      textColor,
      createFooterLinks,
      isSuccess,
      status,
      id,
      updateFooterLinks,
      getDetailFooterLinks,
      newDetail,
      categoryList,
    };
  },
};
</script>

<style></style>
