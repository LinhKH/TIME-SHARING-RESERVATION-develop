<template>
  <form @submit="submitForm">
    <div v-if="isSuccess" class="bg-[#dff0d8] border border-solid border-[#d6e9c6] px-2.5 py-3 my-3">
      <i class="fa fa-check text-[#3c763d] mr-[5px]"></i>
      <span class="text-[12px] text-[#3c763d]">{{ $t("form_setting_news.success") }}</span>
    </div>
    <ErrorMessage class="text-[red] font-bold" name="name" />
    <div v-for="(newEditItem, index) in newEdit" :key="index" class="flex items-start justify-start mb-2">
      <div class="flex items-center justify-start w-[17%]">
        <i class="font-bold mr-0.5" :class="newEditItem.icon"></i>
        <span class="font-bold translate-y-px">{{ newEditItem.title }}</span>
      </div>
      <div class="w-full">
        <div v-if="newEditItem.type === 'radio'" class="flex items-center justify-start">
          <label class="flex items-center justify-start mr-5">
            <Field
              type="radio"
              :name="newEditItem.name"
              class="translate-y-[-1px] mr-1"
              v-model="newDetail.status"
              value="1"
            />
            {{ newEditItem.inputRadio1 }}
          </label>
          <label class="flex items-center justify-start">
            <Field
              type="radio"
              checked
              :name="newEditItem.name"
              class="translate-y-[-1px] mr-1"
              v-model="newDetail.status"
              value="2"
            />
            {{ newEditItem.inputRadio2 }}
          </label>
        </div>
        <div v-if="newEditItem.type === 'text'" class="flex items-start justify-start flex-col">
          <div class="w-full border border-solid border-[#ddd] rounded flex h-8">
            <Field
              type="text"
              :name="newEditItem.name"
              v-model="newDetail.name"
              class="outline-none py-[5px] px-[10px] rounded w-full"
            />
          </div>
        </div>
      </div>
    </div>
    <div class="text-left ml-[14.5%] mb-2">
      <button
        @click="handleSubmit"
        class="group bg-[#ffbd00] border border-solid border-[#ffbd00] px-3 py-1.5 rounded shadow-[0_1px_1px_0_#a4966e] translate-y-0 hover:translate-y-1 transition-all"
      >
        <span class="text-[14px] text-[#fff]"> {{ $t("form_setting_news.keep") }}</span>
      </button>
      <div class="my-2 text-[#a94442]" v-if="isRequire">{{ $t("footer_link.required") }}</div>
    </div>
  </form>
</template>

<script>
import * as Yup from "yup";
import { Field, useForm, ErrorMessage } from "vee-validate";
import { ref, inject } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import { createCategoryFooterApi, updateCategoryFooterApi, getDetailCategoryFooterApi } from "@/api";
import { MODULE_STORE } from "@/const";
export default {
  name: "FooterCategoryAdd",
  components: {
    Field,
    ErrorMessage,
  },
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    const toast = inject("$toast");
    const isSuccess = ref(false);
    const isRequire = ref(false);
    const id = route.query.id;
    const newDetail = ref({});
    const newEdit = [
      {
        id: 1,
        type: "radio",
        icon: "",
        title: t("footer_link.public_private"),
        inputRadio1: "非公開",
        inputRadio2: "公開",
        name: "status",
      },
      {
        id: 2,
        type: "text",
        name: "name",
        icon: "",
        value: "",
        title: t("footer_link.title"),
      },
    ];
    const { handleSubmit, errors } = useForm({
      initialValues: {
        name: "",
      },
      validationSchema: Yup.object().shape({
        name: Yup.string().required(t(`coupon_detail.error_require`)),
      }),
    });
    const submitForm = handleSubmit(async (val) => {
      if (id) {
        updateCategoryFooter(val);
      } else {
        createCategoryFooter(val);
      }
    });
    const createCategoryFooter = async (val) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await createCategoryFooterApi({
          name: val.name,
          status: val.status,
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
    const updateCategoryFooter = async (val) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await updateCategoryFooterApi(id, {
          name: val.name,
          status: val.status,
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
    const getDetailCategoryFooter = async () => {
      if (id) {
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          newDetail.value = await getDetailCategoryFooterApi(id);
          isRequire.value = true;
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
      }
    };
    getDetailCategoryFooter();
    return {
      id,
      newEdit,
      handleSubmit,
      submitForm,
      errors,
      createCategoryFooter,
      isSuccess,
      updateCategoryFooter,
      getDetailCategoryFooter,
      newDetail,
      isRequire,
    };
  },
};
</script>

<style></style>
