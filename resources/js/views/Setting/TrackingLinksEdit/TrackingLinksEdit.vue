<template>
  <div class="mt-[20px] mb-[10px] pb-[25px] text-[18px]">{{ $t("tracking_links_add.header") }}</div>
  <div>
    <form @submit="handleClickSubmit">
      <LayoutInput :isRequired="true" :labelText="$t('tracking_links.url_name')">
        <Field
          type="text"
          name="name"
          v-model="dataDetail.name"
          class="px-2 w-1/2 h-9 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd]"
        />
      </LayoutInput>
      <div class="pl-[256px]">
        <ErrorMessage class="text-[red]" name="name" />
        <div class="font-medium my-[10px]">{{ $t("tracking_links_add.sub_input") }}</div>
      </div>
      <LayoutInput :labelText="$t('tracking_links.name_title')">
        <div class="w-2/3 flex justify-between border border-gray-300 rounded">
          <input
            type="text"
            class="p-4 w-full bg-[#eeeeee] border-r-[1px] border-gray-300"
            :value="dataDetail.tracking_code"
            :disabled="true"
            id="myInputEdit"
          />
          <div @click="handleCopyUrl" class="tooltip cursor-pointer text-center">
            <i class="fa fa-files-o text-[#fff]"></i>
            <span class="toolTipText">{{ $t("tracking_links.tooltip") }}</span>
          </div>
        </div>
      </LayoutInput>
      <div class="pl-[256px]">
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
import { ref, inject } from "vue";
import * as Yup from "yup";
import { useI18n } from "vue-i18n";
import { useStore } from "vuex";
import { useRouter, useRoute } from "vue-router";
import { ROUTER_PATH, MODULE_STORE } from "@/const";
import { Field, useForm, ErrorMessage } from "vee-validate";
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import { updateGlobalLinksApi, getDetailGlobalLinksApi } from "@/api";
export default {
  name: "TrackingLinksAdd",
  components: { LayoutInput, Field, ErrorMessage },
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    const toast = inject("$toast");
    const dataDetail = ref({});
    const id = route.query.id;
    const { handleSubmit, errors } = useForm({
      initialValues: {
        name: "",
      },
      validationSchema: Yup.object().shape({
        name: Yup.string().required(t(`coupon_detail.error_require`)),
      }),
    });
    const handleClickSubmit = handleSubmit(async (val) => {
      updateGlobalLinks(val);
      router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.TRACKING_LINKS}`);
    });
    const updateGlobalLinks = async (val) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await updateGlobalLinksApi(id, {
          name: val.name,
        });
        toast.success("Update successful!");
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const getDetailGlobalLinks = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getDetailGlobalLinksApi(id);
        dataDetail.value = res;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const handleCopyUrl = () => {
      const copyText = document.getElementById("myInputEdit");
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      navigator.clipboard.writeText(copyText.value);
    };
    getDetailGlobalLinks();
    return { id, handleClickSubmit, errors, handleSubmit, dataDetail, updateGlobalLinks, handleCopyUrl };
  },
};
</script>

<style scoped>
.tooltip {
  position: relative;
  display: inline-block;
  width: 50px;
  padding: 6px 12px;
  background: #ffbd00;
}

.tooltip .toolTipText {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 10px 0;
  position: absolute;
  z-index: 1;
  top: 5px;
  left: 110%;
}

.tooltip .toolTipText::after {
  content: "";
  position: absolute;
  top: 50%;
  right: 100%;
  margin-top: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: transparent black transparent transparent;
}
.tooltip:hover .toolTipText {
  visibility: visible;
}
</style>
