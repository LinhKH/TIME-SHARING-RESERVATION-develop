<template>
  <HeaderSpaces
    :title="$t('space_approval.title')"
    :textHelp="$t('space_approval.textHelp')"
    :textLink="$t('spaces_image_page.preview_of_public_page')"
    :textHelpTop="$t('spaces_image_page.text_desc_1')"
  />
  <div
    v-if="type === 'admin'"
    class="px-2 py-1 cursor-pointer flex items-center mt-5 w-full border border-solid border-[#d43f3a] rounded"
    @click="isShowOption = !isShowOption"
  >
    <div>
      <div class="text-[#d43f3a] font-bold">{{ $t("space_approval.status_private") }}</div>
      <div>{{ $t("space_approval.draft_unpublished") }}</div>
    </div>
    <div class="ml-auto">
      <i class="fa fa-chevron-down"></i>
    </div>
  </div>
  <div v-if="isShowOption && type === 'admin'" class="w-full mt-1 border border-solid border-[#ddd] rounded p-2">
    <div class="p-2 text-sm cursor-pointer hover:bg-[#eee] rounded" @click="handlePublic">
      <div class="text-[#37a200] border border-solid border-[#37a200] rounded">
        {{ $t("space_approval.change_to_publishing") }}
      </div>
      <div>{{ $t("space_approval.released") }}</div>
    </div>
    <div class="p-2 text-sm bg-[#fff26d] cursor-pointer rounded" @click="isShowOption = false">
      <div class="text-[#d43f3a] border border-solid border-[#d43f3a] rounded">
        {{ $t("space_approval.currently_private") }}
      </div>
      <div>{{ $t("space_approval.draft_unpublished") }}</div>
    </div>
  </div>

  <div v-if="type !== 'admin'">
    <br />
    <h1>{{ $t("space_approval.no_permission") }}</h1>
  </div>

  <button
    @click="handleBack"
    class="block w-fit p-2 bg-[#555] text-white mt-4 rounded-xl cursor-pointer mx-auto hover:translate-y-1 transition-all"
  >
    {{ $t("spaces_image_page.return") }}
  </button>
</template>

<script>
import HeaderSpaces from "@/components/HeaderSpaces";
import { MODULE_STORE, STEP_CREATE_SPACE, ROUTER_PATH, STATUS_SPACE } from "@/const";
import { useStore } from "vuex";
import { ref, inject } from "vue";
import { changeStatusPublic } from "@/api";
import { useRouter, useRoute } from "vue-router";
import { useI18n } from "vue-i18n";

export default {
  name: "SpaceApproval",
  components: { HeaderSpaces },
  setup() {
    const isShowOption = ref(false);
    const type = localStorage.getItem("type");
    const store = useStore();
    const router = useRouter();
    const route = useRoute();
    const { t } = useI18n();
    const idSpace = route.params.id || route.query.id;
    const toast = inject("$toast");
    const handlePublic = async () => {
      const params = {
        status: STATUS_SPACE.PUBLIC,
      };
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await changeStatusPublic(params, idSpace);
        router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}`);
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        isShowOption.value = false;
      }
    };
    const handleBack = () => {
      router.push(`${ROUTER_PATH.SPACE.EMAIL_MESSAGE}?id=${idSpace}`);
    };
    store.dispatch(
      `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE}`,
      STEP_CREATE_SPACE.APPROVE
    );

    return { isShowOption, handlePublic, handleBack, type };
  },
};
</script>

<style scoped></style>
