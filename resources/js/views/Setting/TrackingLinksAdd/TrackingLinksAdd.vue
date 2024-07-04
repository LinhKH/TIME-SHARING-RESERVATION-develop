<template>
  <div class="mt-[20px] mb-[10px] pb-[25px] text-[18px]">{{ $t("tracking_links_add.header") }}</div>
  <div>
    <form @submit="handleClickSubmit">
      <LayoutInput :isRequired="true" :labelText="$t('tracking_links.url_name')">
        <Field
          type="text"
          name="name"
          class="px-2 w-1/2 h-9 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd]"
        />
      </LayoutInput>
      <div class="pl-[256px]">
        <ErrorMessage class="text-[red]" name="name" />
        <div class="font-medium my-[10px]">{{ $t("tracking_links_add.sub_input") }}</div>
        <div class="my-[10px]">{{ $t("tracking_links_add.text_button") }}</div>
      </div>
      <div class="w-full h-full flex justify-center mt-[6px] gap-[50px]">
        <button
          class="block w-fit p-[8px] bg-[#ffbd00] text-white mr-3 rounded cursor-pointer hover:translate-y-1 transition-all"
          @click="handleSubmit"
        >
          {{ $t("tracking_links_add.submit") }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import * as Yup from "yup";
import { inject } from "vue";
import { useI18n } from "vue-i18n";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { createGlobalLinksApi } from "@/api";
import { ROUTER_PATH, MODULE_STORE } from "@/const";
import { Field, useForm, ErrorMessage } from "vee-validate";
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
export default {
  name: "TrackingLinksAdd",
  components: { LayoutInput, Field, ErrorMessage },
  setup(props, context) {
    const { t } = useI18n();
    const router = useRouter();
    const store = useStore();
    const toast = inject("$toast");
    const { handleSubmit, errors } = useForm({
      initialValues: {
        name: "",
      },
      validationSchema: Yup.object().shape({
        name: Yup.string().required(t(`coupon_detail.error_require`)),
      }),
    });
    const handleClickSubmit = handleSubmit(async (val) => {
      createGlobalLinks(val);
      context.emit("CreateSuccess")
      router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.TRACKING_LINKS}`);
    });
    const createGlobalLinks = async (val) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await createGlobalLinksApi({
          name: val.name,
        });
        toast.success("Create successful!");
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    return { handleClickSubmit, errors, handleSubmit, createGlobalLinks };
  },
};
</script>

<style></style>
