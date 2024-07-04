<template>
  <Form v-slot="{ values }" class="mt-5">
    <div class="text-[18px] font-bold">トラッキングリンク　編集</div>
    <LayoutInput customCss="mt-5" :labelText="$t('add_tracking_link.tracking_url_name')" :isRequired="true">
      <Field
        type="text"
        name="name"
        v-model="urlName"
        :rules="requiredRule"
        class="border border-solid border-[#ddd] rounded shadow-inner focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 h-9 outline-none px-2 w-[336px] max-w-full"
      />
      <ErrorMessage name="name" class="text-[red] block mt-2" />
      <div class="my-3 text-[#737373]">
        {{ $t("add_tracking_link.the_name_url") }}
      </div>
    </LayoutInput>
    <LayoutInput customCss="mt-1" labelText="スペースTOPページへのリンク">
      <div class="flex rounded border border-solid border-[#ddd] w-2/3 h-11 my-2">
        <div class="flex-1 h-full">
          <textarea
            name=""
            id="topTrackingLink"
            v-model="topPageUrl"
            readonly
            class="shadow-inner bg-[#eee] w-full h-full outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 resize-none p-2"
          />
        </div>
        <div
          class="w-[52px] h-full bg-[#ffbd00] flex items-center justify-center cursor-pointer"
          @click="() => handleCopyToClipboard('topTrackingLink')"
        >
          <i class="fa fa-files-o text-white"></i>
        </div>
      </div>
      <div class="my-3 text-[#737373]">このリンクURLを経由して予約に至った場合にマークがつきます。</div>
    </LayoutInput>
    <LayoutInput customCss="mt-1" labelText="スペース予約ページへのリンク">
      <div class="flex rounded border border-solid border-[#ddd] w-2/3 h-11 my-2">
        <div class="flex-1 h-full">
          <textarea
            name=""
            id="topTrackingLink"
            v-model="reservationPageUrl"
            readonly
            class="shadow-inner bg-[#eee] w-full h-full outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 resize-none p-2"
          />
        </div>
        <div
          class="w-[52px] h-full bg-[#ffbd00] flex items-center justify-center cursor-pointer"
          @click="() => handleCopyToClipboard('topTrackingLink')"
        >
          <i class="fa fa-files-o text-white"></i>
        </div>
      </div>
      <div class="my-3 text-[#737373]">このリンクURLを経由して予約に至った場合にマークがつきます。</div>
    </LayoutInput>
    <div class="w-fit mx-auto mt-2">
      <button class="p-2 rounded text-white bg-[#ffbd00]" @click="(event) => handleEditLink(values, event)">
        {{ $t("common.keep") }}
      </button>
    </div>
  </Form>
</template>

<script>
import { useStore } from "vuex";
import { MODULE_STORE } from "@/const";
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import {} from "@/api";
import { useRoute, useRouter } from "vue-router";
import { inject, ref, onMounted } from "vue";
import { useI18n } from "vue-i18n";
import { Field, Form, ErrorMessage } from "vee-validate";
import * as yup from "yup";
import { getDetailTrackingUrlApi, updateDetailTrackingUrlApi } from "@/api";

export default {
  name: "EditTrackingUrl",
  components: { LayoutInput, Field, Form, ErrorMessage },
  setup() {
    const store = useStore();
    const route = useRoute();
    const router = useRouter();
    const id = route.params.id;
    const linkId = route.params.linkId;
    const spaceId = route.params.spaceId;
    const toast = inject("$toast");
    const { t } = useI18n();

    const urlName = ref("");
    const topPageUrl = ref("");
    const reservationPageUrl = ref("");

    const requiredRule = yup.string().required("This is a required field");

    const handleFetchDetailUrl = async () => {
      try {
        const { data } = await getDetailTrackingUrlApi(id, linkId);
        urlName.value = data.tracking_link_name;
        topPageUrl.value = data.tracking_link_to_space_top_page;
        reservationPageUrl.value = data.tracking_link_to_space_reservation_page;
      } catch (error) {
        console.error(error);
      }
    };
    handleFetchDetailUrl();

    const handleCopyToClipboard = (idInputElement) => {
      const inputElement = document.getElementById(idInputElement);
      inputElement.select();
      navigator.clipboard.writeText(inputElement.value);
    };
    const handleEditLink = async (values, event) => {
      event.preventDefault();
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await updateDetailTrackingUrlApi(linkId, values.name);
        if (res.status == 200) {
          toast.success(t("toast_message.update_success"));
          router.push({name: "AdminTrackingUrlList", params:{id}})
        }
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    return { handleEditLink, requiredRule, handleCopyToClipboard, urlName, topPageUrl, reservationPageUrl };
  },
};
</script>

<style lang="scss" scoped></style>
