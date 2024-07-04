<template>
  <div class="flex justify-end">
    <ButtonAddNew :text="$t('common.add_new')" @clickBtn="gotoCreate" />
  </div>
  <table class="w-full mt-2">
    <thead>
      <tr>
        <th class="text-left p-2 w-1/5">{{ $t("setting_email.email_type") }}</th>
        <th class="text-left p-2 w-1/5">{{ $t("setting_email.email_subject") }}</th>
        <th class="text-left p-2 w-1/5">{{ $t("setting_email.content") }}</th>
        <th class="text-left p-2">{{ $t("setting_email.memo") }}</th>
      </tr>
    </thead>
    <tbody>
      <tr
        class="odd:bg-[#f9f9f9]"
        v-for="(itemEmailTemplate, indexEmailTemplate) in listEmailTemplate"
        :key="indexEmailTemplate"
      >
        <td class="text-[#337ab7] p-2">
          <router-link class="hover:underline" :to="`${urlEdit}/?idEmailTemplate=${itemEmailTemplate.id}`">
            {{ itemEmailTemplate.email_type }}
          </router-link>
        </td>
        <td class="text-[#337ab7] p-2">
          <router-link class="hover:underline" :to="`${urlEdit}/?idEmailTemplate=${itemEmailTemplate.id}`">
            {{ itemEmailTemplate.email_subject_jp || itemEmailTemplate.email_subject_en }}
          </router-link>
        </td>
        <td class="p-2">
          <router-link
            class="hover:underline"
            :to="`${urlEdit}/?idEmailTemplate=${itemEmailTemplate.id}`"
            v-html="itemEmailTemplate.content_jp || itemEmailTemplate.content_en"
          >
          </router-link>
        </td>
        <td class="text-[#337ab7] p-2">
          <router-link class="hover:underline" :to="`${urlEdit}/?idEmailTemplate=${itemEmailTemplate.id}`">
            {{ itemEmailTemplate.memo_jp || itemEmailTemplate.memo_en }}
          </router-link>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
import ButtonAddNew from "@/components/Buttons/ButtonAddNew";
import { ROUTER_PATH, MODULE_STORE } from "@/const";
import { useRouter } from "vue-router";
import { getAllEmailTemplate } from "@/api";
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import { inject, ref } from "vue";

export default {
  name: "SettingEmailTemplate",
  components: { ButtonAddNew },
  setup() {
    const router = useRouter();
    const store = useStore();
    const { t } = useI18n();
    const toast = inject("$toast");
    const listEmailTemplate = ref([]);
    const gotoCreate = () =>
      router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.EMAIL_TEMPLATE_ADD}`);
    const initData = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getAllEmailTemplate();
        listEmailTemplate.value = res.data;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    const urlEdit = `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.EMAIL_TEMPLATE_EDIT}`;
    initData();
    return { ROUTER_PATH, gotoCreate, listEmailTemplate, urlEdit };
  },
};
</script>
<style lang="scss" scoped>
td,
th {
  border: 1px solid #ddd;
}
</style>
